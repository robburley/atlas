<?php

namespace App\Models\EnergyOpportunity;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerSite;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EnergyMeter extends Model
{

    protected $fillable = [
        'site_id',
        'energy_opportunity_id',
        'type',
        'number',
        'top_line',
        'bottom_line',
        'quantity',
        'day_rate',
        'night_rate',
        'current_standing_charge',
        'contract_end_date',
        'opportunity',
        'detach_opportunity',
    ];

    protected $dates = ['created_at', 'updated_at', 'contract_end_date'];

    /**
     * Get the mobile opportunities that are, or were, currently on the network.
     */
    public function opportunities()
    {
        return $this->belongsToMany(EnergyOpportunity::class);
    }

    public function site()
    {
        return $this->belongsTo(CustomerSite::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function setContractEndDateAttribute($value)
    {

        $this->attributes['contract_end_date'] = $value instanceof Carbon
            ? $value
            : Carbon::createFromFormat('d/m/Y', $value);
    }

    public function setOpportunityAttribute($value)
    {
        if ($this->exists) {
            return $this->opportunities()->attach($value);
        }

        static::created(function ($related) use ($value) {
            $related->opportunities()->attach($value);
        });
    }

    public function setDetachOpportunityAttribute($value)
    {
        if ($this->exists) {
            return $this->opportunities()->detach($value);
        }

        static::created(function ($related) use ($value) {
            $related->opportunities()->attach($value);
        });
    }

    public function getTooltip()
    {
        return 'Day Rate: ' . $this->day_rate .
            ' Night Rate: ' . $this->night_rate .
            ' Current Standing Charge: ' . $this->current_standing_charge .
            ' Contract End Date: ' . $this->contract_end_date;
    }

}
