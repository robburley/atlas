<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\CashFlowItem;
use App\Models\Admin\CashFlowOneOff;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class CashFlowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Gate::denies('view-cashflow') && abort(404);

        $office      = request()->get('branch');
        $leadGen     = request()->get('lead_generator');
        $salesPerson = request()->get('sales_person');
        $companyName = request()->get('company_name');

        try {
            $start = Carbon::createFromFormat('d/m/Y', request()->get('start'))->startOfDay();
        } catch (\Exception $e) {
            $start = Carbon::now()->startOfDay();
        }

        try {
            $end = Carbon::createFromFormat('d/m/Y', request()->get('end'))->endOfDay();
        } catch (\Exception $e) {
            $end = Carbon::now()->endOfDay();
        }

        $monthStart = $start->copy()->startOfMonth();
        $yearStart  = $start->copy()->startOfYear();
        $monthEnd   = $monthStart->copy()->endOfMonth();
        $yearEnd    = $yearStart->copy()->endOfYear();

        $items = CashFlowItem::active()
                             ->when(!$companyName, function ($query) use ($start, $end) {
                                 $query->whereBetween('sales_date', [$start, $end]);
                             })
                             ->when($office, function ($query) use ($office) {
                                 $query->where('branch_id', $office);
                             })
                             ->when($leadGen, function ($query) use ($leadGen) {
                                 $query->where('lead_generator_id', $leadGen);
                             })
                             ->when($salesPerson, function ($query) use ($salesPerson) {
                                 $query->where('sales_person_id', $salesPerson);
                             })
                             ->when($companyName, function ($query) use ($companyName) {
                                 $query->where('company_name', 'LIKE', "%$companyName%");
                             })
                             ->with([
                                'leadGenerator',
                                'salesPerson',
                                'branch',
                                'opportunity',
                             ])
                             ->get();

        $total = [
            'turnover'           => $items->sum('turnover'),
            'hardware_fund'      => $items->sum('hardware_fund'),
            'hardware_fund_vat'  => $items->sum('hardware_fund_vat'),
            'handling_fees'      => $items->sum('handling_fees'),
            'handsets'           => $items->sum('handsets'),
            'sims'               => $items->sum('sims'),
            'sim_saves'          => $items->sum('sim_saves'),
            'delivery'           => $items->sum('delivery'),
            'total_cashback'     => $items->sum('total_cashback'),
            'total_cashback_vat' => $items->sum('total_cashback_vat'),
            'board_gp'           => $items->sum('board_gp'),
            'additional_percent' => $items->sum('additional_percent'),
            'additional_pounds'  => $items->sum('additional_pounds'),
        ];

        return view('admin.cashflow.index', [
            'items'      => $items,
            'total'      => $total,
            'month'      => $this->getTotals($monthStart, $monthEnd),
            'year'       => $this->getTotals($yearStart, $yearEnd),
            'monthStart' => $monthStart,
            'yearStart'  => $yearStart,
        ]);
    }

    public function getTotals($start, $end)
    {
        $oneOffs = CashFlowOneOff::whereBetween('date', [$start, $end])->get();

        $oneOffs = $oneOffs->groupBy('type')->map(function ($type) {
            return $type->sum('value');
        });

        $branches = collect([
            'All'             => 0,
            'Nantwich'        => 1,
            'Sunderland'      => 2,
            'Bishop Auckland' => 4,
            'Stoke'           => 6,
            'Manchester'      => 7
        ]);

        $branches = $branches->map(function ($id, $name) use ($start, $end, $oneOffs) {
            $data = CashFlowItem::active()
                                ->whereBetween('sales_date', [$start, $end])
                                ->when($id > 0, function ($query) use ($id) {
                                    return $query->where('branch_id', $id);
                                })
                                ->with([
                                    'opportunity.unactionedCorrections',
                                    'opportunity.status'
                                ])
                                ->get();

            $qcAndValidation = $data->where('opportunity.mobile_opportunity_status_id', 23);

            $inCorrection = $data->filter(function ($item) {
                return $item->opportunity->mobile_opportunity_status_id == 24 || count($item->opportunity->unactionedCorrections) > 0;
            });

            $awaitingCc = $data->whereIn('opportunity.mobile_opportunity_status_id', [11, 25, 26, 27, 30, 31, 32]);

            $declined = $data->filter(function ($item) {
                return !empty($item->declined_at);
            });

            $canceled = $data->filter(function ($item) {
                return !empty($item->canceled_at);
            });

            $passedCc = $data->whereIn('opportunity.mobile_opportunity_status_id', 12);

            return collect([
                'GP' => [
                    'Handling Fees' => $data->sum('handling_fees'),
                    'Sim Saves'     => $data->sum('sim_saves'),
                    'Board GP'      => $data->sum('board_gp'),
                    'Management GP' => collect([
                            $data->sum('board_gp'),
                            $data->sum('additional_percent'),
                            $data->sum('additional_pounds'),
                            $data->sum('total_cashback_vat'),
                            $data->sum('hardware_fund_vat')
                        ])->sum(),
                    'Total Company GP' => collect([
                            $data->sum('board_gp'),
                            $data->sum('additional_percent'),
                            $data->sum('additional_pounds'),
                            $data->sum('total_cashback_vat'),
                            $data->sum('hardware_fund_vat'),
                            $data->sum('handling_fees'),
                            $data->sum('sim_saves'),
                            $oneOffs->sum()
                        ])->sum()
                ],
                'QC and Validation' => [
                    'Board GP'      => $qcAndValidation->sum('board_gp'),
                    'Management GP' => $qcAndValidation->sum('board_gp') +
                        $qcAndValidation->sum('additional_percent') +
                        $qcAndValidation->sum('additional_pounds') +
                        $qcAndValidation->sum('total_cashback_vat') +
                        $qcAndValidation->sum('hardware_fund_vat'),
                ],
                'In Correction' => [
                    'Board GP'      => $inCorrection->sum('board_gp'),
                    'Management GP' => $inCorrection->sum('board_gp') +
                        $inCorrection->sum('additional_percent') +
                        $inCorrection->sum('additional_pounds') +
                        $inCorrection->sum('total_cashback_vat') +
                        $inCorrection->sum('hardware_fund_vat'),
                ],
                'Awaiting CC' => [
                    'Board GP'      => $awaitingCc->sum('board_gp'),
                    'Management GP' => $awaitingCc->sum('board_gp') +
                        $awaitingCc->sum('additional_percent') +
                        $awaitingCc->sum('additional_pounds') +
                        $awaitingCc->sum('total_cashback_vat') +
                        $awaitingCc->sum('hardware_fund_vat'),
                ],
                'Declined' => [
                    'Board GP'      => $declined->sum('board_gp'),
                    'Management GP' => $declined->sum('board_gp') +
                        $declined->sum('additional_percent') +
                        $declined->sum('additional_pounds') +
                        $declined->sum('total_cashback_vat') +
                        $declined->sum('hardware_fund_vat'),
                ],
                'Canceled' => [
                    'Board GP'      => $canceled->sum('board_gp'),
                    'Management GP' => $canceled->sum('board_gp') +
                        $canceled->sum('additional_percent') +
                        $canceled->sum('additional_pounds') +
                        $canceled->sum('total_cashback_vat') +
                        $canceled->sum('hardware_fund_vat'),
                ],
                'Passed CC' => [
                    'Board GP'      => $passedCc->sum('board_gp'),
                    'Management GP' => $passedCc->sum('board_gp') +
                        $passedCc->sum('additional_percent') +
                        $passedCc->sum('additional_pounds') +
                        $passedCc->sum('total_cashback_vat') +
                        $passedCc->sum('hardware_fund_vat'),
                ],
            ]);
        });
        
        return [
            'branches'         => $branches,
            'one offs'         => $oneOffs,
        ];
    }

    public function update(CashFlowItem $item)
    {
        Gate::denies('view-cashflow') && abort(404);

        $item->update(request()->all());

        alert()->success('Cashflow item updated');

        return redirect()->back();
    }

    public function destroy(CashFlowItem $item)
    {
        Gate::denies('view-cashflow') && abort(404);

        $item->update([
            'active'      => 0,
            'canceled_at' => Carbon::now()
        ]);

        alert()->success('Cashflow item removed');

        return redirect()->back();
    }
}
