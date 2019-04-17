<?php

namespace App\Http\Controllers\EnergyOpportunity;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\ScheduledCallback;
use App\Models\EnergyOpportunity\EnergyOpportunity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

    }

    public function create(Customer $customer)
    {

    }

    public function store(Customer $customer, EnergyOpportunity $energyOpportunity, Request $request)
    {

        if (count($energyOpportunity->incompleteCallbacks) >= 2) {
            alert()->error('An opportunity can only have 2 incomplete callbacks, Please completed or rearrange other callbacks and try again', 'Cannot Create Callback')->confirmButton();

            return redirect()->back();
        }

        if (auth()->user()->hitMaxCallbacks()) {

            alert()->error('You have more than 10 overdue callbacks, please complete or rearrange them and try again.', 'Cannot Create Callback')->confirmButton();

            return redirect()->back();
        }

        $energyOpportunity->callbacks()->create([
            'time' => $request->get('time'),
            'user_id' => auth()->user()->id,
            'created_by' => auth()->user()->id,
        ]);

        $energyOpportunity->customer->notes()->create([
            'customer_note_type_id' => 1,
            'body' => 'A call back has been set for energy opportunity ID:' . $energyOpportunity->id
        ]);

        alert()->success('Callback created.', 'callback created for ' . $energyOpportunity->customer->company_name);

        return redirect()->back();
    }

    public function show(Customer $customer, EnergyOpportunity $energyOpportunity)
    {

    }

    public function edit(Customer $customer, EnergyOpportunity $energyOpportunity, ScheduledCallback $callback)
    {
        return view('energy.opportunities.callbacks.edit', [
            'callback' => $callback
        ]);
    }

    public function update(
        Request $request,
        Customer $customer,
        EnergyOpportunity $energyOpportunity,
        ScheduledCallback $callback
    ) {
        $callback->update($request->all());

        alert()->success('Callback updated.', 'callback updated for ' . $energyOpportunity->customer->company_name);

        return redirect('/');
    }

    public function destroy(
        Request $request,
        Customer $customer,
        EnergyOpportunity $energyOpportunity,
        ScheduledCallback $callback
    ) {
        $callback->update([
            'completed_at' => Carbon::now(),
            'completed_by' => auth()->user()->id
        ]);

        return redirect()->back();
    }
}
