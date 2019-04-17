<?php

namespace App\Http\Controllers\MobileOpportunity;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobileOpportunity\DealCalcRequest;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\DealCalculator\DealCalculator;
use App\Models\MobileOpportunity\MobileOpportunity;

class DealCalculatorController extends Controller
{
    public function index(Customer $customer, MobileOpportunity $opportunity)
    {
        return $opportunity->activeDealCalculator->load([
            'creator',
            'accessories',
            'contributions',
            'credits',
            'handsets',
            'primaryConnections',
            'secondaryConnections',
            'overview',
        ]);
    }

    public function store(DealCalcRequest $request, Customer $customer, MobileOpportunity $opportunity)
    {
        if (count($opportunity->allocations) > 0) {
            $opportunity->allocations()->delete();
        }

        $dealCalc = $opportunity->dealCalculators()->create($request->all());

        return $dealCalc->load([
            'creator',
            'accessories',
            'contributions',
            'credits',
            'handsets',
            'primaryConnections',
            'secondaryConnections',
            'overview',
        ]);
    }

    public function update(DealCalcRequest $request, Customer $customer, MobileOpportunity $opportunity, DealCalculator $dealCalculator)
    {
        if (count($opportunity->allocations) > 0) {
            $opportunity->allocations()->delete();
        }

        $dealCalculator->update($request->all());

        return $dealCalculator->load([
            'creator',
            'accessories',
            'contributions',
            'credits',
            'handsets',
            'primaryConnections',
            'secondaryConnections',
            'overview',
        ]);
    }

    public function setActive(Customer $customer, MobileOpportunity $opportunity, DealCalculator $dealCalculator)
    {
        $opportunity->update([
            'gp'            => $dealCalculator->overview->totalProfit,
            'bcad_required' => $dealCalculator->overview->bcad > 0 || $dealCalculator->getBcadDiff() > 0
        ]);

        $opportunity->dealCalculators->each(function ($c) use ($dealCalculator) {
            $c->update([
                'primary' => $c->id == $dealCalculator->id,
                'name'    => str_replace('(selected)', '', $c->name)
            ]);
        });

        $dealCalculator->update([
            'name' => $dealCalculator->name . ' (selected)'
        ]);

        return response(['success' => true, 'payload' => $dealCalculator], 200);
    }

    public function destroy(Customer $customer, MobileOpportunity $opportunity, DealCalculator $dealCalculator)
    {
        $dealCalculator->delete();

        return response(['success' => true], 200);
    }
}
