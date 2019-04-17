<?php

namespace App\Http\Controllers\Tenders\Mobile;


use App\Models\Tenders\TenderInvitation;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;

class TenderInvitationController extends Controller
{
    public function show(TenderInvitation $invitation)
    {
        $handsets = $invitation->tender->mobileTenders()
                                       ->with(['allocation.handset'])
                                       ->get()
                                       ->map(function ($tender) {
                                           return $tender->allocation;
                                       })
                                       ->groupBy('handset_id')
                                       ->map(function ($handsets, $key) {
                                           return [
                                               'id'          => $key,
                                               'device'      => $handsets->first()->handset->name,
                                               'quantity'    => $handsets->count(),
                                               'unit_price'  => 0.0,
                                               'total_price' => 0.0,
                                               'lead_time'   => 1,
                                           ];
                                       })->sortBy('device');

        return view('tenders.mobile.show', [
            'invitation' => $invitation->load([
                'tender',
                'supplier',
            ]),
            'handsets'   => $handsets
        ]);
    }

    public function store(TenderInvitation $invitation, Request $request)
    {
        $this->validate($request, [
            'handsets.*.unit_price'  => 'required|numeric',
            'handsets.*.total_price' => 'required|numeric',
            'handsets.*.lead_time'   => 'required|numeric',
        ] , [
            'handsets.*.unit_price.min' => 'Each unit prices must be provided',
            'handsets.*.total_price.min' => 'Each total prices must be provided',
            'handsets.*.lead_time.min' => 'Each lead times must be provided',
        ]);

        DB::beginTransaction();

        try {
            $invitation->update([
                'completed_at' => Carbon::now()
            ]);

            foreach ($request->get('handsets') as $handset) {
                $mobileTenders = $invitation
                    ->tender
                    ->mobileTenders()
                    ->whereHas('allocation', function ($query) use ($handset) {
                        return $query->where('handset_id', $handset['id']);
                    })
                    ->get();

                $mobileTenders->each(function ($mobileTender) use ($invitation, $handset) {
                    $invitation->mobileInvitations()->create([
                        'allocation_id' => $mobileTender->allocation->id,
                        'unit_price'    => $handset['unit_price'],
                        'total_price'   => $handset['total_price'],
                        'lead_time'     => $handset['lead_time']
                    ]);
                });
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response(new MessageBag(['error' => 'There has been an error, please contact Win Win Management']), 500);
        }

        DB::commit();

        return $request->all();
    }
}
