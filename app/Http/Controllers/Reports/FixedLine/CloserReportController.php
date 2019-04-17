<?php

namespace App\Http\Controllers\Reports\FixedLine;

use App\Http\Controllers\Controller;
use App\Models\User\Role;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CloserReportController extends Controller
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

        return view('reports.closers', [
            'data' => $data
        ]);
    }

    public function getData($start, $end)
    {
        $users = User::active()->whereHas('permissions', function ($query) {
            $query->where('permissions.slug', 'assignable_fixed_line');
        })
            ->get();

        $count = 0;

        $data = $users->map(function ($user) use ($start, $end, &$count) {
            $count++;

            $issuedTotal = $user->fixedLineAssigned()->dateRange($start, $end)->get()->unique('id')->count();
            $total = $user->activeFixedLineAssigned()->dateRange($start, $end)->count();
            $awaitingQual = $user->activeFixedLineAssigned()
                ->status([
                    'Awaiting Closer Contact',
                    'Awaiting Callback'
                ])
                ->dateRange($start, $end)
                ->count();
            $callback = $user->activeFixedLineAssigned()->status(['Awaiting Callback'])->dateRange($start, $end)->count();
            $qualified = $user->activeFixedLineAssigned()->qualified()->dateRange($start, $end)->count();
            $notQualified = $user->activeFixedLineAssigned()->notQualified()->dateRange($start, $end)->count();
            $dealt = $user->activeFixedLineAssigned()
                ->status([
                    'Awaiting Credit Check',
                    'Passed Credit Check',
                    'Failed Credit Check'
                ])
                ->dateRange($start, $end)
                ->count();
            $passed = $user->activeFixedLineAssigned()->status(['Passed Credit Check'])->dateRange($start, $end)->count();
            $blown = $user->activeFixedLineAssigned()->blown()->dateRange($start, $end)->count();

            $data = collect([
                'name' => $user->name,
                'Issued' => $issuedTotal,
                'Active Issued' => $total,
                'Active Issued Percent' => $this->getPercent($issuedTotal, $total),
                'Awaiting Qualification' => $awaitingQual,
                'Awaiting Qualification Percent' => $this->getPercent($total, $awaitingQual),
                'Awaiting Callback' => $callback,
                'Awaiting Callback Percent' => $this->getPercent($total, $callback),
                'Qualified' => $qualified,
                'Qualified Percent' => $this->getPercent($total, $qualified),
                'Not Qualified' => $notQualified,
                'Not Qualified Percent' => $this->getPercent($total, $notQualified),
                'Dealt' => $dealt,
                'Dealt Percent' => $this->getPercent($total, $dealt),
                'Passed' => $passed,
                'Passed Percent' => $this->getPercent($total, $passed),
                'Blown' => $blown,
                'Blown Percent' => $this->getPercent($total, $blown),
            ]);

            return $data;
        })->sortByDesc('Issued');

        $data = $data->push(collect([
            'name' => 'Total',
            'Issued' => $totalIssued = $data->sum('Issued'),
            'Active Issued' => $totalActive = $data->sum('Active Issued'),
            'Active Issued Percent' => $this->getPercent($totalIssued, $totalActive),
            'Awaiting Qualification' => $issued = $data->sum('Awaiting Qualification'),
            'Awaiting Qualification Percent' => $this->getPercent($totalIssued, $issued),
            'Awaiting Callback' => $callback = $data->sum('Awaiting Callback'),
            'Awaiting Callback Percent' => $this->getPercent($totalIssued, $callback),
            'Qualified' => $qualified = $data->sum('Qualified'),
            'Qualified Percent' => $this->getPercent($totalIssued, $qualified),
            'Not Qualified' => $notQualified = $data->sum('Not Qualified'),
            'Not Qualified Percent' => $this->getPercent($totalIssued, $notQualified),
            'Closed' => $closed = $data->sum('Closed'),
            'Closed Percent' => $this->getPercent($totalIssued, $closed),
            'Dealt' => $dealt = $data->sum('Dealt'),
            'Dealt Percent' => $this->getPercent($totalIssued, $dealt),
            'Passed' => $passed = $data->sum('Passed'),
            'Passed Percent' => $this->getPercent($totalIssued, $passed),
            'Blown' => $blown = $data->sum('Blown'),
            'Blown Percent' => $this->getPercent($totalIssued, $blown),
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
