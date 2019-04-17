<?php

namespace App\Http\Controllers\MobileOpportunity\Fulfilment;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\Allocation;
use App\Models\MobileOpportunity\FulfilmentTimeLineItem;
use App\Models\MobileOpportunity\MobileOpportunity;
use Illuminate\Http\Request;

class ConnectionErrorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:awaiting_fulfilment_mobile');
    }

    public function index()
    {
        $opportunities = MobileOpportunity::connectionError()
                                          ->viewPermissions()
                                          ->orderBy('credit_checked_at', 'desc')
                                          ->orderBy('dealt_at', 'desc')
                                          ->orderBy('created_at', 'desc')
                                          ->paginate(50);

        return view('mobile.opportunities.fulfilment.connection-errors.index', [
            'opportunities' => $opportunities,
        ]);
    }

    public function create(Customer $customer, MobileOpportunity $opportunity)
    {
        return view('mobile.opportunities.fulfilment.connection-errors.create', [
            'customer'    => $customer,
            'opportunity' => $opportunity
        ]);
    }

    public function store(Customer $customer, MobileOpportunity $opportunity)
    {
        foreach (request()->get('data') as $allocation) {
            $allocation = Allocation::find($allocation);

            $allocation->update([
                'connection_error' => null
            ]);

            $allocation->errors->each(function ($error) {
                $error->update(['active' => 0]);
            });

            FulfilmentTimeLineItem::create([
                'action'                => 'Connection Errors Resolved',
                'mobile_opportunity_id' => $opportunity->id,
                'user_id'               => auth()->user()->id,
                'allocation_id'         => $allocation->id,
            ]);
        }

        alert()->success('Connection Updated');

        return redirect($opportunity->path());
    }
}
