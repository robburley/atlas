<?php

namespace App\Http\Controllers\Reports\General;


use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\User\Office;
use App\Models\User\Role;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BranchReportController extends Controller
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

        return view('reports.general.branch', [
            'data' => $this->getData($start, $end)
        ]);
    }

    public function getData($start, $end)
    {
        $offices = auth()->user()->hasPermission('reports-skip-branch-restrictions')
            ? ['nantwich', 'sunderland', 'stoke', 'manchester']
            : [auth()->user()->office->slug];

        return Office::whereIn('slug', $offices)
                     ->with(['users'])
                     ->get()
                     ->keyBy('name')
                     ->map(function ($office) use ($start, $end) {
                         return collect([
                             'data'        => $this->getOverview($office, $start, $end),
                             'leaderboard' => $this->getLeaderBoard($office, $start, $end)
                         ]);
                     });
    }

    public function getLeaderBoard($office, $start, $end)
    {
        return User::where('office_id', $office->id)
                   ->whereHas('createdMobileOpportunities', function ($query) use ($start, $end) {
                       $query->billOrRequirements($start, $end)
                             ->ignoreUsers();
                   })
                   ->get()
                   ->map(function ($user) use ($start, $end) {
                       return [
                           'name'  => $user->name,
                           'count' => $user->createdMobileOpportunities()->billOrRequirements($start, $end)->count()
                       ];
                   })
                   ->sortByDesc('count');
    }

    public function getOverview($office, $start, $end)
    {
        return [
            'Total Leads Generated' => MobileOpportunity::creatorOffice($office)
                                                        ->billOrRequirements($start, $end)
                                                        ->ignoreUsers()
                                                        ->count(),

            'Appointments Booked' => [
                'Total' => MobileOpportunity::creatorOffice($office)
                                            ->billOrRequirements($start, $end)
                                            ->isAppointment()
                                            ->ignoreUsers()
                                            ->count(),

                'Confirmed' => MobileOpportunity::creatorOffice($office)
                                                ->isAppointment()
                                                ->ignoreUsers()
                                                ->valid($start, $end)
                                                ->count(),

                'Sat' => MobileOpportunity::creatorOffice($office)
                                          ->isAppointment()
                                          ->ignoreUsers()
                                          ->qualifiedBetween([$start, $end])
                                          ->count(),
            ],

            'Telesales Leads' => [
                'Total' => MobileOpportunity::creatorOffice($office)
                                            ->billOrRequirements($start, $end)
                                            ->isNotAppointment()
                                            ->ignoreUsers()
                                            ->count(),

                'Bills' => MobileOpportunity::creatorOffice($office)
                                            ->isNotAppointment()
                                            ->isNotHotTransfer()
                                            ->hasBills($start, $end)
                                            ->ignoreUsers()
                                            ->count(),

                'Requirements' => MobileOpportunity::creatorOffice($office)
                                                   ->isNotAppointment()
                                                   ->isNotHotTransfer()
                                                   ->noBills($start, $end)
                                                   ->ignoreUsers()
                                                   ->count(),

                'Hot Transfers' => MobileOpportunity::creatorOffice($office)
                                                    ->isNotAppointment()
                                                    ->isHotTransfer()
                                                    ->noBillDate($start, $end)
                                                    ->ignoreUsers()
                                                    ->count(),
            ],

            'Total Sales' => MobileOpportunity::creatorOffice($office)
                                              ->whereHas('status', function ($qry) {
                                                  $qry->where('won', 1);
                                              })
                                              ->dealtBetween([$start->startOfDay(), $end->endOfDay()])
                                              ->count(),

            'Total Sales GP' => '£' . number_format(
                    MobileOpportunity::creatorOffice($office)
                                     ->whereHas('status', function ($qry) {
                                         $qry->where('won', 1);
                                     })
                                     ->dealtBetween([$start->startOfDay(), $end->endOfDay()])
                                     ->get()
                                     ->pluck('gp')
                                     ->sum()
                    , 2)
        ];
    }
}
