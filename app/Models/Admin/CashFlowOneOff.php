<?php

namespace App\Models\Admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CashFlowOneOff extends Model
{
    protected $dates = ['created_at', 'updated_at', 'date'];

    protected $fillable = [
        'date',
        'value',
        'type'
    ];

    public function setValueAttribute($value)
    {
        return $this->attributes['value'] = $value * 100;
    }

    public function getValueAttribute($value)
    {
        return $value / 100;
    }

    public function setDateAttribute($value) {
        try {
            return $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value);
        } catch (\Exception $e) {

        }
    }
}
