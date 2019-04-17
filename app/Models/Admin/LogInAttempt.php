<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class LogInAttempt extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'user_id',
        'user_agent',
        'ip_address',
        'outcome',
        'username',
    ];
}
