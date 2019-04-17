<?php

namespace App\Models\EnergyOpportunity;

use Illuminate\Database\Eloquent\Model;

class EnergyOpportunityStatus extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function energyOpportunities()
    {
        return $this->hasMany(energyOpportunity::class)
                    ->viewPermissions()
                    ->orderBy('created_at', 'desc');
    }

    public function energyOpportunitiesFiltered()
    {
        return $this->hasMany(energyOpportunity::class)
                    ->viewPermissions()
                    ->filters()
                    ->orderBy('created_at', 'desc');
    }
}
