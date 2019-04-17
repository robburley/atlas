<?php

namespace App\Models\User;

use App\Models\Recruitment\Application;
use App\Models\Recruitment\Position;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AdobeSignAccessToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'access_token',
        'refresh_token',
        'expires',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'expires',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function setExpiresAttribute($value)
    {
        try {
            $this->attributes['expires'] = Carbon::createFromFormat('U', $value)->addHour();
        } catch (\Exception $e) {
            $this->attributes['expires'] = Carbon::now();
        }
    }
}
