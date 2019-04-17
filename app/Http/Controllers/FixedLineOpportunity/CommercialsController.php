<?php

namespace App\Http\Controllers\FixedLineOpportunity;


use App\Http\Controllers\Controller;
use App\Http\Requests\FixedLineOpportunity\CommercialsRequest;
use App\Models\Customer\Customer;
use App\Models\FixedLineOpportunity\FixedLineOpportunity;

class CommercialsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Customer $customer, FixedLineOpportunity $opportunity, CommercialsRequest $request)
    {
        $opportunity->commercials
            ? $opportunity->commercials->update($request->all())
            : $opportunity->commercials()->create($request->all());

        return $opportunity->commercials()
                           ->with(['lines'])
                           ->first();
    }

    public function show(Customer $customer, FixedLineOpportunity $opportunity)
    {
        return $opportunity->commercials()
                           ->with(['lines'])
                           ->first();
    }
}
