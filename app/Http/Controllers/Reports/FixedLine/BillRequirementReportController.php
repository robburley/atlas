<?php

namespace App\Http\Controllers\Reports\FixedLine;

use App\Http\Controllers\Controller;
use App\Models\FixedLineOpportunity\FixedLineOpportunity;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BillRequirementReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $start = $request->has('start_date')
            ? Carbon::createFromFormat('d/m/Y', $request->start_date)->startOfDay()
            : Carbon::now()->startOfMonth();

        $end = $request->has('end_date')
            ? Carbon::createFromFormat('d/m/Y', $request->end_date)->endOfDay()
            : Carbon::now()->endOfDay();

        $data = collect([
            [
                'name' => 'Total',
                'bill' => $dayBill = FixedLineOpportunity::whereHas('fixedLineBills', function ($q) use ($start, $end) {
                    $q->whereBetween('created_at', [$start, $end]);
                })->count(),
                'noBill' => $dayNoBill = FixedLineOpportunity::whereBetween('no_bill_date', [$start, $end])->where('no_bill', 1)->count(),
                'total' => $todayTotal = $dayBill + $dayNoBill,
                'billPercent' => $todayTotal > 0 ? number_format(($dayBill / $todayTotal) * 100, 2) : '--',
                'noBillPercent' => $todayTotal > 0 ? number_format(($dayNoBill / $todayTotal) * 100, 2) : '--',
            ]
        ]);

        $users = User::where('role_id', 4)->whereHas('permissions', function ($query) {
            $query->where('slug', 'create_fixed_line');
        })->get();

        foreach ($users as $user) {
            $data = $data->merge([
                [
                    'name' => $user->name,
                    'bill' => $dayBill = $user->createdFixedLineOpportunities()->whereHas('FixedLineBills',
                        function ($q) use ($start, $end) {
                            $q->whereBetween('created_at', [$start, $end]);
                        })->count(),
                    'noBill' => $dayNoBill = $user->createdFixedLineOpportunities()->where('no_bill', 1)->whereBetween('no_bill_date', [$start, $end])->count(),
                    'total' => $todayTotal = $dayBill + $dayNoBill,
                    'billPercent' => $todayTotal > 0 ? number_format(($dayBill / $todayTotal) * 100, 2) : '--',
                    'noBillPercent' => $todayTotal > 0 ? number_format(($dayNoBill / $todayTotal) * 100, 2) : '--',
                ]
            ]);
        }

        return view('reports.bill-requirements', [
            'data' => $data->sortByDesc('total')
        ]);
    }

}