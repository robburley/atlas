<?php

namespace App\Models\Tenders;


use App\Models\MobileOpportunity\Allocation;
use Illuminate\Database\Eloquent\Model;

class MobileTender extends Model
{
    protected $fillable = [
        'tender_id',
        'allocation_id',
        'selected_supplier_id',
        'selected_unit_price',
        'selected_lead_time',
    ];

    public function allocation()
    {
        return $this->belongsTo(Allocation::class, 'allocation_id');
    }

    public function tender()
    {
        return $this->belongsTo(Tender::class, 'tender_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'selected_supplier_id');
    }

    public function setSelectedUnitPriceAttribute($value)
    {
        return $this->attributes['selected_unit_price'] = $value * 100;
    }

    public function getSelectedUnitPriceAttribute($value)
    {
        return $value / 100;
    }

    public function setSelectedTotalPriceAttribute($value)
    {
        return $this->attributes['selected_total_price'] = $value * 100;
    }

    public function getSelectedTotalPriceAttribute($value)
    {
        return $value / 100;
    }
}
