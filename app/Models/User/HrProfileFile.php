<?php

namespace App\Models\User;


use Illuminate\Database\Eloquent\Model;

class HrProfileFile extends Model
{
    protected $fillable = [
        'name',
        'location',
        'hr_profile_id',
        'type',
    ];

    public function profile()
    {
        return $this->belongsTo(HrProfile::class, 'hr_profile_id');
    }
}
