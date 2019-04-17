<?php

namespace App\Models\MobileOpportunity;

use Illuminate\Database\Eloquent\Model;

class AdobeSignDocument extends Model
{
    protected $fillable = [
        'agreement_id',
        'status',
        'type'
    ];

    public function signable()
    {
        return $this->morphTo();
    }
}
