<?php

namespace App\Models\MobileOpportunity\DealCalculator;


use App\Models\MobileOpportunity\Phone;
use Illuminate\Database\Eloquent\Model;

class DealCalculatorHandsets extends Model
{
    protected $table = 'deal_calculator_handsets';

    protected $fillable = [
        'deal_calculator_id',
        'name',
        'value',
        'units',
        'total',
        'handset_id',
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

    public function handset()
    {
        return $this->belongsTo(Phone::class, 'handset_id');
    }
}
