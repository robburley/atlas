<?php

namespace App\Http\Controllers\FixedLineOpportunity;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\ScheduledCallback;
use App\Models\FixedLineOpportunity\FixedLineOpportunity;
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

    public function store(Customer $customer, FixedLineOpportunity $fixedLineOpportunity, Request $request)
    {
        if (count($fixedLineOpportunity->incompleteCallbacks) >= 2) {
            alert()->error('An opportunity can only have 2 incomplete callbacks, Please completed or rearrange other callbacks and try again', 'Cannot Create Callback')->confirmButton();

            return redirect()->back();
        }

        if (auth()->user()->hitMaxCallbacks()) {

            alert()->error('You have more than 10 overdue callbacks, please complete or rearrange them and try again.', 'Cannot Create Callback')->confirmButton();

            return redirect()->back();
        }

        $fixedLineOpportunity->callbacks()->create([
            'time' => $request->get('time'),
            'user_id' => auth()->user()->id,
            'created_by' => auth()->user()->id,
        ]);

        $fixedLineOpportunity->customer->notes()->create([
            'customer_note_type_id' => 1,
            'body' => 'A call back has been set for fixedLine opportunity ID:' . $fixedLineOpportunity->id
        ]);

        alert()->success('Callback created.', 'callback created for ' . $fixedLineOpportunity->customer->company_name);

        return redirect()->back();
    }

    public function show(Customer $customer, FixedLineOpportunity $fixedLineOpportunity)
    {

    }

    public function edit(Customer $customer, FixedLineOpportunity $fixedLineOpportunity, ScheduledCallback $callback)
    {
        return view('fixed-line.opportunities.callbacks.edit', [
            'callback' => $callback
        ]);
    }

    public function update(
        Request $request,
        Customer $customer,
        FixedLineOpportunity $fixedLineOpportunity,
        ScheduledCallback $callback
    ) {
        $callback->update($request->all());

        alert()->success('Callback updated.', 'callback updated for ' . $fixedLineOpportunity->customer->company_name);

        return redirect('/');
    }

    public function destroy(
        Request $request,
        Customer $customer,
        FixedLineOpportunity $fixedLineOpportunity,
        ScheduledCallback $callback
    ) {
        $callback->update([
            'completed_at' => Carbon::now(),
            'completed_by' => auth()->user()->id
        ]);

        return redirect()->back();
    }
}
