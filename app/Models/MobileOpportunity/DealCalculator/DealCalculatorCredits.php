<?php

namespace App\Models\MobileOpportunity\DealCalculator;

use Illuminate\Database\Eloquent\Model;

class DealCalculatorCredits extends Model
{
    protected $table = 'deal_calculator_credits';

    protected $fillable = [
        'deal_calculator_id',
        'name',
        'value',
        'units',
        'total',
    ];

    public function dealCalculator()
    {
        return $this->belongsTo(DealCalculator::class);
    }

    public function setValueAttribute($value)
    {
        return $this->attributes['value'] = !is_null($value) ? $value : 0;
    }

    public function setUnitsAttribute($value)
    {

        return $this->attributes['units'] = !is_null($value) ? $value : 0;
    }

    public function setTotalAttribute($value)
    {
        return $this->attributes['total'] = !is_null($value) ? $value : 0;
    }
}
