<?php

namespace App\Http\Controllers\MobileOpportunity\Fulfilment;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\Allocation;
use App\Models\MobileOpportunity\FulfilmentTimeLineItem;
use App\Models\MobileOpportunity\MobileOpportunity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PendingConnectionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:awaiting_fulfilment_mobile');
    }

    public function index()
    {
        $opportunities = MobileOpportunity::pendingConnection()
                                          ->viewPermissions()
                                          ->orderBy('credit_checked_at', 'desc')
                                          ->orderBy('dealt_at', 'desc')
                                          ->orderBy('created_at', 'desc')
                                          ->paginate(50);

        return view('mobile.opportunities.fulfilment.pending-connections.index', [
            'opportunities' => $opportunities,
        ]);
    }

    public function create(Customer $customer, MobileOpportunity $opportunity)
    {
        return view('mobile.opportunities.fulfilment.pending-connections.create', [
            'customer'    => $customer,
            'opportunity' => $opportunity
        ]);
    }

    public function store(Customer $customer, MobileOpportunity $opportunity)
    {
        if (request()->has('update')) {
            $this->validate(request(), [
                'connection_reference' => 'required'
            ]);

            $data = [
                'connection_reference' => request()->get('connection_reference')
            ];
        }

        if (request()->has('deferred')) {
            $data = [
                'connection_deferred' => Carbon::now()
            ];
        }

        if (request()->has('passed')) {
            $this->validate(request(), [
                'account_number'    => 'required',
                'date_connected'    => 'required|date_format:d/m/Y',
                'contract_end_date' => 'required|date_format:d/m/Y',
            ]);

            $data = [
                'account_number'    => request()->get('account_number'),
                'date_connected'    => request()->get('date_connected'),
                'contract_end_date' => request()->get('contract_end_date'),
                'connected'         => request()->get('connected'),
            ];
        }

        if (request()->has('error')) {
            $data = [
                'connection_error' => Carbon::now()
            ];
        }

        foreach (request()->get('data') as $allocation) {
            $allocation = Allocation::find($allocation);

            $allocation->update($data);

            if (request()->has('passed')) {
                FulfilmentTimeLineItem::create([
                    'action'                => 'Allocation Connected',
                    'mobile_opportunity_id' => $opportunity->id,
                    'user_id'               => auth()->user()->id,
                    'allocation_id'         => $allocation->id,
                ]);
            }

            if (request()->has('deferred')) {
                FulfilmentTimeLineItem::create([
                    'action'                => 'Connection Deferred',
                    'mobile_opportunity_id' => $opportunity->id,
                    'user_id'               => auth()->user()->id,
                    'allocation_id'         => $allocation->id,
                ]);
            }

            if (request()->has('error')) {
                foreach (request()->get('errors') as $error => $value) {
                    $allocation->errors()->create([
                        'error'   => $error,
                        'user_id' => auth()->user()->id
                    ]);
                }
            }
        }

        alert()->success('Connection Updated');

        return redirect($opportunity->path());
    }
}
