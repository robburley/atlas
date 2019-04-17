<?php

namespace App\Models\MobileOpportunity;


use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class Correction extends Model
{
    protected $table    = 'mobile_closer_corrections';
    protected $fillable = [
        'mobile_opportunity_id',
        'user_id',
        'actioned',
        'penalty',
        'type',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function opportunity()
    {
        return $this->belongsTo(MobileOpportunity::class, 'mobile_opportunity_id');
    }

    public function action()
    {
        return $this->update(['actioned' => 1]);
    }
}
