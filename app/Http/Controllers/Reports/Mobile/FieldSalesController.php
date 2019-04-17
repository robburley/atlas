<?php

namespace App\Http\Controllers\Reports\Mobile;

use App\Helpers\MobileOpportunityStatusHelper;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FieldSalesController extends Controller
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
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfDay();
        }

        $agents = User::whereHas('activeMobileAssigned', function ($query) use ($start, $end) {
            $query->where('mobile_opportunities.appointment', 1)
                ->whereBetween('mobile_opportunities.created_at', [$start, $end]);
        })->with([
            'activeMobileAssigned' => function ($query) use ($start, $end) {
                $query->where('mobile_opportunities.appointment', 1)
                    ->whereBetween('mobile_opportunities.created_at', [$start, $end]);
            }
        ])->get();

        $agents = $agents->map(function ($agent) {
            return [
                'rep name' => $agent->name,
                'appointments assigned' => $assigned = $agent->activeMobileAssigned->count(),
                'appointments sat' => $sat = $agent->activeMobileAssigned->where('qualified', 1)->count(),
                'sit rate' => $assigned > 0 ? number_format(($sat / $assigned) * 100, 2) . '%' : '--',
                'deals' => $dealt = $agent->createdMobileOpportunities->where('mobile_opportunity_status_id', (new MobileOpportunityStatusHelper)->get('awaiting-fulfilment'))->count(),
                'conversion' => $sat > 0 ? number_format(($dealt / $sat) * 100, 2) . '%' : '--',

            ];
        });

        return view('reports.field-sales', [
            'agents' => $agents
        ]);
    }

}
