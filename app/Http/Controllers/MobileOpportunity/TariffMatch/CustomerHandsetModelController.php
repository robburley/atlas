<?php

namespace App\Http\Controllers\MobileOpportunity\TariffMatch;


use App\Http\Controllers\Controller;
use App\Http\Requests\MobileOpportunity\DealCalcRequest;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\DealCalculator\DealCalculator;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\Utilities\MobilePhoneModel;
use Illuminate\Support\Facades\DB;

class CustomerHandsetModelController extends Controller
{
    public function index()
    {
        return DB::table('mobile_phone_models')
                 ->select('manufacturer')
                 ->groupBy('manufacturer')
                 ->get()
                 ->map(function ($phone, $index) {
                     return collect([
                         'id'   => $phone->manufacturer,
                         'text' => $phone->manufacturer
                     ]);
                 })->toJson();
    }
}

