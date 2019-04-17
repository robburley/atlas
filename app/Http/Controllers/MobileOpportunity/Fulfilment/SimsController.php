<?php

namespace App\Http\Controllers\MobileOpportunity\Fulfilment;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\Allocation;
use App\Models\MobileOpportunity\FulfilmentTimeLineItem;
use App\Models\MobileOpportunity\MobileOpportunity;
use Illuminate\Http\Request;

class SimsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:awaiting_fulfilment_mobile');
    }

    public function index()
    {
        $opportunities = MobileOpportunity::viewPermissions()
                                        ->awaitingSims()
                                        ->orderBy('credit_checked_at', 'desc')
                                        ->orderBy('dealt_at', 'desc')
                                        ->orderBy('created_at', 'desc')
                                          ->paginate(50);

        return view('mobile.opportunities.fulfilment.sims.index', [
            'opportunities' => $opportunities,
        ]);
    }

    public function create(Customer $customer, MobileOpportunity $opportunity)
    {
        return view('mobile.opportunities.fulfilment.sims.create', [
            'customer'    => $customer,
            'opportunity' => $opportunity
        ]);
    }

    public function store(Customer $customer, MobileOpportunity $opportunity)
    {
        $this->validate(request(), [
            'data.*.sim_number' => 'nullable|string|size:13'
        ], [
            'data.*.sim_number.size' => 'Sim Number must be 13 characters'
        ]);

        foreach (request()->get('data') as $allocation) {
            Allocation::find($allocation['id'])->update([
                'sim_number'      => $allocation['sim_number'],
                'tracking_number' => $allocation['tracking_number'],
                'phone_number'    => $allocation['phone_number'],
            ]);

            if ($allocation['tracking_number']) {
                FulfilmentTimeLineItem::create([
                    'action'                => 'Sim Sent',
                    'mobile_opportunity_id' => $opportunity->id,
                    'user_id'               => auth()->user()->id,
                    'allocation_id'         => $allocation['id'],
                ]);
            }
        }

        alert()->success('SIM allocations saved');

        return redirect($opportunity->path());
    }
}
