<?php

namespace App\Http\Controllers\Reports\Mobile;

use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\MobileOpportunity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PitchCloseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $start = Carbon::createFromFormat('d/m/Y', $request->get('start'))->startOfDay();
            $end = Carbon::createFromFormat('d/m/Y', $request->get('end'))->endOfDay();
        } catch (\Exception $e) {
            $start = Carbon::now()->startOfDay();
            $end = Carbon::now()->endOfDay();
        }

        $opportunities = MobileOpportunity::where('hot_transfer', 1)
            ->whereBetween('created_at', [$start, $end])
            ->createdBy(request()->get('created'))
            ->statusId(request()->get('mobile_opportunity_status_id'))
            ->orderBy('created_by', 'asc')
            ->orderBy('mobile_opportunity_status_id', 'asc')
            ->with([
                'customer',
                'creator',
                'activeAssigned',
            ])
            ->paginate(50);
        return view('reports.pitch-close', [
            'opportunities' => $opportunities
        ]);
    }

}
