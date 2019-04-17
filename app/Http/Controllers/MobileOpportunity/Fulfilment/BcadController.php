<?php

namespace App\Http\Controllers\MobileOpportunity\Fulfilment;

use App\Http\Controllers\Controller;
use App\Mail\JucGenerated;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerFileType;
use App\Models\MobileOpportunity\FulfilmentTimeLineItem;
use App\Models\MobileOpportunity\MobileOpportunity;
use Illuminate\Support\Facades\Mail;

class BcadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:awaiting_fulfilment_mobile');
    }

    public function index()
    {
        $opportunities = MobileOpportunity::awaitingBcad()
                                          ->viewPermissions()
                                          ->orderBy('credit_checked_at', 'desc')
                                          ->orderBy('dealt_at', 'desc')
                                          ->orderBy('created_at', 'desc')
                                          ->paginate(50);

        return view('mobile.opportunities.fulfilment.bcad.index', [
            'opportunities' => $opportunities,
        ]);
    }

    public function create(Customer $customer, MobileOpportunity $opportunity)
    {
        return view('mobile.opportunities.fulfilment.bcad.create', [
            'customer'    => $customer,
            'opportunity' => $opportunity
        ]);
    }

    public function store(Customer $customer, MobileOpportunity $opportunity)
    {
        if (request()->has('bcad_reference')) {
            $this->validate(request(), [
                'bcad_reference' => 'required',
            ]);

            $opportunity->update([
                'bcad_reference' => request()->get('bcad_reference')
            ]);

            FulfilmentTimeLineItem::create([
                'action'                => 'BCAD Reference Added',
                'mobile_opportunity_id' => $opportunity->id,
                'user_id'               => auth()->user()->id,
            ]);

            alert()->success('BCAD Reference saved');

            return redirect($opportunity->path());
        }

        $this->validate(request(), [
            'file' => 'required|file',
        ]);

        $file = $customer->files()->create(request()->except('file'));

        $fileType = CustomerFileType::where('slug', 'mobile_juc')->first();

        $fileName = $fileType->slug . '/' . $fileType->slug . ' - ' . $file->id;

        request()->file('file')->storeAs(
            $customer->id,
            $fileName . '.' . request()->file('file')->clientExtension()
        );

        $file->update([
            'location'              => $customer->id . '/' . $fileName . '.' . request()->file('file')->clientExtension(),
            'customer_file_type_id' => $fileType->id
        ]);

        $customer->notes()->create([
            'customer_note_type_id' => 5,
            'body'                  => 'A ' . $fileType->name . ' file has been uploaded.',
            'notable_type'          => request()->get('related_type'),
            'notable_id'            => request()->get('related_id'),
        ]);

//        Mail::to('rob@winwincr.co.uk')
        Mail::to('nahelkhona@chesspartner.co.uk')
    //    Mail::to('paulrawlinson@chesspartner.co.uk')
            ->send(new JucGenerated($opportunity, storage_path("app/$file->location")));

        alert()->success('JUC sent');

        return redirect()->back();
    }
}
