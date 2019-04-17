<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PrintScreenLog extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'user_id',
        'url',
    ];
}
