<?php

namespace App\Http\Controllers\MobileOpportunity;


use App\Http\Controllers\Controller;
use App\Http\Requests\MobileOpportunity\TariffRequest;
use App\Models\MobileOpportunity\Phone;
use App\Models\MobileOpportunity\Tariff;
use App\Models\MobileOpportunity\TariffType;
use Illuminate\Http\Request;

class PhonesApiController extends Controller
{
    public function index()
    {
        return Phone::active()
                    ->orderBy('manufacturer', 'asc')
                    ->orderBy('model', 'asc')
                    ->orderBy('price', 'asc')
                    ->get()
                    ->map(function ($phone) {
                        return collect([
                            'id'   => $phone->id,
                            'text' => $phone->name
                        ]);
                    })->toJson();
    }

    public function show(Phone $phone) {
        return $phone;
    }
}
