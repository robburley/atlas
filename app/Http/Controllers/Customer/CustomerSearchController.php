<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;

class CustomerSearchController extends Controller
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
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(Request $request)
    {
        // Search for a unique customer with the telephone number provided
        $customer = Customer::where('telephone_number', $request->telephone_number)->first();

        // If a customer is found, redirect straight to the customer record at this point
        if ($customer) {
            alert()->warning('This customer already exists!', 'Warning')->persistent('Close');

            return redirect('/customers/' . $customer->id);
        }

        $companyName = str_replace('/', '-', $request->company_name);

        // If the same telephone number isn't found, search for customer records like the company name provided
        $results = Customer::like('company_name', $companyName)->get();

        // If search results are found, redirect to a list of the search results for the user to choose from
        if ($results->count()) {
            return view('customers.search')->with([
                'company'   => $companyName,
                'telephone' => $request->telephone_number,
                'results'   => $results
            ]);
        }

        // If search results are not found, continue to a form to create a new customer
        return redirect()->action('Customer\CustomerController@create', [
            'company'   => $companyName,
            'telephone' => $request->telephone_number,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
