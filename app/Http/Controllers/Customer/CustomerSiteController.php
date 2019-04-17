<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerSite;
use Illuminate\Http\Request;

class CustomerSiteController extends Controller
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
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        return view('customers.sites.index', ['customer' => $customer]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer)
    {
        return view('customers.sites.create', ['customer' => $customer]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Customer  $customer
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Customer $customer, Request $request)
    {
        $customer->sites()->create($request->all());

        return redirect('/customers/' . $customer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @param  \App\Models\CustomerSite  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer, CustomerSite $site)
    {
        return view('customers.sites.edit', [
            'customer' => $customer,
            'site'  => $site,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Customer  $customer
     * @param  \App\Models\CustomerSite  $site
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Customer $customer, CustomerSite $site, Request $request)
    {
        $site->update($request->all());

        return redirect('/customers/' . $customer->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
