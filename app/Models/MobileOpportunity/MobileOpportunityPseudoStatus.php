<?php

namespace App\Models\MobileOpportunity;


use Illuminate\Database\Eloquent\Model;

class MobileOpportunityPseudoStatus extends Model
{
    protected $table    = 'mobile_opportunity_pseudo_statuses';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'type',
    ];

    public function connectionRequirements()
    {
        return $this->hasMany(ConnectionRequirement::class, 'mobile_opportunity_pseudo_status_id');
    }
}
