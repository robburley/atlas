<?php

namespace App\Http\Controllers\Dashboard;


use App\Helpers\DashboardHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\ScheduledCallback;
use App\Models\FixedLineOpportunity\FixedLineOpportunity;
use App\Models\MobileOpportunity\MobileOpportunity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new dashboard controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try {
            $start = Carbon::createFromFormat('d/m/Y', request()->get('start'))->startOfDay();
            $end = Carbon::createFromFormat('d/m/Y', request()->get('end'))->endOfDay();
        } catch (\Exception $e) {
            $start = Carbon::now()->startOfDay();
            $end = Carbon::now()->endOfDay();
        }

        $view = auth()->user()->hasPermission('show_all_leads_mobile')
            ? view('dashboards.administrator', [
                'leaderBoard'                          => DashboardHelper::getLeaderboard($start, $end),
                'appointmentLeaderBoard'               => DashboardHelper::getAppointmentLeaderboard($start, $end),
                'fixedLineLeaderBoard'                          => DashboardHelper::getFixedLineLeaderboard($start, $end),
                'fixedLineAppointmentLeaderBoard'               => DashboardHelper::getFixedLineAppointmentLeaderboard($start, $end),


                'opportunities'                        => MobileOpportunity::ignoreUsers()->billOrRequirements($start, $end)->isNotAppointment()->count(),
                'hasBillToday'                         => MobileOpportunity::ignoreUsers()->hasBills($start, $end)->isNotAppointment()->count(),
                'hasNoBillToday'                       => MobileOpportunity::ignoreUsers()->noBills($start, $end)->isNotHotTransfer()->isNotAppointment()->count(),
                'hotTransfersToday'                    => MobileOpportunity::ignoreUsers()->noBills($start, $end)->isHotTransfer()->isNotAppointment()->count(),
                'qualifiedOpportunities'               => MobileOpportunity::ignoreUsers()->qualified()->qualifiedBetween([$start, $end])->isNotAppointment()->count(),
                'notQualifiedOpportunities'            => MobileOpportunity::ignoreUsers()->notQualified()->qualifiedBetween([$start, $end])->isNotAppointment()->count(),
                'appointmentQualifiedOpportunities'    => MobileOpportunity::ignoreUsers()->valid($start, $end)->isAppointment()->count(),
                'appointmentNotQualifiedOpportunities' => MobileOpportunity::ignoreUsers()->notValid($start, $end)->isAppointment()->count(),
                'appointmentOpportunities'             => MobileOpportunity::ignoreUsers()->billOrRequirements($start, $end)->isAppointment()->count(),

                'fixedLineQualifiedOpportunities' => FixedLineOpportunity::ignoreUsers()->valid($start, $end)->isNotAppointment()->count(),
                'fixedLineNotQualifiedOpportunities' => FixedLineOpportunity::ignoreUsers()->notValid($start, $end)->isNotAppointment()->count(),


                'fixedLineOpportunities'                        => FixedLineOpportunity::ignoreUsers()->billOrRequirements($start, $end)->isNotAppointment()->count(),
                'fixedLineHasBillToday'                         => FixedLineOpportunity::ignoreUsers()->hasBills($start, $end)->isNotAppointment()->count(),
                'fixedLineHasNoBillToday'                       => FixedLineOpportunity::ignoreUsers()->noBills($start, $end)->isNotHotTransfer()->isNotAppointment()->count(),
                'fixedLineHotTransfersToday'                    => FixedLineOpportunity::ignoreUsers()->noBills($start, $end)->isHotTransfer()->isNotAppointment()->count(),
                
                'fixedLineAppointmentQualifiedOpportunities' => FixedLineOpportunity::ignoreUsers()->valid($start, $end)->isAppointment()->count(),
                'fixedLineAppointmentNotQualifiedOpportunities' => FixedLineOpportunity::ignoreUsers()->notValid($start, $end)->isAppointment()->count(),
                'fixedLineAppointmentOpportunities' => FixedLineOpportunity::ignoreUsers()->billOrRequirements($start, $end)->isAppointment()->count(),

                'callbacks'                            => ScheduledCallback::incomplete()
                                                                           ->upToThisWeek()
                                                                           ->orderBy('time', 'asc')
                                                                           ->mine()
                                                                           ->with('opportunity')
                                                                           ->get(),
            ])
            : view('dashboards.agent', [
                'leaderBoard'                          => DashboardHelper::getLeaderboard($start, $end),
                'appointmentLeaderBoard'               => DashboardHelper::getAppointmentLeaderboard($start, $end),
                'fixedLineLeaderBoard'                          => DashboardHelper::getFixedLineLeaderboard($start, $end),
                'fixedLineAppointmentLeaderBoard'               => DashboardHelper::getFixedLineAppointmentLeaderboard($start, $end),


                'opportunities'                        => MobileOpportunity::billOrRequirements($start, $end)->createdByMe()->isNotAppointment()->count(),
                'hasBillToday'                         => MobileOpportunity::hasBills($start, $end)->createdByMe()->isNotAppointment()->count(),
                'hasNoBillToday'                       => MobileOpportunity::noBills($start, $end)->createdByMe()->isNotHotTransfer()->isNotAppointment()->count(),
                'hotTransfersToday'                    => MobileOpportunity::noBills($start, $end)->createdByMe()->isHotTransfer()->isNotAppointment()->count(),
                'qualifiedOpportunities'               => MobileOpportunity::qualified()->qualifiedBetween([$start, $end])->createdByMe()->isNotAppointment()->count(),
                'notQualifiedOpportunities'            => MobileOpportunity::notQualified()->qualifiedBetween([$start, $end])->createdByMe()->isNotAppointment()->count(),
                'appointmentQualifiedOpportunities'    => MobileOpportunity::ignoreUsers()->valid($start, $end)->isAppointment()->createdByMe()->count(),
                'appointmentNotQualifiedOpportunities' => MobileOpportunity::ignoreUsers()->notValid($start, $end)->isAppointment()->createdByMe()->count(),
                'appointmentOpportunities'             => MobileOpportunity::ignoreUsers()->billOrRequirements($start, $end)->isAppointment()->createdByMe()->count(),
                'callbacks'                            => ScheduledCallback::incomplete()
                                                                           ->upToThisWeek()
                                                                           ->orderBy('time', 'asc')
                                                                           ->mine()
                                                                           ->with('opportunity')
                                                                           ->get(),
            ]);

        return $view;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
