<?php

namespace App\Http\Controllers\MobileOpportunity\TariffMatch;


use App\Http\Controllers\Controller;
use App\Http\Requests\MobileOpportunity\TariffMatchRequest;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\MobileOpportunity\TariffMatch\TariffMatch;

class TariffMatchController extends Controller
{
    public function show(MobileOpportunity $opportunity)
    {
        return $opportunity->tariffMatch()->with([
            'opportunity.customer.contacts',
            'lines',
            'requirements',
            'terminationFees',
            'dealCalculators',
            'dealCalculators.creator',
            'dealCalculators.opportunity',
            'dealCalculators.accessories',
            'dealCalculators.contributions',
            'dealCalculators.credits',
            'dealCalculators.handsets',
            'dealCalculators.primaryConnections',
            'dealCalculators.secondaryConnections',
            'dealCalculators.overview',
        ])->firstOrFail();
    }

    public function store(TariffMatchRequest $request, $step)
    {
        $tariffMatch = TariffMatch::where('mobile_opportunity_id', $request->get('mobile_opportunity_id'))->first();

        if ($tariffMatch) {
            $tariffMatch->update($request->all());
        } else {
            $tariffMatch = TariffMatch::create($request->all());
        }

        if ($request->has('lines')) {
            $tariffMatch->lines()->delete();

            foreach ($request->get('lines') as $line) {
                $tariffMatch->lines()->create($line);
            }
        }

        if ($request->has('requirements')) {
            $tariffMatch->requirements()->delete();

            foreach ($request->get('requirements') as $line) {
                $tariffMatch->requirements()->create($line);
            }
        }

        if ($request->has('termination_fees')) {
            $tariffMatch->terminationFees()->delete();

            foreach ($request->get('termination_fees') as $line) {
                $tariffMatch->terminationFees()->create($line);
            }
        }

        return $request->all();
    }
}

