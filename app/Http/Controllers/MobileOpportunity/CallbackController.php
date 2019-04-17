<?php

namespace App\Http\Controllers\MobileOpportunity;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\ScheduledCallback;
use App\Models\MobileOpportunity\MobileOpportunity;
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

    public function store(Customer $customer, MobileOpportunity $mobileOpportunity, Request $request)
    {
        $this->validate($request, [
            'time' => 'required|date_format:d/m/Y H:i:s'
        ]);

        if (count($mobileOpportunity->incompleteCallbacks) >= 2) {
            alert()->error('An opportunity can only have 2 incomplete callbacks, Please completed or rearrange other callbacks and try again', 'Cannot Create Callback')->confirmButton();

            return redirect()->back();
        }

        if (auth()->user()->hitMaxCallbacks()) {

            alert()->error('You have more than 10 overdue callbacks, please complete or rearrange them and try again.', 'Cannot Create Callback')->confirmButton();

            return redirect()->back();
        }

        $mobileOpportunity->callbacks()->create([
            'time' => $request->get('time'),
            'user_id' => auth()->user()->id,
            'created_by' => auth()->user()->id,
        ]);

        $mobileOpportunity->customer->notes()->create([
            'customer_note_type_id' => 1,
            'body' => 'A call back has been set for mobile opportunity ID:' . $mobileOpportunity->id
        ]);

        alert()->success('Callback created.', 'callback created for ' . $mobileOpportunity->customer->company_name);

        return redirect()->back();
    }

    public function show(Customer $customer, MobileOpportunity $mobileOpportunity)
    {

    }

    public function edit(Customer $customer, MobileOpportunity $mobileOpportunity, ScheduledCallback $callback)
    {
        return view('mobile.opportunities.callbacks.edit', [
            'callback' => $callback
        ]);
    }

    public function update(
        Request $request,
        Customer $customer,
        MobileOpportunity $mobileOpportunity,
        ScheduledCallback $callback
    ) {
        $callback->update($request->all());

        alert()->success('Callback updated.', 'callback updated for ' . $mobileOpportunity->customer->company_name);

        return redirect('/');
    }

    public function destroy(
        Request $request,
        Customer $customer,
        MobileOpportunity $mobileOpportunity,
        ScheduledCallback $callback
    ) {
        $callback->update([
            'completed_at' => Carbon::now(),
            'completed_by' => auth()->user()->id
        ]);

        return redirect()->back();
    }
}
