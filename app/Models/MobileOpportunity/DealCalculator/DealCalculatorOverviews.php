<?php

namespace App\Models\MobileOpportunity\DealCalculator;


use Illuminate\Database\Eloquent\Model;

class DealCalculatorOverviews extends Model
{
    protected $table = 'deal_calculator_overviews';

    protected $fillable = [
        'deal_calculator_id',
        'monthsFree',
        'lineRental',
        'bcad',
        'cashBack',
        'monthlyDiscount',
        'monthlyLineRental',
        'discountMargin',
        'discountedMonthlyCost',
        'income',
        'cost',
        'handlingFee',
        'totalProfit',
        'profitMargin',
        'status',
    ];

    public function dealCalculator()
    {
        return $this->belongsTo(DealCalculator::class);
    }

    public function setMonthsFreeAttribute($value)
    {
        return $this->attributes['monthsFree'] = !is_null($value) ? $value : 0;
    }
}
