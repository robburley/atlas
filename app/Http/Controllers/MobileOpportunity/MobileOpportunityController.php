<?php

namespace App\Http\Controllers\MobileOpportunity;


use App\Http\Controllers\Controller;
use App\Http\Requests\MobileOpportunity\MobileOpportunityRequest;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\MobileNetwork;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\MobileOpportunity\MobileOpportunityStatus;
use Illuminate\Support\Facades\Gate;

class MobileOpportunityController extends Controller
{
    /**
     * Create a new dashboard controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param MobileOpportunityStatus $status
     * @return \Illuminate\Http\Response
     */
    public function index(MobileOpportunityStatus $status)
    {
        $opportunities = MobileOpportunity::where('mobile_opportunity_status_id', $status->id)
                                        ->viewPermissions()
                                        ->filters()
                                        ->orderBy('dealt_at', 'desc')
                                        ->orderBy('created_at', 'desc')
                                        ->with([
                                            'customer',
                                            'creator',
                                            'activeAssigned',
                                            'inactiveAssigned',
                                            'mobileBills',
                                            'appointments',
                                            'callbacks',
                                            'incompleteCallbacks',
                                            'status'
                                        ]);

        return view('mobile.opportunities.index', [
            'status'        => $status,
            'opportunities' => $opportunities->paginate(50),
            'totalGp'       => number_format($opportunities->sum('gp'), 2)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer)
    {
        return view('mobile.opportunities.create', [
            'customer' => $customer,
            'networks' => MobileNetwork::pluck('name', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Customer $customer
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Customer $customer, MobileOpportunityRequest $request)
    {
        $opportunity = $customer->mobileOpportunities()->create($request->all());

        $opportunity->networks()->attach($request->get('networks'));

        $opportunity->openToNetworks()->attach($request->get('openToNetworks'), ['open_to' => 1]);

        return redirect('/customers/' . $customer->id . '/mobile/opportunities/' . $opportunity->id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Customer|Customer $customer
     * @param MobileOpportunity $mobileOpportunity
     * @param null $page
     * @return \Illuminate\Http\Response
     * @internal param MobileOpportunity $opportunity
     */
    public function show(Customer $customer, MobileOpportunity $mobileOpportunity)
    {
        if (Gate::denies('view-opportunity', $mobileOpportunity)) {
            abort(404);
        }

        return view('mobile.opportunities.show', [
            'customer'    => $customer,
            'opportunity' => $mobileOpportunity,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Customer $customer
     * @param MobileOpportunity $mobileOpportunity
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Customer $customer, MobileOpportunity $mobileOpportunity)
    {

        if (Gate::denies('view-opportunity', $mobileOpportunity) || $mobileOpportunity->customer != $customer) {
            abort(404);
        }

        return view('mobile.opportunities.edit', [
            'customer'    => $customer,
            'opportunity' => $mobileOpportunity,
            'networks'    => MobileNetwork::pluck('name', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Customer $customer
     * @param MobileOpportunity $mobileOpportunity
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(MobileOpportunityRequest $request, Customer $customer, MobileOpportunity $mobileOpportunity)
    {
        if ($request->has('recovered')) {
            $mobileOpportunity->recoverProcess($request->get('user_id'));
        } else {
            $data = collect($request->all())->filter(function ($value) {
                return !is_null($value) && $value != '';
            })->toArray();

            $mobileOpportunity->update($data);

            if ($request->has('networks')) {
                $mobileOpportunity->networks()->detach($mobileOpportunity->networks()->pluck('id'));

                $mobileOpportunity->networks()->attach($request->get('networks'));
            }

            if ($request->has('openToNetworks')) {
                $mobileOpportunity->openToNetworks()->detach($mobileOpportunity->openToNetworks()->pluck('id'));

                $mobileOpportunity->openToNetworks()->attach($request->get('openToNetworks'), ['open_to' => 1]);
            }
        }

        return $request->has('networks') || $request->has('openToNetworks')
            ? redirect("customers/$customer->id/mobile/opportunities/$mobileOpportunity->id")
            : redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
