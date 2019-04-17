<?php

namespace App\Http\Controllers\EnergyOpportunity;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnergyOpportunity\EnergyOpportunityRequest;
use App\Models\Customer\Customer;
use App\Models\EnergyOpportunity\EnergyNetwork;
use App\Models\EnergyOpportunity\EnergyOpportunity;
use App\Models\EnergyOpportunity\EnergyOpportunityStatus;
use App\Models\EnergyOpportunity\EnergySupplier;
use Illuminate\Http\Request;

class EnergyOpportunityController extends Controller
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
     * @param EnergyOpportunityStatus $status
     * @return \Illuminate\Http\Response
     */
    public function index(EnergyOpportunityStatus $status)
    {
        return view('energy.opportunities.index', [
            'status' => $status,
            'opportunities' => $status->energyOpportunitiesFiltered()->paginate(50)
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
        return view('energy.opportunities.create', [
            'customer' => $customer,
            'suppliers' => EnergySupplier::pluck('name', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Customer $customer
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Customer $customer, EnergyOpportunityRequest $request)
    {
        $opportunity = $customer->energyOpportunities()->create($request->all());

        $opportunity->suppliers()->attach($request->get('suppliers'));

        return redirect('/customers/' . $customer->id . '/energy/opportunities/' . $opportunity->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer $customer
     * @param EnergyOpportunity $energyOpportunity
     * @return \Illuminate\Http\Response
     * @internal param EnergyOpportunity $opportunity
     */
    public function show(Customer $customer, EnergyOpportunity $energyOpportunity)
    {
        return view('energy.opportunities.show', [
            'customer' => $customer,
            'opportunity' => $energyOpportunity,
            'statuses' => EnergyOpportunityStatus::where('blown', 0)->pluck('name', 'id'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Customer $customer
     * @param EnergyOpportunity $energyOpportunity
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Customer $customer, EnergyOpportunity $energyOpportunity)
    {
        if ($energyOpportunity->customer != $customer) {
            abort('404');
        }

        return view('energy.opportunities.edit', [
            'customer' => $customer,
            'opportunity' => $energyOpportunity,
            'suppliers' => EnergySupplier::pluck('name', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Customer $customer
     * @param EnergyOpportunity $energyOpportunity
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, Customer $customer, EnergyOpportunity $energyOpportunity)
    {
        $data = collect($request->all())->filter(function ($value) {
            return !is_null($value) && $value != '';
        })->toArray();

        $energyOpportunity->update($data);

        return redirect()->back();
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
