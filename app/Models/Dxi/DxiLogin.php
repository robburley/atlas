<?php

namespace App\Models\Dxi;


use Illuminate\Database\Eloquent\Model;

class DxiLogin extends Model
{
    protected $fillable = [
        'id',
        'agent_id',
        'day',
        'first_login',
        'last_logout',
        'first_call',
        'last_call',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'day',
        'first_login',
        'last_logout',
        'first_call',
        'last_call',
    ];

}
