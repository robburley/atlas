<?php

namespace App\Http\Controllers\Reports\FixedLine;

use App\Http\Controllers\Controller;
use App\Models\User\Role;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AgentReportController extends Controller
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

        $data = $this->getData($start, $end);

        return view('reports.agents', [
            'data' => $data
        ]);
    }

    public function getData($start, $end)
    {
        $users = User::active()->whereHas('role', function ($query) {
            $query->where('roles.id', Role::where('name', 'Lead Generator')->first()->id);
        })
            ->get();

        $data = $users->map(function ($user) use ($start, $end) {
            $data = collect([
                'name' => $user->name,
                'leads' => $user->createdFixedLineOpportunities()->dateRange($start, $end)->count(),
                'qualified' => $user->createdFixedLineOpportunities()->qualified()->qualifiedBetween([$start, $end])->count(),
                'not-qualified' => $user->createdFixedLineOpportunities()->notQualified()->qualifiedBetween([$start, $end])->count(),
                'pending-qualification' => $user->createdFixedLineOpportunities()->pendingQualification()->dateRange($start, $end)->count(),
                'deals' => $user->createdFixedLineOpportunities()->dateRange($start, $end)->status(['Awaiting Credit Check', 'Passed Credit Check'])->count(),
            ]);

            return $data;
        })->sortByDesc('leads');

        $data = $data->push(collect([
            'name' => 'Total',
            'leads' => $data->sum('leads'),
            'qualified' => $data->sum('qualified'),
            'not-qualified' => $data->sum('not-qualified'),
            'pending-qualification' => $data->sum('pending-qualification'),
            'deals' => $data->sum('deals'),
        ]));

        return $data;
    }

    public function getPercent($total, $number)
    {
        return $number > 0
            ? number_format(($number / $total) * 100, 2) . '%'
            : '0.00%';
    }
}
