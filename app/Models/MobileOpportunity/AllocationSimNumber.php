<?php

namespace App\Models\MobileOpportunity;


use App\Models\MobileOpportunity\DealCalculator\DealCalculator;
use Illuminate\Database\Eloquent\Model;

class AllocationSimNumber extends Model
{
    protected $fillable = [
        'id',
        'allocation_id',
        'sim_number',
        'active'
    ];

    public function allocation()
    {
        return $this->belongsTo(Allocation::class, 'allocation_id');
    }
}
