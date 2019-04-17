<?php

namespace App\Models\MobileOpportunity;

use App\Models\MobileOpportunity\DealCalculator\DealCalculator;
use App\Models\Tenders\MobileTender;
use App\Models\Tenders\MobileTenderInvitation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    protected $dates = [
        'port_date',
        'tracking_number_set_at',
        'unlocked_requested',
        'unlocked_confirmed',
        'created_at',
        'updated_at',
        'sent_for_connection',
        'date_connected',
        'contract_end_date',
    ];

    protected $fillable = [
        'id',
        'mobile_opportunity_id',
        'tariff_id',
        'tariff_name',
        'handset_id',
        'handset_name',
        'name',
        'type',
        'phone_number',
        'network_from',
        'network_to',
        'pac_code',
        'sim_number',
        'tracking_number',
        'tracking_number_set_at',
        'unlocked_requested',
        'unlocked_confirmed',
        'tendered_at',
        'tender_complete',
        'stock_ordered',
        'price_paid',
        'port_date',
        'connection_reference',
        'sent_for_connection',
        'connection_error',
        'connection_deferred',
        'connected',
        'account_number',
        'date_connected',
        'contract_end_date',
        'imei',
        'colour'
    ];

    public function handset()
    {
        return $this->belongsTo(Phone::class, 'handset_id');
    }

    public function opportunity()
    {
        return $this->belongsTo(MobileOpportunity::class, 'mobile_opportunity_id');
    }

    public function dealCalculator()
    {
        return $this->belongsTo(DealCalculator::class, 'deal_calculator_id');
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class, 'tariff_id');
    }

    public function vas()
    {
        return $this->hasMany(AllocationVas::class, 'allocation_id');
    }

    public function simNumbers()
    {
        return $this->hasMany(AllocationSimNumber::class, 'allocation_id');
    }

    public function activeSimNumbers()
    {
        return $this->hasMany(AllocationSimNumber::class, 'allocation_id')
                    ->where('active', 1);
    }

    public function errors()
    {
        return $this->hasMany(AllocationError::class, 'allocation_id');
    }

    public function setTrackingNumberAttribute($value)
    {
        $this->attributes['tracking_number_set_at'] = Carbon::now();

        return $this->attributes['tracking_number'] = $value;
    }

    public function setUnlockedRequestedAttribute($value)
    {
        return $this->attributes['unlocked_requested'] = $value == 1
            ? Carbon::now()
            : null;
    }

    public function setUnlockedConfirmedAttribute($value)
    {
        return $this->attributes['unlocked_confirmed'] = $value == 1
            ? Carbon::now()
            : null;
    }

    public function hasHandset()
    {
        return !is_null($this->handset);
    }

    public function mobileTender()
    {
        return $this->hasOne(MobileTender::class, 'allocation_id');
    }

    public function mobileTenderInvitations()
    {
        return $this->hasMany(MobileTenderInvitation::class, 'allocation_id');
    }

    public function setPricePaidAttribute($value)
    {
        return $this->attributes['price_paid'] = $value * 100;
    }

    public function getPricePaidAttribute($value)
    {
        return $value / 100;
    }

    public function portable()
    {
        return $this->type == 'Port' &&
            (
                ($this->opportunity->bcad_required == 1 && $this->opportunity->bcad_reference) ||
                $this->opportunity->bcad_required == 0
            )
            && (
                !$this->handset ||
                ($this->handset->pre_order == 0 && $this->stock_ordered) ||
                $this->handset->pre_order == 1
            )
            && $this->pac_code
            && $this->tracking_number
            && (
                (
                    !is_null($this->opportunity->bond_type) &&
                    $this->opportunity->bond_payment_reference
                ) ||
                is_null($this->opportunity->bond_type)
            );
    }

    public function connectable()
    {
        return !$this->sent_for_connection &&
                ($this->port_date ||
                (
                    ($this->type == 'New connection') &&
                    ($this->tracking_number) &&
                    (
                        ($this->opportunity->bcad_required == 1 > 0 && $this->opportunity->bcad_reference) ||
                        ($this->opportunity->bcad_required == 0)
                    )
                ))
                && (
                    (
                        !is_null($this->opportunity->bond_type) &&
                        $this->opportunity->bond_payment_reference
                    ) ||
                    is_null($this->opportunity->bond_type)
                );
    }

    public function readyForBondPayment()
    {
        return (
                    ($this->opportunity->bcad_required == 1 > 0 && $this->opportunity->bcad_reference) ||
                    ($this->opportunity->bcad_required == 0)
                )                      &&
                $this->tracking_number &&
                (
                    (
                        $this->type == 'Port' &&
                        $this->pac_code
                    ) ||
                    $this->type == 'New connection'
                );
    }

    public function pendingConnection()
    {
        return $this->sent_for_connection &&
            !$this->connection_deferred   &&
            !$this->connection_error      &&
            !$this->connected;
    }

    public function connected()
    {
        return $this->connected;
    }

    public function setDateConnectedAttribute($value)
    {
        return $this->attributes['date_connected'] = Carbon::createFromFormat('d/m/Y', $value)->startOfDay();
    }

    public function setContractEndDateAttribute($value)
    {
        return $this->attributes['contract_end_date'] = Carbon::createFromFormat('d/m/Y', $value)->startOfDay();
    }

    public function connectionRequirements()
    {
        return $this->hasMany(ConnectionRequirement::class);
    }

    public function incompleteConnectionRequirements()
    {
        return $this->hasMany(ConnectionRequirement::class)
            ->whereNull('completed_at');
    }

    public function completeconnectionRequirements()
    {
        return $this->hasMany(ConnectionRequirement::class)
            ->whereNotNull('completed_at');
    }
}
