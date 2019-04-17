<?php

namespace App\Http\Controllers\MobileOpportunity\Fulfilment;

use App\Http\Controllers\Controller;
use App\Mail\ConnectionTemplateUploaded;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerFileType;
use App\Models\MobileOpportunity\Allocation;
use App\Models\MobileOpportunity\FulfilmentTimeLineItem;
use App\Models\MobileOpportunity\MobileOpportunity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Mail;

class ConnectionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:awaiting_fulfilment_mobile');
    }

    public function index()
    {
        $opportunities = MobileOpportunity::awaitingConnection()
                                          ->viewPermissions()
                                          ->orderBy('credit_checked_at', 'desc')
                                          ->orderBy('dealt_at', 'desc')
                                          ->orderBy('created_at', 'desc')
                                          ->paginate(50);

        return view('mobile.opportunities.fulfilment.connections.index', [
            'opportunities' => $opportunities,
        ]);
    }

    public function create(Customer $customer, MobileOpportunity $opportunity)
    {
        return view('mobile.opportunities.fulfilment.connections.create', [
            'customer'    => $customer,
            'opportunity' => $opportunity
        ]);
    }

    public function store(Customer $customer, MobileOpportunity $opportunity)
    {
        $this->validate(request(), [
            'file'    => 'required|file',
            'subject' => 'required'
        ]);

        $file = $this->storeConnectionTemplate($customer, $opportunity);

        // Mail::to('rob@winwincr.co.uk')
        Mail::to('elitepartner@chesspartner.co.uk')
//            ->bcc('rob@winwincr.co.uk')
            ->send(new ConnectionTemplateUploaded($opportunity, storage_path("app/$file->location"), request()->get('subject')));

        foreach (request()->get('data') as $allocation) {
            Allocation::find($allocation)->update([
                'sent_for_connection' => Carbon::now(),
            ]);

            FulfilmentTimeLineItem::create([
                'action'                => 'Sent for connection',
                'mobile_opportunity_id' => $opportunity->id,
                'user_id'               => auth()->user()->id,
                'allocation_id'         => $allocation,
            ]);
        }

        alert()->success('Lines Sent for connection');

        return redirect($opportunity->path());
    }

    public function storeConnectionTemplate($customer, $opportunity)
    {
        $fileType = CustomerFileType::where('name', 'Connection Template')->first();

        $file = $customer->files()->create([
            'related_id'            => $opportunity->id,
            'related_type'          => 'mobileOpportunity',
            'customer_file_type_id' => $fileType->id,
        ]);

        $fileName = $fileType->slug . '/' . $fileType->slug . ' - ' . $file->id;

        request()->file('file')->storeAs(
            $customer->id,
            $fileName . '.' . request()->file('file')->extension()
        );

        $file->update([
            'location' => $customer->id . '/' . $fileName . '.' . request()->file('file')->extension()
        ]);

        $customer->notes()->create([
            'customer_note_type_id' => 5,
            'body'                  => 'A ' . $fileType->name . ' file has been uploaded.',
            'notable_type'          => request()->get('related_type'),
            'notable_id'            => request()->get('related_id'),
        ]);

        return $file;
    }
}
