<?php

namespace App\Models\MobileOpportunity;


use App\Models\MobileOpportunity\DealCalculator\DealCalculator;
use App\Models\Tenders\MobileTender;
use App\Models\Tenders\MobileTenderInvitation;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AllocationError extends Model
{
    protected $fillable = [
        'error',
        'active',
        'user_id',
        'allocation_id',
    ];

    public function allocation()
    {
        return $this->belongsTo(Allocation::class, 'allocation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
