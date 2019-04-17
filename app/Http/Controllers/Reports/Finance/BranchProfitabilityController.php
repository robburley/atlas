<?php

namespace App\Http\Controllers\Reports\Finance;


use App\Models\User\Office;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class BranchProfitabilityController extends Controller
{
    public function index()
    {
        Gate::denies('view-profitability') && abort(404);

        $branch = auth()->user()->id != 35
            ? request()->get('office_id', 1)
            : 2;

        try {
            $start = Carbon::createFromFormat('d/m/Y', request()->get('start'));
        } catch (\Exception $e) {
            $start = Carbon::now()->startOfMonth();
        }

        try {
            $end = Carbon::createFromFormat('d/m/Y', request()->get('end'));
        } catch (\Exception $e) {
            $end = Carbon::now()->endOfMonth();
        }

        $agents = User::where('created_at', '<=', $end)
                      ->where(function ($query) use ($end) {
                          $query->whereNull('deactivated_at')
                                ->orWhere('deactivated_at', '<=', $end);
                      })
                      ->where('role_id', 4)
                      ->when($branch != 'all', function ($query) use ($branch) {
                          $query->where('office_id', $branch);
                      })
                      ->get();

        $agents = $agents->map(function ($agent) use ($start, $end) {
            return [
                'name'          => $agent->name,
                'active'        => $agent->active,
                'bills'         => $agent->createdMobileOpportunities()
                                         ->hasBills($start, $end)
                                         ->count(),
                'requirements'  => $agent->createdMobileOpportunities()
                                         ->noBills($start, $end)
                                         ->count(),
                'total'         => $agent->createdMobileOpportunities()
                                         ->billOrRequirements($start, $end)
                                         ->count(),
                'qualified'     => $agent->createdMobileOpportunities()
                                         ->qualified()
                                         ->qualifiedBetween([$start, $end])
                                         ->count(),
                'not-qualified' => $agent->createdMobileOpportunities()
                                         ->notQualified()
                                         ->billOrRequirements($start, $end)
                                         ->count(),
                'deals'         => $agent->createdMobileOpportunities()
                                         ->dealtBetween([$start, $end])
                                         ->count(),
                'gp'            => $agent->createdMobileOpportunities()
                                         ->dealtBetween([$start, $end])
                                         ->sum('gp'),
            ];
        })->sortByDesc('total');

        return view('reports.finance.branch-profitability', [
            'agents' => $agents
        ]);
    }
}
