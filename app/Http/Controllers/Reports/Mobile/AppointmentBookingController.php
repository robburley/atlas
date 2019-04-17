<?php

namespace App\Http\Controllers\Reports\Mobile;


use App\Helpers\MobileOpportunityStatusHelper;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $start = Carbon::createFromFormat('d/m/Y', $request->get('start'))->startOfDay();
            $end = Carbon::createFromFormat('d/m/Y', $request->get('end'))->endOfDay();
        } catch (\Exception $e) {
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfDay();
        }

        $agents = User::when(request()->has('office_id'), function ($query) {
            return $query->where('office_id', request()->get('office_id'));
        })->whereHas('createdMobileOpportunities', function ($query) use ($start, $end) {
            $query->where('appointment', 1)
                  ->where('mobile_opportunity_status_id', '>', 1)
                  ->whereBetween('created_at', [$start, $end]);
        })->with([
            'createdMobileOpportunities' => function ($query) use ($start, $end) {
                $query->where('appointment', 1)
                      ->whereBetween('created_at', [$start, $end])
                      ->where('mobile_opportunity_status_id', '>', 1)
                      ->with([
                          'status'
                      ]);
            }
        ])->get();

        $agents = $agents->map(function ($agent) {
            return [
                'lead generator name'   => $agent->name,
                'booked'                => $booked = $agent->createdMobileOpportunities->count(),
                'confirmed'             => $confirmed = $agent->createdMobileOpportunities
                    ->where('valid', 1)
                    ->count(),
                'blown'                 => $blown = $agent->createdMobileOpportunities
                    ->where('status.blown', 1)
                    ->where('valid', 0)
                    ->count(),
                'awaiting confirmation' => $booked - $confirmed - $blown,
                'confirm rate'          => $booked > 0 ? number_format(($confirmed / $booked) * 100, 2) . '%' : '--',
                'appointments sat'      => $sat = $agent->createdMobileOpportunities->where('qualified', 1)->count(),
                'sit rate'              => $confirmed > 0 ? number_format(($sat / $confirmed) * 100, 2) . '%' : '--',
                'deals'                 => $dealt = $agent->createdMobileOpportunities
                    ->filter(function ($item){
                        return !empty($item->dealt_at) || count($item->purchaseOrder) > 0;
                    })
                    ->count(),
                'conversion'            => $sat > 0 ? number_format(($dealt / $sat) * 100, 2) . '%' : '--',
            ];
        })->sortByDesc('appointments booked');

        return view('reports.appointment-booking', [
            'agents' => $agents
        ]);
    }

}
