<?php

namespace App\Http\Controllers\MobileOpportunity\Fulfilment;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\FulfilmentTimeLineItem;
use App\Models\MobileOpportunity\MobileOpportunity;
use Illuminate\Http\Request;

class UnlocksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $opportunities = MobileOpportunity::awaitingUnlocks()
                                          ->viewPermissions()
                                          ->orderBy('credit_checked_at', 'desc')
                                          ->orderBy('dealt_at', 'desc')
                                          ->orderBy('created_at', 'desc')
                                          ->paginate(50);

        return view('mobile.opportunities.fulfilment.unlocks.index', [
            'opportunities' => $opportunities,
        ]);
    }

    public function create(Customer $customer, MobileOpportunity $opportunity)
    {
        return view('mobile.opportunities.fulfilment.unlocks.create', [
            'customer'    => $customer,
            'opportunity' => $opportunity
        ]);
    }

    public function store(Customer $customer, MobileOpportunity $opportunity)
    {
        $allocation = $opportunity->allocations()->where('id', request()->get('allocation_id'))->firstOrFail();

        $allocation->update(request()->all());

        if (request()->has('unlocked_confirmed')) {
            FulfilmentTimeLineItem::create([
                'action'                 => 'Phone Unlocked',
                'mobile_opportunity_id'  => $opportunity->id,
                'user_id'                => auth()->user()->id,
                'allocation_id'          => $allocation->id,
            ]);
        }

        alert()->success('Unlock Updated');

        return redirect()->back();
    }
}
