<?php

namespace App\Http\Controllers\MobileOpportunity;

use App\Helpers\MobileOpportunityStatusHelper;
use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\MobileOpportunity\MobileOpportunityStatus;

class TeamAwaitingBillController extends Controller
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
        $users = auth()->user()->teamsModerator->pluck('users')->flatten()->pluck('id')->toArray();

        $opportunities = MobileOpportunity::filters()
            ->whereIn('created_by', $users)
            ->where('mobile_opportunity_status_id', (new MobileOpportunityStatusHelper)->get('awaiting-bill'))
            ->orderBy('status_updated_at', 'desc')
            ->paginate(50);


        return view('mobile.opportunities.index', [
            'opportunities' => $opportunities,
            'subTitle' => 'Team Awaiting Bill'
        ]);
    }
}
