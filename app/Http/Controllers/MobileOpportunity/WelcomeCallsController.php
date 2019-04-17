<?php

namespace App\Http\Controllers\MobileOpportunity;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\MobileOpportunity;
use Illuminate\Http\Request;

class WelcomeCallsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Customer $customer, MobileOpportunity $opportunity)
    {
        $opportunity->welcomeCall
            ? $opportunity->welcomeCall()->update($request->except(['_method', '_token']))
            : $opportunity->welcomeCall()->create($request->except(['_method', '_token']));

        return redirect()->back();
    }
}
