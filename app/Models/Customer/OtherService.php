<?php

namespace App\Models\Customer;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OtherService extends Model
{
    protected $table = 'other_services';

    protected $fillable = [
        'customer_id',
        'mobile_status',
        'mobile_description',
        'mobile_rearranged_at',
        'fixed_line_status',
        'fixed_line_description',
        'fixed_line_rearranged_at',
        'broadband_status',
        'broadband_description',
        'broadband_rearranged_at',
        'mobile',
        'fixed_line',
        'broadband',
    ];

    protected $dates = [
        'mobile_rearranged_at',
        'fixed_line_rearranged_at',
        'broadband_rearranged_at',
    ];

    public function customer()
    {
        $this->belongsTo(Customer::class);
    }

    public function setMobileAttribute($array)
    {
        $this->attributes['mobile_status'] = $array['status'];
        $this->attributes['mobile_description'] = $array['description'];
        $this->attributes['mobile_rearranged_at'] = empty($array['rearranged_at']) ? null : Carbon::createFromFormat('d/m/Y H:i:s', $array['rearranged_at']);
    }

    public function setFixedLineAttribute($array)
    {
        $this->attributes['fixed_line_status'] = $array['status'];
        $this->attributes['fixed_line_description'] = $array['description'];
        $this->attributes['fixed_line_rearranged_at'] = empty($array['rearranged_at']) ? null : Carbon::createFromFormat('d/m/Y H:i:s', $array['rearranged_at']);
    }

    public function setBroadbandAttribute($array)
    {
        $this->attributes['broadband_status'] = $array['status'];
        $this->attributes['broadband_description'] = $array['description'];
        $this->attributes['broadband_rearranged_at'] = empty($array['rearranged_at']) ? null : Carbon::createFromFormat('d/m/Y H:i:s', $array['rearranged_at']);
    }
}
