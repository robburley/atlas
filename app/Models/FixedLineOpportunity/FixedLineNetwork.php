<?php

namespace App\Models\FixedLineOpportunity;

use Illuminate\Database\Eloquent\Model;

class FixedLineNetwork extends Model
{
    /**
     * Get the mobile opportunities that are, or were, currently on the network.
     */
    public function opportunities()
    {
        return $this->belongsToMany(FixedLineOpportunity::class);
    }
}
