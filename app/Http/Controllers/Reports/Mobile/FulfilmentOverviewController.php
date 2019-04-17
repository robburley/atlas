<?php

namespace App\Http\Controllers\Reports\Mobile;

use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\MobileOpportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FulfilmentOverviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        Gate::denies('view-cashflow') && abort(404);

        return view('reports.mobile.fulfilment-overview', [
            'data' => $this->getData(),
        ]);
    }

    public function getData()
    {
        $opportunities = MobileOpportunity::whereIn('mobile_opportunity_status_id', [23, 25, 26, 27, 29, 30, 31, 32])
                                          ->with([
                                              'cashFlowItem',
                                              'status',
                                          ])
                                          ->get()
                                          ->sortBy('status.order')
                                          ->groupBy('status.name')
                                          ->map(function ($status) {
                                              return $this->getFigures($status);
                                          });

        $opportunities->prepend(
            $this->getFigures(MobileOpportunity::awaitingCorrection()->get(), true),
            'Awaiting Correction'
        );

        $data = collect([
            'Awaiting BCAD'       => $this->getFigures(MobileOpportunity::awaitingBcad()->get()),
            'Pending BCAD'        => $this->getFigures(MobileOpportunity::pendingBcad()->get()),
            'Awaiting PAC Code'   => $this->getFigures(MobileOpportunity::awaitingPacCode()->get()),
            'Awaiting SIMs'       => $this->getFigures(MobileOpportunity::awaitingSims()->get()),
            'Awaiting Stock'      => $this->getFigures(MobileOpportunity::awaitingStock()->get()),
            'Awaiting Unlock'     => $this->getFigures(MobileOpportunity::awaitingUnlocks()->get()),
            'Pending Unlock'      => $this->getFigures(MobileOpportunity::pendingUnlock()->get()),
            'Awaiting Port'       => $this->getFigures(MobileOpportunity::awaitingPort()->get()),
            'Awaiting Connection' => $this->getFigures(MobileOpportunity::awaitingConnection()->get()),
            'Pending Connection'  => $this->getFigures(MobileOpportunity::pendingConnection()->get()),
            'Connection Deferred' => $this->getFigures(MobileOpportunity::connectionDeferred()->get()),
            'Connection Error'    => $this->getFigures(MobileOpportunity::connectionError()->get()),
        ]);

        $opportunities->put(
            'Awaiting Fulfilment',
            collect(
                $this->getFigures(MobileOpportunity::where('mobile_opportunity_status_id', 12)
                                                   ->notFullyConnected()
                                                   ->get()
                )
            )->merge(['secondary' => $data])->toArray()
        );

        $opportunities->put('Totals', [
            'count'        => $opportunities->sum('count'),
            'income'       => $opportunities->sum('income'),
            'boardGp'      => $opportunities->sum('boardGp'),
            'managementGp' => $opportunities->sum('managementGp'),
            'companyGp'    => $opportunities->sum('companyGp'),
        ]);

        return $opportunities;
    }

    public function getFigures($data, $estimate = false)
    {
        return [
            'count'        => $data->count(),
            'income'       => $estimate ? 0 : $data->sum('cashFlowItem.turnover'),
            'boardGp'      => $estimate ? $data->sum('gp') : $data->sum('cashFlowItem.board_gp'),
            'managementGp' => $estimate
                ? 0
                : collect([
                    $data->sum('cashFlowItem.board_gp'),
                    $data->sum('cashFlowItem.additional_percent'),
                    $data->sum('cashFlowItem.additional_pounds'),
                    $data->sum('cashFlowItem.total_cashback_vat'),
                    $data->sum('cashFlowItem.hardware_fund_vat'),
                ])->sum(),
            'companyGp'    => $estimate
                ? 0
                : collect([
                    $data->sum('cashFlowItem.board_gp'),
                    $data->sum('cashFlowItem.additional_percent'),
                    $data->sum('cashFlowItem.additional_pounds'),
                    $data->sum('cashFlowItem.total_cashback_vat'),
                    $data->sum('cashFlowItem.hardware_fund_vat'),
                    $data->sum('cashFlowItem.handling_fees'),
                    $data->sum('cashFlowItem.sim_saves'),
                ])->sum(),
        ];
    }
}
