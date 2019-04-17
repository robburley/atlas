<?php

namespace App\Http\Controllers\MobileOpportunity\TariffMatch;


use App\Http\Controllers\Controller;
use App\Http\Requests\MobileOpportunity\DealCalcRequest;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\DealCalculator\DealCalculator;
use App\Models\MobileOpportunity\MobileNetwork;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\Utilities\MobilePhoneModel;

class NetworksController extends Controller
{
    public function index()
    {
        return MobileNetwork::whereNotIn('name', ['None', 'Any'])
                            ->get()
                            ->map(function ($network) {
                                return collect([
                                    'id'   => $network->name,
                                    'text' => $network->name
                                ]);
                            })->toJson();
    }
}

