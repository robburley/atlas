<?php

namespace App\Http\Controllers\MobileOpportunity\TariffMatch;


use App\Http\Controllers\Controller;
use App\Http\Requests\MobileOpportunity\DealCalcRequest;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\DealCalculator\DealCalculator;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\Utilities\MobilePhoneModel;

class CustomerHandsetController extends Controller
{
    public function index()
    {
        return MobilePhoneModel::when(request()->has('manufacturer'), function ($query) {
                                    return $query->where('manufacturer', request()->get('manufacturer'));
                                })
                               ->when(request()->has('model'), function ($query) {
                                   return $query->where('model', 'LIKE', '%' . request()->get('model') . '%');
                               })
                               ->get()
                               ->map(function ($phone) {
                                   return collect([
                                       'label'   => $phone->model,
                                       'value' => $phone->model,
                                   ]);
                               })->toJson();
    }
}

