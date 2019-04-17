<?php

namespace App\Models\MobileOpportunity;

use Illuminate\Database\Eloquent\Model;

class MobileOpportunityStatus extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function mobileOpportunities()
    {
        return $this->hasMany(MobileOpportunity::class)
                    ->viewPermissions()
                    ->orderBy('created_at', 'desc');
    }

    public function mobileOpportunitiesFiltered()
    {
        return $this->hasMany(MobileOpportunity::class)
                    ->viewPermissions()
                    ->filters()
                    ->orderBy('created_at', 'desc')
                    ->with([
                        'networks',
                        'customer',
                        'creator',
                        'activeAssigned',
                    ]);
    }
}
