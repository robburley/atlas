<?php

namespace App\Http\Controllers\Reports\Mobile;

use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\MobileOpportunity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ValidatorReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $start = Carbon::createFromFormat('d/m/Y', $request->get('start'))->startOfDay();
            $end   = Carbon::createFromFormat('d/m/Y', $request->get('end'))->endOfDay();
        } catch (\Exception $e) {
            $start = Carbon::now()->subDay()->startOfMonth();
            $end   = Carbon::now()->subDay()->endOfDay();
        }

        $data = $this->getData($start, $end);

        return view('reports.mobile.validator', [
            'data'  => $data,
            'start' => $start,
            'end'   => $end,
        ]);
    }

    public function getData($start, $end)
    {
        return MobileOpportunity::validatedBetween($start, $end)
                                ->whereNull('hot_transfer')
                                ->when(request()->has('office'), function ($q) {
                                    $q->whereHas('validator', function ($q) {
                                        $q->where('office_id', request()->office);
                                    });
                                })
                                ->with([
                                    'validator'
                                ])
                                ->get()
                                ->groupBy('validator.name')
                                ->map(function ($opportunities, $key) {
                                    return [
                                        'validated'  => $validated = $opportunities->count(),
                                        'qualified'  => $qualifed = $opportunities->filter(function ($opportunity) {
                                            return $opportunity->qualified == 1;
                                        })->count(),
                                        'qualified_percent' => $validated > 0
                                            ? number_format($qualifed / $validated * 100, 2)
                                            : 0,
                                        'dealt' => $dealt = $opportunities->filter(function ($opportunity) {
                                            return $opportunity->dealt_at;
                                        })->count(),
                                        'dealt_percent' => $qualifed > 0
                                            ? number_format($dealt / $qualifed * 100, 2)
                                            : 0,
                                    ];
                                })
                                ->sortByDesc('validated');
    }
}
