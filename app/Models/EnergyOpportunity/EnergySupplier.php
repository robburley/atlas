<?php

namespace App\Models\EnergyOpportunity;

use Illuminate\Database\Eloquent\Model;

class EnergySupplier extends Model
{

    protected $fillable = [
        'name'
    ];
    /**
     * Get the mobile opportunities that are, or were, currently on the network.
     */
    public function opportunities()
    {
        return $this->belongsToMany(EnergyOpportunity::class);
    }
}
