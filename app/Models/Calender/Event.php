<?php

namespace App\Models\Calender;

use App\Models\Customer\Customer;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'title',
        'body',
        'type',
        'complete',
        'date_time',
        'date'
    ];

    protected $dates = [
        'date_time',
        'created_at',
        'updated_at',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function setDateAttribute($array)
    {
        $collection = collect($array);

        $string = $collection->get('time') . ' ' . $collection->get('hour') . ':' . $collection->get('minute');

        try {
            $this->attributes['date_time'] = Carbon::createFromFormat('d-m-Y H:i', $string);
        } catch (\Exception $e) {
            $this->attributes['date_time'] = Carbon::now();
        }
    }

    public function setDateTimeAttribute($value)
    {
        try {
            $this->attributes['date_time'] = Carbon::createFromFormat('d/m/Y H:i:s', $value);
        } catch(\Exception $e) {
            $this->attributes['date_time'] = Carbon::now();
        }
    }
}
