<?php

namespace App\Models\Utilities;

use Illuminate\Database\Eloquent\Model;

class MobilePhoneModel extends Model
{
    protected $fillable = [
        'model',
        'manufacturer'
    ];
}
