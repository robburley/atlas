<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Contact;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;

class CustomerContactController extends Controller
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
     * @param  \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        return view('customers.contacts.index', ['customer' => $customer]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer)
    {
        return view('customers.contacts.create', ['customer' => $customer]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Customer $customer
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Customer $customer, Request $request)
    {
        $contact = $customer->contacts()->create($request->all());

        return $request->wantsJson()
            ? $contact
            : redirect('/customers/' . $customer->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer $customer
     * @param  \App\Models\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer, Contact $contact)
    {
        return view('customers.contacts.edit', [
            'customer' => $customer,
            'contact' => $contact,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Customer $customer
     * @param  \App\Models\Contact $contact
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Customer $customer, Contact $contact, Request $request)
    {
        $contact->update($request->all());

        return redirect('/customers/' . $customer->id);
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
