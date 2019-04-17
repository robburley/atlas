<?php

namespace App\Models\Tenders;


use App\Models\MobileOpportunity\Allocation;
use Illuminate\Database\Eloquent\Model;

class MobileTenderInvitation extends Model
{
    protected $fillable = [
        'tender_invitation_id',
        'allocation_id',
        'unit_price',
        'total_price',
        'lead_time',
    ];

    public function allocation()
    {
        return $this->belongsTo(Allocation::class, 'allocation_id');
    }

    public function tenderInvitation()
    {
        return $this->belongsTo(TenderInvitation::class, 'tender_invitation_id');

    }

    public function setUnitPriceAttribute($value)
    {
        return $this->attributes['unit_price'] = $value * 100;
    }

    public function getUnitPriceAttribute($value)
    {
        return $value / 100;
    }

    public function setTotalPriceAttribute($value)
    {
        return $this->attributes['total_price'] = $value * 100;
    }

    public function getTotalPriceAttribute($value)
    {
        return $value / 100;
    }
}
