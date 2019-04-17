<?php

namespace App\Http\Controllers\MobileOpportunity\Fulfilment;

use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\MobileOpportunity;

class PendingUnlocksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:awaiting_fulfilment_mobile');
    }

    public function index()
    {
        $opportunities = MobileOpportunity::pendingUnlock()
                                          ->viewPermissions()
                                          ->orderBy('credit_checked_at', 'desc')
                                          ->orderBy('dealt_at', 'desc')
                                          ->orderBy('created_at', 'desc')
                                          ->paginate(50);

        return view('mobile.opportunities.fulfilment.unlocks.index', [
            'opportunities' => $opportunities,
        ]);
    }
}
