<?php

namespace App\Http\Controllers\EnergyOpportunity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\MeterRequest;
use App\Models\Customer\Customer;
use App\Models\EnergyOpportunity\EnergyMeter;
use Illuminate\Http\Request;

class EnergyMeterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Customer $customer)
    {
        return view('energy.meters.create', [
            'customer' => $customer
        ]);
    }

    public function store(Customer $customer, MeterRequest $request)
    {
        $customer->energyMeters()->create($request->all());

        alert()->success('Meter created.', 'meter created for ' . $customer->company_name);

        return $request->opportunity
            ? redirect()->back()
            : redirect('/customers/' . $customer->id . '/energy');
    }

    public function edit(Customer $customer, EnergyMeter $meter)
    {
        return view('energy.meters.edit', [
            'meter' => $meter,
            'customer' => $customer
        ]);
    }

    public function update(Request $request, Customer $customer, EnergyMeter $meter)
    {
        $meter->update($request->all());

        alert()->success('Callback updated.', 'meter updated for ' . $customer->company_name);

        return redirect()->back();
    }
}
