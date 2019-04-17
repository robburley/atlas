<?php

namespace App\Http\Controllers\Reports\Mobile;


use App\Helpers\MobileOpportunityStatusHelper;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentsConfirmedController extends Controller
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
            $start = Carbon::now()->startOfDay();
            $end = Carbon::now()->endOfDay();
        }

        $agents = User::when(request()->get('office_id'), function ($query) {
            return $query->where('office_id', request()->get('office_id'));
        })
                      ->where(function ($qry) use ($start, $end) {
                          $qry->whereHas('createdMobileOpportunities', function ($query) use ($start, $end) {
                              $query->where('appointment', 1)
                                    ->where('valid', 1)
                                    ->whereBetween('validated_at', [$start, $end]);
                          });
                          
                          $qry->orWhereHas('createdMobileOpportunities', function ($query) use ($start, $end) {
                              $query->where('appointment', 1)
                                    ->whereBetween('created_at', [$start, $end]);
                          });

                      })
                      ->get();

        $agents = $agents->map(function ($agent) use ($start, $end) {
            return [
                'lead generator name'    => $agent->name,
                'appointments confirmed' => $confirmed = $agent->createdMobileOpportunities()->where('appointment', 1)
                                                               ->where('valid', 1)
                                                               ->whereBetween('validated_at', [$start, $end])
                                                               ->count(),
                'appointments created'   => $confirmed = $agent->createdMobileOpportunities()->where('appointment', 1)
                                                               ->whereBetween('created_at', [$start, $end])
                                                               ->count(),
            ];
        })->sortByDesc('appointments created');

        return view('reports.appointments-confirmed', [
            'agents' => $agents
        ]);
    }

}
