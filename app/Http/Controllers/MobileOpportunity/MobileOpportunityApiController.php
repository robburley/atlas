<?php

namespace App\Http\Controllers\MobileOpportunity;

use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\Tariff;
use App\Models\MobileOpportunity\TariffType;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobileOpportunityApiController extends Controller
{
    public function authorise(Request $request)
    {
        if (Auth::attempt($request->all())) {
            $user = User::where('username', $request->get('username'))->first();

            if ($user && $user->hasPermission('authorise_deal_calculator_mobile')) {
                return ['success' => true];
            }
        }

        return ['success' => false];
    }

    public function tariffs($type)
    {
        $tariffTypes = TariffType::where('type', $type)->with('activeTariffs')->get();

        $tariffs = $tariffTypes->map(function ($type) {
            return collect([
                'text' => $type->name,
                'children' => $type->activeTariffs->map(function ($tariff) {
                    return collect(['text' => $tariff->getName(), 'id' => $tariff->id]);
                }),
            ]);
        });

        return $tariffs;
    }

    public function tariff(Tariff $tariff)
    {
        return $tariff;
    }
}
