<?php

namespace App\Http\Controllers\MobileOpportunity;

use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\MobileOpportunity\MobileOpportunityStatus;

class SalesPipelineController extends Controller
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
        $opportunities = MobileOpportunity::filters()
                                            ->with([
                                                'customer',
                                                'creator',
                                                'activeAssigned',
                                                'inactiveAssigned',
                                                'mobileBills',
                                                'appointments',
                                                'callbacks',
                                                'incompleteCallbacks',
                                                'status'
                                            ])
                                            ->viewPermissions()
                                            ->orderBy('created_at', 'desc');

        return view('mobile.opportunities.index', [
            'opportunities' => $opportunities->paginate(50),
            'totalGp'       => number_format($opportunities->sum('gp'), 2),
            'subTitle'      => 'Pipeline'
        ]);
    }
}
