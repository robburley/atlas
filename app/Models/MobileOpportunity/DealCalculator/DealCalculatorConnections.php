<?php

namespace App\Models\MobileOpportunity\DealCalculator;


use App\Models\MobileOpportunity\Tariff;
use Illuminate\Database\Eloquent\Model;

class DealCalculatorConnections extends Model
{
    protected $table = 'deal_calculator_connections';

    protected $fillable = [
        'primary',
        'deal_calculator_id',
        'tariff_id',
        'tariff_name',
        'term',
        'connections',
        'cost',
        'gp',
        'commission',
        'total',
        'modifier',
        'type',
        'discount'
    ];

    public $types = [
        1 => 'New',
        2 => 'Upgrade',
        3 => 'Existing',
        4 => 'Mobile BB',
    ];

    public function dealCalculator()
    {
        return $this->belongsTo(DealCalculator::class);
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class, 'tariff_id');
    }

    public function getType()
    {
        return collect($this->types)->get($this->type, 'No Type');
    }

    public function setConnectionsAttribute($value)
    {
        $this->attributes['connections'] = !is_null($value) ? $value : 0;
    }

    public function setDiscountAttribute($value)
    {
        $this->attributes['discount'] = !is_null($value) ? $value : 0;
    }

}
