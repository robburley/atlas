<?php

namespace App\Http\Controllers\MobileOpportunity\Fulfilment;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\Allocation;
use App\Models\MobileOpportunity\FulfilmentTimeLineItem;
use App\Models\MobileOpportunity\MobileOpportunity;

class PacCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:awaiting_fulfilment_mobile');
    }

    public function index()
    {
        $opportunities = MobileOpportunity::awaitingPacCode()
                                          ->viewPermissions()
                                          ->orderBy('credit_checked_at', 'desc')
                                          ->orderBy('dealt_at', 'desc')
                                          ->orderBy('created_at', 'desc')
                                          ->paginate(50);

        return view('mobile.opportunities.fulfilment.pac-codes.index', [
            'opportunities' => $opportunities,
        ]);
    }

    public function create(Customer $customer, MobileOpportunity $opportunity)
    {
        return view('mobile.opportunities.fulfilment.pac-codes.create', [
            'customer'    => $customer,
            'opportunity' => $opportunity,
        ]);
    }

    public function store(Customer $customer, MobileOpportunity $opportunity)
    {
        foreach (request()->get('data') as $allocation) {
            if ($allocation['pac_code']) {
                $line = Allocation::find($allocation['id']);

                $line->update([
                    'pac_code' => $allocation['pac_code']
                ]);

                FulfilmentTimeLineItem::create([
                    'action'                => 'Pac Code Obtained',
                    'mobile_opportunity_id' => $opportunity->id,
                    'user_id'               => auth()->user()->id,
                    'allocation_id'         => $line->id,
                ]);
            }
        }

        alert()->success('PAC code added');

        return redirect($opportunity->path());
    }
}
