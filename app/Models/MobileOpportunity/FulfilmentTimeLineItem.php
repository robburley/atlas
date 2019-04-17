<?php

namespace App\Models\MobileOpportunity;


use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class FulfilmentTimeLineItem extends Model
{
    protected $table    = 'fulfilment_timeline';
    protected $fillable = [
        'id',
        'action',
        'mobile_opportunity_id',
        'user_id',
        'allocation_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function opportunity()
    {
        return $this->belongsTo(MobileOpportunity::class, 'mobile_opportunity_id');
    }

    public function allocation()
    {
        return $this->belongsTo(Allocation::class, 'allocation_id');
    }
}
