<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  string  $company
     * @param  string  $telephone
     * @return \Illuminate\Http\Response
     */
    public function create($company = null, $telephone = null)
    {
        return view('customers.create', [
            'company'   => $company,
            'telephone' => $telephone,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCustomerRequest $request)
    {
        $customer = auth()->user()->createdCustomers()->create($request->all());

        $customer->contacts()->create($request->all());

        return redirect('/customers/' . $customer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('customers.show', [
            'customer'  => $customer,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', ['customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Customer  $customer
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Customer $customer, Request $request)
    {
        $customer->update($request->all());

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
