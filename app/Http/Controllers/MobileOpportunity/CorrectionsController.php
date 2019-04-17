<?php

namespace App\Http\Controllers\MobileOpportunity;

use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\MobileOpportunity\MobileOpportunityStatus;

class CorrectionsController extends Controller
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
        return view('mobile.opportunities.index', [
            'opportunities' => MobileOpportunity::filters()
                ->awaitingCorrection()
                ->with([
                    'customer',
                    'creator',
                    'activeAssigned',
                    'inactiveAssigned',
                    'mobileBills',
                    'appointments',
                    'callbacks',
                    'incompleteCallbacks'
                ])
                ->viewPermissions()
                ->orderBy('dealt_at', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(50),
            'subTitle' => 'Pipeline'
        ]);
    }
}
