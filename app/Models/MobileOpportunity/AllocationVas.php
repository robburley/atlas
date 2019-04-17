<?php

namespace App\Models\MobileOpportunity;


use App\Models\MobileOpportunity\DealCalculator\DealCalculator;
use Illuminate\Database\Eloquent\Model;

class AllocationVas extends Model
{
    protected $fillable = [
        'id',
        'allocation_id',
        'tariff_id',
        'tariff_name',
    ];

    protected $table = 'allocation_vas';

    public function allocation()
    {
        return $this->belongsTo(Allocation::class, 'allocation_id');
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class, 'tariff_id');
    }
}
