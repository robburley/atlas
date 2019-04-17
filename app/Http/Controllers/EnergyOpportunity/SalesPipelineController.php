<?php

namespace App\Http\Controllers\EnergyOpportunity;

use App\Http\Controllers\Controller;
use App\Models\EnergyOpportunity\EnergyNetwork;
use App\Models\EnergyOpportunity\EnergyOpportunity;
use App\Models\EnergyOpportunity\EnergyOpportunityStatus;

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
     * @param EnergyOpportunityStatus $status
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('energy.opportunities.index', [
            'opportunities' => EnergyOpportunity::filters()->orderBy('created_at', 'desc')->paginate(50),
            'subTitle' => 'Pipeline'
        ]);
    }
}
