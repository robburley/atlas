<?php

namespace App\Models\MobileOpportunity;

use Illuminate\Database\Eloquent\Model;

class MobileNetwork extends Model
{
    /**
     * Get the mobile opportunities that are, or were, currently on the network.
     */
    public function opportunities()
    {
        return $this->belongsToMany(MobileOpportunity::class);
    }
}
