<?php

namespace App\Http\Controllers\FixedLineOpportunity;

use App\Http\Controllers\Controller;
use App\Models\FixedLineOpportunity\FixedLineOpportunity;
use App\Models\FixedLineOpportunity\FixedLineOpportunityStatus;

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
     * @param FixedLineOpportunityStatus $status
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('fixed-line.opportunities.index', [
            'opportunities' => FixedLineOpportunity::filters()
                ->with([
                    'networks',
                    'customer',
                    'creator',
                    'activeAssigned',
                ])
                ->viewPermissions()
                ->orderBy('created_at', 'desc')
                ->with([
                    'networks',
                    'customer',
                    'creator',
                    'activeAssigned',
                ])
                ->paginate(50),
            'subTitle' => 'Pipeline'
        ]);
    }
}
