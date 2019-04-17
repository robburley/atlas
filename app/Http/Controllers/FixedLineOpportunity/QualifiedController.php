<?php

namespace App\Http\Controllers\FixedLineOpportunity;

use App\Http\Controllers\Controller;
use App\Models\FixedLineOpportunity\FixedLineOpportunity;
use App\Models\FixedLineOpportunity\FixedLineOpportunityStatus;
use Carbon\Carbon;

class QualifiedController extends Controller
{
    /**
     * Create a new dashboard controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param FixedLineOpportunityStatus $status
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $start = Carbon::createFromFormat('d/m/Y', request()->get('created_from'))->startOfDay();
            $end = Carbon::createFromFormat('d/m/Y', request()->get('created_to'))->endOfDay();
        } catch (\Exception $e) {
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfDay();
        }

        $opportunities = FixedLineOpportunity::filters()
            ->where(function ($qry) use ($start, $end) {
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
            ->where('created_by', auth()->user()->id);

        return view('fixed-line.opportunities.index', [
            'total' => $opportunities->count(),
            'opportunities' => $opportunities->orderBy('status_updated_at', 'desc')->paginate(50),
            'subTitle' => 'My Qualified Leads'
        ]);
    }
}

//charlieeverett
//CEwinwin2017