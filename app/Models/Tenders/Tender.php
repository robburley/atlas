<?php

namespace App\Models\Tenders;


use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    protected $fillable = [
        'expires_at',
        'completed_at',
        'error_at',
        'tender_type_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'expires_at',
        'completed_at',
    ];

    public function type()
    {
        return $this->belongsTo(TenderType::class, 'tender_type_id');
    }

    public function mobileTenders()
    {
        return $this->hasMany(MobileTender::class, 'tender_id');
    }

    public function invitation()
    {
        return $this->hasMany(TenderInvitation::class, 'tender_id');
    }

    public function completeInvitation()
    {
        return $this->hasMany(TenderInvitation::class, 'tender_id')
                    ->whereNotNull('completed_at');
    }
}
