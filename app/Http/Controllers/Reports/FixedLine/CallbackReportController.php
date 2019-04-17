<?php

namespace App\Http\Controllers\Reports\FixedLine;

use App\Http\Controllers\Controller;
use App\Models\FixedLineOpportunity\FixedLineOpportunity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CallbackReportController extends Controller
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

        $opportunities = FixedLineOpportunity::where('fixed_line_opportunity_status_id', '>=', 4)
            ->notBlown()
            ->callbacksBetween([$start, $end])
            ->assigned(request()->get('assigned'))
            ->orderBy('created_by', 'asc')
            ->with([
                'activeAssigned',
                'callbacks',
            ])
            ->get();

        $opportunities = $opportunities->map(function($opportunity){
            $opportunity->last_callback = $opportunity->lastCallback()->first()->time ?? null;

            return $opportunity;
        })->filter(function($opportunity) use ($start, $end) {
            return $opportunity->last_callback ? $opportunity->last_callback->between($start, $end) : false;
        })
        ->sortBy('last_callback');

        return view('reports.callbacks', [
            'opportunities' => $opportunities
        ]);
    }

}
