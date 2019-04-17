<?php

namespace App\Http\Controllers\Reports\General;

use App\Helpers\MobileOpportunityStatusHelper;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JourneyTeamController extends Controller
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

        $agents = User::whereHas('createdJourneyTeamSurveys', function ($query) use ($start, $end) {
            $query->whereBetween('created_at', [$start, $end]);
        })->with([
            'createdJourneyTeamSurveys' => function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            }
        ])->get();

        $agents = $agents->map(function ($agent) {
            return [
                'lead generator name' => $agent->name,
                'total' => $booked = $agent->createdJourneyTeamSurveys->count(),
                'mobile_complete' => $booked = $agent->createdJourneyTeamSurveys->where('mobile_complete', 1)->count(),
                'fixed_line_complete' => $booked = $agent->createdJourneyTeamSurveys->where('fixed_line_complete', 1)->count(),
                'energy_complete' => $booked = $agent->createdJourneyTeamSurveys->where('energy_complete', 1)->count(),
                'water_complete' => $booked = $agent->createdJourneyTeamSurveys->where('water_complete', 1)->count(),
                'it_complete' => $booked = $agent->createdJourneyTeamSurveys->where('it_complete', 1)->count(),
                'vehicle_tracking_complete' => $booked = $agent->createdJourneyTeamSurveys->where('vehicle_tracking_complete', 1)->count(),
            ];
        });

        return view('reports.journey-team-survey', [
            'agents' => $agents
        ]);
    }

}
