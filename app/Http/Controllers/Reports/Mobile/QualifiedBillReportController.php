<?php

namespace App\Http\Controllers\Reports\Mobile;

use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\MobileOpportunity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QualifiedBillReportController extends Controller
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

        $opportunities = MobileOpportunity::where(function ($qry) use ($start, $end) {
            $qry->where(function ($q) use ($start, $end) {
                $q->where('appointment', 1)
                    ->where('valid', 1)
                    ->whereBetween('validated_at', [$start, $end]);
            })->orWhere(function ($q) use ($start, $end) {
                $q->where('appointment', 0)
                    ->where('qualified', 1)
                    ->whereBetween('qualified_at', [$start, $end]);
            });
        })
            ->createdBy(request()->get('created'))
            ->orderBy('created_by', 'asc')
            ->orderBy('mobile_opportunity_status_id', 'asc')
            ->with([
                'customer',
                'creator',
                'activeAssigned',
            ])
            ->get();

//        $opportunities = $opportunities->filter(function ($opportunity) use ($start, $end) {
//            if ($opportunity->appointment) {
//                if ($opportunity->valid && $opportunity->validated_at >= $start && $opportunity->validated_at <= $end) {
//                    return true;
//                }
//            } else {
//                if ($opportunity->qualfied && $opportunity->qualfied_at >= $start && $opportunity->qualfied_at <= $end) {
//                    return true;
//                }
//            }
//
//            return false;
//        });

        return view('reports.qualified-bill', [
            'opportunities' => $opportunities
        ]);

//        qualifiedBetween([$start, $end])->qualified()
    }

}
