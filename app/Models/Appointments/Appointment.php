<?php

namespace App\Models\Appointments;

use App\Models\Customer\Contact;
use App\Models\Customer\CustomerSite;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'time',
        'contact_id',
        'attended',
        'appointable_type',
        'appointable_id',
        'user_id',
        'site_id',
        'site'
    ];

    protected $dates = ['created_at', 'updated_at', 'time'];

    public function appointable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function site()
    {
        return $this->belongsTo(CustomerSite::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function setTimeAttribute($value)
    {
        try {
            $this->attributes['time'] = Carbon::createFromFormat('d/m/Y H:i:s', $value);
        } catch (\Exception $e) {

        }
    }

    public function setSiteAttribute($siteInfo)
    {
        if (array_key_exists('name', $siteInfo) && !empty($siteInfo['name'])) {
            if ($this->exists) {
                $site = $this->appointable->customer->sites()->create($siteInfo);

                return $this->attributes['site_id'] = $site->id;
            }

            static::created(function ($opportunity) use ($siteInfo) {
                $site = $opportunity->appointable->customer->sites()->create($siteInfo);

                $opportunity->update(['site_id' => $site->id]);
            });
        }
    }
}
