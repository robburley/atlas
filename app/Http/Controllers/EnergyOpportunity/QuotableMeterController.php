<?php

namespace App\Http\Controllers\EnergyOpportunity;

use App\Http\Controllers\Controller;
use App\Models\EnergyOpportunity\EnergyMeter;
use App\Models\EnergyOpportunity\EnergyNetwork;
use App\Models\EnergyOpportunity\EnergyOpportunityStatus;
use Carbon\Carbon;

class QuotableMeterController extends Controller
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
        $date = Carbon::now()->addMonths(request()->get('months', 6));

        return view('energy.opportunities.quotable', [
            'meters' => EnergyMeter::where('contract_end_date', '<', $date)->whereDoesntHave('opportunities', function($query){
                $query->where('energy_opportunity_status_id', '<', 12)
                    ->orWhere('status_updated_at', '<=', Carbon::now()->subYear());
            })->get()
        ]);
    }
}
