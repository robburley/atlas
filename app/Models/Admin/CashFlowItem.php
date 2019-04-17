<?php

namespace App\Models\Admin;

use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\User\Office;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class CashFlowItem extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'sales_date',
        'generated_date',
    ];

    protected $fillable = [
        'mobile_opportunity_id',
        'sales_date',
        'branch_id',
        'company_name',
        'sales_person_id',
        'lead_generator_id',
        'turnover',
        'hardware_fund',
        'hardware_fund_vat',
        'handling_fees',
        'handsets',
        'sims',
        'sim_saves',
        'delivery',
        'total_cashback',
        'total_cashback_vat',
        'board_gp',
        'additional_percent',
        'additional_pounds',
        'generated_date',
        'network',
        'number_of_lines',
        'active',
        'paid_at',
        'canceled_at',
        'declined_at',
    ];

    public function leadGenerator()
    {
        return $this->belongsTo(User::class, 'lead_generator_id');
    }

    public function salesPerson()
    {
        return $this->belongsTo(User::class, 'sales_person_id');
    }

    public function branch()
    {
        return $this->belongsTo(Office::class, 'branch_id');
    }

    public function opportunity()
    {
        return $this->belongsTo(MobileOpportunity::class, 'mobile_opportunity_id');
    }

    public function getTurnoverAttribute($value)
    {
        return $value / 100;
    }

    public function setTurnoverAttribute($value)
    {
        return $this->attributes['turnover'] = $value * 100;
    }

    public function getHardwareFundAttribute($value)
    {
        return $value / 100;
    }

    public function setHardwareFundAttribute($value)
    {
        return $this->attributes['hardware_fund'] = $value * 100;
    }

    public function getHardwareFundVatAttribute($value)
    {
        return $value / 100;
    }

    public function setHardwareFundVatAttribute($value)
    {
        return $this->attributes['hardware_fund_vat'] = $value * 100;
    }

    public function getHandlingFeesAttribute($value)
    {
        return $value / 100;
    }

    public function setHandlingFeesAttribute($value)
    {
        return $this->attributes['handling_fees'] = $value * 100;
    }

    public function getHandsetsAttribute($value)
    {
        return $value / 100;
    }

    public function setHandsetsAttribute($value)
    {
        return $this->attributes['handsets'] = $value * 100;
    }

    public function getSimsAttribute($value)
    {
        return $value / 100;
    }

    public function setSimsAttribute($value)
    {
        return $this->attributes['sims'] = $value * 100;
    }

    public function getSimSavesAttribute($value)
    {
        return $value / 100;
    }

    public function setSimSavesAttribute($value)
    {
        return $this->attributes['sim_saves'] = $value * 100;
    }

    public function getDeliveryAttribute($value)
    {
        return $value / 100;
    }

    public function setDeliveryAttribute($value)
    {
        return $this->attributes['delivery'] = $value * 100;
    }

    public function getTotalCashbackAttribute($value)
    {
        return $value / 100;
    }

    public function setTotalCashbackAttribute($value)
    {
        return $this->attributes['total_cashback'] = $value * 100;
    }

    public function getTotalCashbackVatAttribute($value)
    {
        return $value / 100;
    }

    public function setTotalCashbackVatAttribute($value)
    {
        return $this->attributes['total_cashback_vat'] = $value * 100;
    }

    public function getBoardGpAttribute($value)
    {
        return $value / 100;
    }

    public function setBoardGpAttribute($value)
    {
        return $this->attributes['board_gp'] = $value * 100;
    }

    public function getAdditionalPercentAttribute($value)
    {
        return $value / 100;
    }

    public function setAdditionalPercentAttribute($value)
    {
        return $this->attributes['additional_percent'] = $value * 100;
    }

    public function getAdditionalPoundsAttribute($value)
    {
        return $value / 100;
    }

    public function setAdditionalPoundsAttribute($value)
    {
        return $this->attributes['additional_pounds'] = $value * 100;
    }

    public function scopeActive($query)
    {
        if (request()->get('status') == 0) {
            return $query;
        }

        if (request()->get('status') == 1) {
            return $query->whereNotNull('declined_at');
        }

        if (request()->get('status') == 2) {
            return $query->whereNotNull('canceled_at');
        }

        if (request()->get('status') == 3) {
            return $query->where(function ($q) {
                $q->whereNotNull('canceled_at')
                    ->orWhereNotNull('canceled_at');
            });
        }

        if (request()->get('status') == 4) {
            return $query->whereNotNull('paid_at')
            ->whereNull('declined_at')
            ->whereNull('canceled_at');
        }

        if (request()->get('status') == 5) {
            return $query->whereNull('paid_at')
            ->whereNull('declined_at')
            ->whereNull('canceled_at');
        }

        return $query;
    }
}
