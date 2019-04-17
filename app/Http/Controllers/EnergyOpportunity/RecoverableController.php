<?php

namespace App\Http\Controllers\EnergyOpportunity;

use App\Http\Controllers\Controller;
use App\Models\EnergyOpportunity\EnergyNetwork;
use App\Models\EnergyOpportunity\EnergyOpportunity;
use App\Models\EnergyOpportunity\EnergyOpportunityStatus;

class RecoverableController extends Controller
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
        $opportunities = EnergyOpportunity::whereHas('status', function ($query) {
            $query->where('blown', 1)
                ->where('unrecoverable', 0);
        })
            ->filters()
            ->orderBy('status_updated_at', 'desc')
            ->paginate(50);


        return view('energy.opportunities.index', [
            'opportunities' => $opportunities,
            'subTitle' => 'Recoverable'
        ]);
    }
}
