<?php

namespace App\Http\Controllers\MobileOpportunity;

use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\MobileOpportunity\MobileOpportunityStatus;
use Carbon\Carbon;

class ConnectionLogController extends Controller
{
    /**
     * Create a new dashboard controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:view_connection_log_mobile');
    }

    /**
     * Display a listing of the resource.
     *
     * @param MobileOpportunityStatus $status
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $opportunities = MobileOpportunity::filters()
                                        ->whereNotNull('dealt_at')
                                        ->with([
                                            'customer',
                                            'creator',
                                            'activeAssigned.office',
                                            'allocations',
                                            'allocationsOrderedByConnection',
                                            'status',
                                            'selectedDealCalculator.overview',
                                            'selectedDealCalculator.credits',
                                            'selectedDealCalculator.contributions'
                                        ])
                                        ->orderBy('dealt_at', 'desc')
                                        ->orderBy('created_at', 'desc');

        $totalGp = $opportunities->sum('gp');

        $data = $opportunities->paginate(200);

        $data->setCollection($data->getCollection()->map(function ($opportunity) {
            $allocationsFiltered = $opportunity->hasAllocations()
                                        ? $opportunity->allocationsOrderedByConnection
                                                        ->filter(function ($opportunity) {
                                                            return $opportunity->connected;
                                                        })
                                        : null;

            return collect([
                'path'                 => $opportunity->path(),
                'customer_id'          => $opportunity->customer->id,
                'appointment'          => $opportunity->appointment,
                'hot_transfer'         => $opportunity->hot_transfer,
                'Customer'             => $opportunity->customer->company_name,
                'Connections'          => collect([
                                            'New connection' => $opportunity->hasAllocations() ? $opportunity->countConnectionsByType('New connection') : 0,
                                            'Port'           => $opportunity->hasAllocations() ? $opportunity->countConnectionsByType('Port') : 0,
                                            'Upgrade'        => $opportunity->hasAllocations() ? $opportunity->countConnectionsByType('Upgrade') : 0,
                                        ]),
                'Contracted L/R'       => $opportunity->selectedDealCalculator->first()
                                            ? $opportunity->selectedDealCalculator->first()->overview->lineRental
                                            : 0,
                'Total Income'         => $opportunity->selectedDealCalculator->first()
                                            ? $opportunity->selectedDealCalculator->first()->overview->income
                                            : 0,
                'Buyout'               => $opportunity->selectedDealCalculator->first() &&  $opportunity->selectedDealCalculator->first()->getBuyout() > 0
                                            ? $opportunity->selectedDealCalculator->first()->getBuyout()
                                            : 0,
                'Deal Inc'             => $opportunity->selectedDealCalculator->first() &&  $opportunity->selectedDealCalculator->first()->getCashBack() > 0
                                            ? $opportunity->selectedDealCalculator->first()->getCashBack()
                                            : 0,
                'Hardware Fund'        => $opportunity->selectedDealCalculator->first() &&  $opportunity->selectedDealCalculator->first()->getHardwareFund()->total > 0
                                            ? $opportunity->selectedDealCalculator->first()->getHardwareFund()->total
                                            : 0,
                'GP'                   => $opportunity->gp,
                'Closer'               => $opportunity->activeAssigned->first()->name ?? 'Not Assigned',
                'Lead Gen'             => $opportunity->creator->name,
                'Branch'               => $opportunity->activeAssigned->first()->office->name ?? 'No Office Assigned',
                'CC Date'              => $opportunity->credit_checked_at ? $opportunity->credit_checked_at->format('d/m/Y') : '',
                'Dealt Date'           => $opportunity->dealt_at ? $opportunity->dealt_at->format('d/m/Y') : '',
                'Part Connection Date' => $opportunity->hasAllocations() && !$allocationsFiltered->isEmpty()
                                            ? Carbon::parse($allocationsFiltered->first()->connected)->format('d/m/Y')
                                            : '--',
                'Connection Date'      => $opportunity->hasAllocations() && $opportunity->allocationsOrderedByConnection->count() == $allocationsFiltered->count()
                                            ? Carbon::parse($opportunity->allocationsOrderedByConnection->last()->connected)->format('d/m/Y')
                                            : '--',
                'Status'               => $opportunity->status->name,
                'status_colour'        => $opportunity->status->colour,
            ]);
        }));

        $total = collect([
            'Connections'          => collect([
                                        'New connection' => $data->sum('Connections.New connection'),
                                        'Port'           => $data->sum('Connections.Port'),
                                        'Upgrade'        => $data->sum('Connections.Upgrade'),
                                    ]),
            'Total Income'         => $data->sum('Total Income'),
            'Buyout'               => $data->sum('Buyout'),
            'Deal Inc'             => $data->sum('Deal Inc'),
            'Hardware Fund'        => $data->sum('Hardware Fund'),
            'GP'                   => $data->sum('GP'),
        ]);

        return view('mobile.opportunities.connection-log.index', [
            'opportunities'     => $data,
            'totalData'         => $total,
            'totalGp'           => number_format($totalGp, 2),
            'subTitle'          => 'Pipeline'
        ]);
    }
}
