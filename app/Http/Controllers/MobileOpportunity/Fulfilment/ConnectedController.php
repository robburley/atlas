<?php

namespace App\Http\Controllers\MobileOpportunity\Fulfilment;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\Allocation;
use App\Models\MobileOpportunity\MobileOpportunity;
use Illuminate\Http\Request;

class ConnectedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:awaiting_fulfilment_mobile');
    }

    public function index()
    {
        $opportunities = MobileOpportunity::connected()
                                          ->viewPermissions()
                                          ->orderBy('credit_checked_at', 'desc')
                                          ->orderBy('dealt_at', 'desc')
                                          ->orderBy('created_at', 'desc')
                                          ->paginate(50);

        return view('mobile.opportunities.fulfilment.connected.index', [
            'opportunities' => $opportunities,
        ]);
    }

    public function create(Customer $customer, MobileOpportunity $opportunity)
    {
        return view('mobile.opportunities.fulfilment.connected.create', [
            'customer'    => $customer,
            'opportunity' => $opportunity
        ]);
    }

    public function store(Customer $customer, MobileOpportunity $opportunity)
    {
        foreach (request()->get('data') as $allocation) {
            Allocation::find($allocation)
                      ->update([
                          'connection_error' => null
                      ]);
        }

        alert()->success('Connection Updated');

        return redirect($opportunity->path());
    }
}
