<?php

namespace App\Http\Controllers\MobileOpportunity;


use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\MobileOpportunity\MobileOpportunityStatus;
use Carbon\Carbon;

class QualifiedController extends Controller
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
     * @param MobileOpportunityStatus $status
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $start = Carbon::createFromFormat('d/m/Y', request()->get('created_from'))->startOfDay();
            $end = Carbon::createFromFormat('d/m/Y', request()->get('created_to'))->endOfDay();
        } catch (\Exception $e) {
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfDay();
        }

        $opportunities = MobileOpportunity::filters()
                                          ->where('appointment', 0)
                                          ->qualified()
                                          ->qualifiedBetween([$start, $end])
                                          ->where('created_by', auth()->user()->id)
                                          ->with([
                                              'customer',
                                              'creator',
                                              'activeAssigned',
                                              'inactiveAssigned',
                                              'mobileBills',
                                              'appointments',
                                              'callbacks',
                                              'incompleteCallbacks'
                                          ]);

        return view('mobile.opportunities.index', [
            'total'         => $opportunities->count(),
            'opportunities' => $opportunities->orderBy('status_updated_at', 'desc')->paginate(50),
            'subTitle'      => 'My Qualified Leads'
        ]);
    }
}

//charlieeverett
//CEwinwin2017