<?php

namespace App\Http\Controllers\FixedLineOpportunity;

use App\Http\Controllers\Controller;
use App\Http\Requests\FixedLineOpportunity\FixedLineOpportunityRequest;
use App\Models\Customer\Customer;
use App\Models\FixedLineOpportunity\FixedLineNetwork;
use App\Models\FixedLineOpportunity\FixedLineOpportunity;
use App\Models\FixedLineOpportunity\FixedLineOpportunityStatus;
use Illuminate\Support\Facades\Gate;

class FixedLineOpportunityController extends Controller
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
     * @param FixedLineOpportunityStatus $status
     * @return \Illuminate\Http\Response
     */
    public function index(FixedLineOpportunityStatus $status)
    {
        return view('fixed-line.opportunities.index', [
            'status' => $status,
            'opportunities' => $status->fixedLineOpportunitiesFiltered()->paginate(50)
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
        return view('fixed-line.opportunities.create', [
            'customer' => $customer,
            'networks' => FixedLineNetwork::pluck('name', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Customer $customer
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Customer $customer, FixedLineOpportunityRequest $request)
    {
        $opportunity = $customer->fixedLineOpportunities()->create($request->all());

        $opportunity->networks()->attach($request->get('networks'));

        return redirect('/customers/' . $customer->id . '/fixed-line/opportunities/' . $opportunity->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer $customer
     * @param FixedLineOpportunity $fixedLineOpportunity
     * @return \Illuminate\Http\Response
     * @internal param FixedLineOpportunity $opportunity
     */
    public function show(Customer $customer, FixedLineOpportunity $fixedLineOpportunity)
    {
        if (Gate::denies('view-opportunity', $fixedLineOpportunity)) {
            abort(404);
        }

        return view('fixed-line.opportunities.show', [
            'customer' => $customer,
            'opportunity' => $fixedLineOpportunity,
            'statuses' => FixedLineOpportunityStatus::where('blown', 0)->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Customer $customer
     * @param FixedLineOpportunity $fixedLineOpportunity
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Customer $customer, FixedLineOpportunity $fixedLineOpportunity)
    {
        if (Gate::denies('view-opportunity', $fixedLineOpportunity) || $fixedLineOpportunity->customer != $customer) {
            abort(404);
        }

        return view('fixed-line.opportunities.edit', [
            'customer' => $customer,
            'opportunity' => $fixedLineOpportunity,
            'networks' => FixedLineNetwork::pluck('name', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Customer $customer
     * @param FixedLineOpportunity $fixedLineOpportunity
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(
        FixedLineOpportunityRequest $request,
        Customer $customer,
        FixedLineOpportunity $fixedLineOpportunity
    ) {
        if ($request->has('recovered')) {
            $fixedLineOpportunity->recoverProcess($request->get('user_id'));
        } else {
            $data = collect($request->all())->filter(function ($value) {
                return !is_null($value) && $value != '';
            })->toArray();

            $fixedLineOpportunity->update($data);

            if ($request->has('networks')) {
                $fixedLineOpportunity->networks()->detach($fixedLineOpportunity->networks()->pluck('id'));

                $fixedLineOpportunity->networks()->attach($request->get('networks'));
            }
        }

        return $request->has('networks') || $request->has('openToNetworks')
            ? redirect("customers/$customer->id/fixed-line/opportunities/$fixedLineOpportunity->id")
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
