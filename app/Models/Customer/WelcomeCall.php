<?php

namespace App\Models\Customer;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class WelcomeCall extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'opportunity_id',
        'opportunity_type',
        'user_id',
        'telephone',
        'notes',
    ];

    /**
     * Get the user who is assigned to this callback.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function opportunity()
    {
        return $this->morphTo();
    }
}
