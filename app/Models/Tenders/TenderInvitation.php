<?php

namespace App\Models\Tenders;


use Illuminate\Database\Eloquent\Model;

class TenderInvitation extends Model
{
    protected $fillable = [
        'tender_id',
        'supplier_id',
        'hash',
        'completed_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'completed_at',
    ];

    public function getRouteKeyName()
    {
        return 'hash';
    }

    public function tender()
    {
        return $this->belongsTo(Tender::class, 'tender_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function mobileInvitations()
    {
        return $this->hasMany(MobileTenderInvitation::class, 'tender_invitation_id');
    }

    public function link()
    {
        return 'https://atlas.winwincr.co.uk/tenders/mobile/' . $this->hash;
    }
}
