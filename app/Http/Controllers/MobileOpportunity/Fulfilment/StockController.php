<?php

namespace App\Http\Controllers\MobileOpportunity\Fulfilment;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\Allocation;
use App\Models\MobileOpportunity\FulfilmentTimeLineItem;
use App\Models\MobileOpportunity\MobileOpportunity;
use Carbon\Carbon;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:awaiting_fulfilment_mobile');
    }

    public function index()
    {
        $opportunities = MobileOpportunity::awaitingStock()
                                          ->viewPermissions()
                                          ->orderBy('credit_checked_at', 'desc')
                                          ->orderBy('dealt_at', 'desc')
                                          ->orderBy('created_at', 'desc')
                                          ->paginate(50);

        return view('mobile.opportunities.fulfilment.stock.index', [
            'opportunities' => $opportunities,
        ]);
    }

    public function create(Customer $customer, MobileOpportunity $opportunity)
    {
        return view('mobile.opportunities.fulfilment.stock.create', [
            'customer'    => $customer,
            'opportunity' => $opportunity
        ]);
    }

    public function store(Customer $customer, MobileOpportunity $opportunity)
    {
        foreach (request()->get('data') as $index => $allocation) {
            if ($allocation['price'] > 0) {
                $current = Allocation::find($allocation['id']);

                $current->update([
                    'price_paid'    => $allocation['price'],
                    'imei'          => $allocation['imei'],
                    'stock_ordered' => Carbon::now()
                ]);

                if ($current->price_paid != $allocation['price']) {
                    FulfilmentTimeLineItem::create([
                        'action'                => 'Hardware purchased',
                        'mobile_opportunity_id' => $opportunity->id,
                        'user_id'               => auth()->user()->id,
                        'allocation_id'         => $index,
                    ]);
                }
            }
        }

        alert()->success('Stock orders saved');

        return redirect($opportunity->path());
    }
}
