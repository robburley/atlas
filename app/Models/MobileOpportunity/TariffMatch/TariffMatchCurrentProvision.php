<?php

namespace App\Models\MobileOpportunity\TariffMatch;


use Illuminate\Database\Eloquent\Model;

class TariffMatchCurrentProvision extends Model
{
    protected $table = 'tariff_match_current_provisions';

    protected $fillable = [
        'type',
        'network',
        'name',
        'device',
        'mins',
        'data',
        'tariff_match_id'
    ];

    public function setDeviceAttribute($value)
    {
        return $this->attributes['device'] = is_array($value)
            ? $value['value']
            : $value;
    }
}
