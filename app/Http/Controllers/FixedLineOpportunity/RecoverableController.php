<?php

namespace App\Http\Controllers\FixedLineOpportunity;

use App\Http\Controllers\Controller;
use App\Models\FixedLineOpportunity\FixedLineOpportunity;
use App\Models\FixedLineOpportunity\FixedLineOpportunityStatus;

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
     * @param FixedLineOpportunityStatus $status
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $opportunities = FixedLineOpportunity::filters()
            ->with([
                'networks',
                'customer',
                'creator',
                'activeAssigned',
            ])
            ->whereHas('status', function ($query) {
                $query->where('blown', 1)
                    ->where('unrecoverable', 0);
            })
            ->orderBy('status_updated_at', 'desc')
            ->paginate(50);


        return view('fixed-line.opportunities.index', [
            'opportunities' => $opportunities,
            'subTitle' => 'Recoverable'
        ]);
    }
}
