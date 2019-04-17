<?php

namespace App\Http\Controllers\MobileOpportunity\Fulfilment;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\Allocation;
use App\Models\MobileOpportunity\FulfilmentTimeLineItem;
use App\Models\MobileOpportunity\MobileOpportunity;
use Carbon\Carbon;

class PortsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:awaiting_fulfilment_mobile');
    }

    public function index()
    {
        $opportunities = MobileOpportunity::awaitingPort()
                                          ->viewPermissions()
                                          ->orderBy('credit_checked_at', 'desc')
                                          ->orderBy('dealt_at', 'desc')
                                          ->orderBy('created_at', 'desc')
                                          ->paginate(50);

        return view('mobile.opportunities.fulfilment.ports.index', [
            'opportunities' => $opportunities,
        ]);
    }

    public function create(Customer $customer, MobileOpportunity $opportunity)
    {
        return view('mobile.opportunities.fulfilment.ports.create', [
            'customer'    => $customer,
            'opportunity' => $opportunity
        ]);
    }

    public function store(Customer $customer, MobileOpportunity $opportunity)
    {
        if (!request()->has('data')) {
            alert()->success('Error');

            return redirect()->back();
        }

        foreach (request()->get('data') as $allocation) {
            if (!empty($allocation['port_date'])) {
                try {
                    Allocation::find($allocation['id'])->update([
                        'port_date' => Carbon::createFromFormat('d/m/Y', $allocation['port_date']),
                    ]);

                    FulfilmentTimeLineItem::create([
                        'action'                 => 'Port Date Set',
                        'mobile_opportunity_id'  => $opportunity->id,
                        'user_id'                => auth()->user()->id,
                        'allocation_id'          => $allocation['id'],
                    ]);
                } catch (\Exception $e) {
                }
            }
        }

        alert()->success('Ports saved');

        return redirect($opportunity->path());
    }

    public function edit(MobileOpportunity $opportunity)
    {
    }

    public function update(MobileOpportunity $opportunity)
    {
    }
}
