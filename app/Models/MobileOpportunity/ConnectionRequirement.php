<?php

namespace App\Models\MobileOpportunity;


use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class ConnectionRequirement extends Model
{
    protected $table    = 'mobile_connection_requirements';

    protected $fillable = [
        'id',
        'action',
        'allocation_id',
        'mobile_opportunity_pseudo_status_id',
        'completed_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'completed_at',
    ];

    public function allocation()
    {
        return $this->belongsTo(Allocation::class, 'allocation_id');
    }
}
