<?php

namespace App\Http\Controllers\Reports\FixedLine;


use App\Helpers\FixedLineOpportunityStatusHelper;
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

        $agents = User::whereHas('createdFixedLineOpportunities', function ($query) use ($start, $end) {
            $query->where('appointment', 1)
                  ->whereBetween('created_at', [$start, $end]);
        })->with([
            'createdFixedLineOpportunities' => function ($query) use ($start, $end) {
                $query->where('appointment', 1)
                      ->whereBetween('created_at', [$start, $end]);
            }
        ])->get();

        $agents = $agents->map(function ($agent) {
            return [
                'lead generator name'   => $agent->name,
                'booked'                => $booked = $agent->createdFixedLineOpportunities->count(),
                'confirmed'             => $confirmed = $agent->createdFixedLineOpportunities
                    ->where('valid', 1)
                    ->count(),
                'blown'                 => $blown = $agent->createdFixedLineOpportunities
                    ->where('status.blown', 1)
                    ->where('valid', 0)
                    ->count(),
                'awaiting confirmation' => $booked - $confirmed - $blown,
                'confirm rate'          => $booked > 0 ? number_format(($confirmed / $booked) * 100, 2) . '%' : '--',
                'appointments sat'      => $sat = $agent->createdFixedLineOpportunities->where('qualified', 1)->count(),
                'sit rate'              => $confirmed > 0 ? number_format(($sat / $confirmed) * 100, 2) . '%' : '--',
                'deals'                 => $dealt = $agent->createdFixedLineOpportunities
                    ->filter(function ($item) {
                        return !empty($item->dealt_at) || count($item->purchaseOrder) > 0;
                    })
                    ->count(),
                'conversion'            => $sat > 0 ? number_format(($dealt / $sat) * 100, 2) . '%' : '--',
            ];
        });

        return view('reports.appointment-booking', [
            'agents' => $agents
        ]);
    }

}
