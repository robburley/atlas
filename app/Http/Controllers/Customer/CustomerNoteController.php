<?php

namespace App\Http\Controllers\Customer;


use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CreateCustomerNoteRequest;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerNote;
use App\Models\User\UserNotification;
use Illuminate\Http\Request;

class CustomerNoteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Customer $customer, CreateCustomerNoteRequest $request)
    {
        $note = $customer->notes()->create($request->all());
        if ($request->notify_user_id) {

            $model = $note->notable
                ? $note->notable
                : $note->customer;

            $model->notifications()->create([
                'subject'   => auth()->user()->name . ' posted a note',
                'body'      => $note->body,
                'sender_id' => auth()->user()->id,
                'user_id'   => request('notify_user_id'),
            ]);
        }

        return redirect()->back();
    }

    public function update(Customer $customer, CustomerNote $customerNote)
    {
        $customerNote->update(request()->all());

        alert()->success('Customer note updated');

        return redirect()->back();
    }
}
