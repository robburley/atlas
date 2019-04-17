<?php

namespace App\Http\Controllers\MobileOpportunity\Fulfilment;


use App\Helpers\MobileOpportunityStatusHelper;
use App\Http\Controllers\Controller;
use App\Mail\JucGenerated;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerFileType;
use App\Models\MobileOpportunity\FulfilmentTimeLineItem;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\Tenders\Supplier;
use App\Models\Tenders\Tender;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class TendersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:awaiting_fulfilment_mobile');
    }

    public function index()
    {
        $tenders = Tender::orderBy('expires_at', 'desc')
                         ->whereHas('type', function ($query) {
                             return $query->where('name', 'mobile');
                         })
                         ->with([
                             'invitation',
                             'completeInvitation'
                         ])
                         ->paginate(50);

        return view('mobile.admin.tenders.index', [
            'tenders' => $tenders
        ]);
    }

    public function show(Tender $tender)
    {
        $tender = $tender->load([
            'type',
            'mobileTenders.allocation.handset',
            'invitation.mobileInvitations',
        ]);

        if ($tender->type->name != 'mobile') {
            abort(404);
        }

        $handsets = $tender->mobileTenders()
                           ->with(['allocation.handset'])
                           ->get()
                           ->map(function ($mobileTender) {
                               return $mobileTender->allocation;
                           })
                           ->groupBy('handset_id')
                           ->map(function ($handsets, $key) use ($tender) {
                               if (!empty($key)) {
                                   $data = $tender->invitation->map(function ($invitation) use ($handsets, $key) {
                                       return collect([
                                           'response' => $invitation->mobileInvitations()
                                                                    ->where('allocation_id', $handsets->first()->id)
                                                                    ->first(),
                                           'supplier' => $invitation->supplier->name
                                       ]);
                                   });

                                   return collect([
                                       'id'       => $key,
                                       'device'   => $handsets->first()->handset->name,
                                       'quantity' => $handsets->count(),
                                       'data'     => $data
                                   ]);
                               }

                               return null;
                           })
                           ->filter()
                           ->sortBy('device');

        return view('mobile.admin.tenders.show', [
            'tender'   => $tender,
            'handsets' => $handsets
        ]);
    }
}
