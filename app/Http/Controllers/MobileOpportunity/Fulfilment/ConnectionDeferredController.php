<?php

namespace App\Http\Controllers\MobileOpportunity\Fulfilment;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\Allocation;
use App\Models\MobileOpportunity\FulfilmentTimeLineItem;
use App\Models\MobileOpportunity\MobileOpportunity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConnectionDeferredController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:awaiting_fulfilment_mobile');
    }

    public function index()
    {
        $opportunities = MobileOpportunity::connectionDeferred()
                                          ->viewPermissions()
                                          ->orderBy('credit_checked_at', 'desc')
                                          ->orderBy('dealt_at', 'desc')
                                          ->orderBy('created_at', 'desc')
                                          ->paginate(50);

        return view('mobile.opportunities.fulfilment.connection-deferred.index', [
            'opportunities' => $opportunities,
        ]);
    }

    public function create(Customer $customer, MobileOpportunity $opportunity)
    {
        return view('mobile.opportunities.fulfilment.connection-deferred.create', [
            'customer'    => $customer,
            'opportunity' => $opportunity
        ]);
    }

    public function store(Customer $customer, MobileOpportunity $opportunity)
    {
        if (request()->has('passed')) {
            $this->validate(request(), [
                'account_number'    => 'required',
                'date_connected'    => 'required|date_format:d/m/Y',
                'contract_end_date' => 'required|date_format:d/m/Y',
            ]);

            $data = [
                'connected'           => Carbon::now(),
                'connection_deferred' => null,
                'account_number'      => request()->get('account_number'),
                'date_connected'      => request()->get('date_connected'),
                'contract_end_date'   => request()->get('contract_end_date'),
            ];
        }

        if (request()->has('error')) {
            $data = [
                'connection_error' => Carbon::now(),
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

            if (request()->has('error')) {
                foreach (request()->get('errors') as $error => $value) {
                    $allocation->errors()->create([
                        'error'   => $error,
                        'user_id' => auth()->user()->id
                    ]);
                }

                FulfilmentTimeLineItem::create([
                    'action'                => 'Connection Error',
                    'mobile_opportunity_id' => $opportunity->id,
                    'user_id'               => auth()->user()->id,
                    'allocation_id'         => $allocation->id,
                ]);
            }
        }

        alert()->success('Connection Updated');

        return redirect($opportunity->path());
    }
}
