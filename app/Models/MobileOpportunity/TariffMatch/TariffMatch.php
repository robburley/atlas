<?php

namespace App\Models\MobileOpportunity\TariffMatch;


use App\Models\MobileOpportunity\DealCalculator\DealCalculator;
use App\Models\MobileOpportunity\MobileOpportunity;
use Illuminate\Database\Eloquent\Model;

class TariffMatch extends Model
{
    protected $table = 'tariff_matches';

    protected $fillable = [
        'mobile_opportunity_id',
        'step',
        'current_monthly_cost',
        'delete_deal_calculators',
        'expected_monthly_cost',
        'new_network'
    ];

    public function lines()
    {
        return $this->hasMany(TariffMatchCurrentProvision::class);
    }

    public function requirements()
    {
        return $this->hasMany(TariffMatchRequirements::class);
    }

    public function terminationFees()
    {
        return $this->hasMany(TariffMatchTerminationFee::class);
    }

    public function opportunity()
    {
        return $this->belongsTo(MobileOpportunity::class, 'mobile_opportunity_id');
    }

    public function dealCalculators()
    {
        return $this->hasMany(DealCalculator::class)
                    ->where('active', 1);
    }

    public function setDeleteDealCalculatorsAttribute($value)
    {
        if ($value) {
            $this->dealCalculators()->delete();
        }
    }

    public function setExpectedMonthlyCostAttribute($value)
    {
        return $this->attributes['expected_monthly_cost'] = $value * 100;
    }

    public function getExpectedMonthlyCostAttribute($value)
    {
        return $value / 100;
    }
}
