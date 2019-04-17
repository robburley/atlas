<?php

namespace App\Models\FixedLineOpportunity;

use Illuminate\Database\Eloquent\Model;

class FixedLineOpportunityStatus extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function fixedLineOpportunities()
    {
        return $this->hasMany(FixedLineOpportunity::class)
                    ->viewPermissions()
                    ->orderBy('created_at', 'desc');
    }

    public function fixedLineOpportunitiesFiltered()
    {
        return $this->hasMany(FixedLineOpportunity::class)
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
