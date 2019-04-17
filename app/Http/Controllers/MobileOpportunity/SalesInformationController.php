<?php

namespace App\Http\Controllers\MobileOpportunity;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobileOpportunity\MobileSalesInformationRequest;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\MobileOpportunity;

class SalesInformationController extends Controller
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

    public function store(MobileSalesInformationRequest $request, Customer $customer, MobileOpportunity $opportunity)
    {
        $opportunity->salesInformation
            ? $opportunity->salesInformation->update($request->all())
            : $opportunity->salesInformation()->create($request->all());

        return redirect()->back();
    }
}
