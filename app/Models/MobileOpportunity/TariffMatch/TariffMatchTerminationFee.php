<?php

namespace App\Models\MobileOpportunity\TariffMatch;

use Illuminate\Database\Eloquent\Model;

class TariffMatchTerminationFee extends Model
{
    protected $table = 'tariff_match_termination_fees';

    protected $fillable = [
        'network',
        'fee',
    ];

}
