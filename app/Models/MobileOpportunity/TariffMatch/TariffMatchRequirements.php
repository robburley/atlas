<?php

namespace App\Models\MobileOpportunity\TariffMatch;


use App\Models\MobileOpportunity\Phone;
use Illuminate\Database\Eloquent\Model;

class TariffMatchRequirements extends Model
{
    protected $table = 'tariff_match_requirements';

    protected $fillable = [
        'type',
        'network',
        'name',
        'device',
        'mins',
        'data',
        'tariff_match_id',
        'colour'
    ];

    public function device()
    {
        return $this->hasOne(Phone::class, 'device');
    }

    public function setDataAttribute($value)
    {
        return $this->attributes['data'] = $value * 100;
    }

    public function getDataAttribute($value)
    {
        return $value / 100;
    }
}
