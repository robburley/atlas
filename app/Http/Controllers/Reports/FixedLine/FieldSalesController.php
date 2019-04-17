<?php

namespace App\Http\Controllers\Reports\FixedLine;

use App\Helpers\FixedLineOpportunityStatusHelper;
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

        $agents = User::whereHas('activeFixedLineAssigned', function ($query) use ($start, $end) {
            $query->where('fixed_line_opportunities.appointment', 1)
                ->whereBetween('fixed_line_opportunities.created_at', [$start, $end]);
        })->with([
            'activeFixedLineAssigned' => function ($query) use ($start, $end) {
                $query->where('fixed_line_opportunities.appointment', 1)
                    ->whereBetween('fixed_line_opportunities.created_at', [$start, $end]);
            }
        ])->get();

        $agents = $agents->map(function ($agent) {
            return [
                'rep name' => $agent->name,
                'appointments assigned' => $assigned = $agent->activeFixedLineAssigned->count(),
                'appointments sat' => $sat = $agent->activeFixedLineAssigned->where('qualified', 1)->count(),
                'sit rate' => $assigned > 0 ? number_format(($sat / $assigned) * 100, 2) . '%' : '--',
                'deals' => $dealt = $agent->createdFixedLineOpportunities->where('fixed_line_opportunity_status_id', (new FixedLineOpportunityStatusHelper)->get('awaiting-provisioning'))->count(),
                'conversion' => $sat > 0 ? number_format(($dealt / $sat) * 100, 2) . '%' : '--',

            ];
        });

        return view('reports.field-sales', [
            'agents' => $agents
        ]);
    }

}
