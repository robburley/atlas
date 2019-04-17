<?php

namespace App\Http\Controllers\MobileOpportunity;


use App\Http\Controllers\Controller;
use App\Mail\SalesSheetGenerated;
use App\Models\Admin\CashFlowItem;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerFileType;
use App\Models\MobileOpportunity\DealCalculator\DealCalculator;
use App\Models\MobileOpportunity\FulfilmentTimeLineItem;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\User\User;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SalesSheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Customer $customer, MobileOpportunity $opportunity)
    {
        $this->generateSalesSheet($customer, $opportunity);

        alert()->success('Sales Sheet Generated');

        return redirect()->back();
    }

    public function updateCashFlow($dealCalculator, $opportunity)
    {
        $tariffs = $dealCalculator->connections()->whereHas('tariff', function ($query) {
            return $query->whereHas('type', function ($qry) {
                return $qry->where('vas', 0);
            });
        })->get();

        $vas = $dealCalculator->connections()->whereHas('tariff', function ($query) {
            return $query->whereHas('type', function ($qry) {
                return $qry->where('vas', 1);
            });
        })->get();

        $tariffTotal = $tariffs->map(function ($tarriff) {
            return $tarriff->gp * $tarriff->connections;
        })->sum();

        $vasTotal = $vas->map(function ($tarriff) {
            return $tarriff->gp * $tarriff->connections;
        })->sum();

        $totalIncome = $tariffTotal + $vasTotal;

        $handsetTotal = $dealCalculator->handsets->map(function ($handset) {
            return $handset->value * $handset->units;
        })->sum();

        $simCards = $dealCalculator->getSimCards()
            ? $dealCalculator->getSimCards()->units
            : 0;

        $simCardTotal = $dealCalculator->getSimCards() && $dealCalculator->getSimCards()->units > 0
            ? $simCards * $dealCalculator->getSimCards()->value
            : 0;

        $hardwareFund = $dealCalculator->getHardwareFund()->total ?? 0;

        $hardwareFundWithoutVat = ($hardwareFund / 1.2);

        $hardwareFundVat = $hardwareFund - $hardwareFundWithoutVat;

        $cashBack = $dealCalculator->getBuyout() + $dealCalculator->getCashBack();

        $cashBackWithoutVat = ($cashBack / 1.2);

        $cashBackVat = $cashBack - $cashBackWithoutVat;

        $opportunity->cashFlowItem()->delete();

        $opportunity->cashFlowItem()->create([
            'sales_date'         => $opportunity->dealt_at,
            'generated_date'     => Carbon::now(),
            'branch_id'          => $opportunity->creator->office_id,
            'company_name'       => $opportunity->customer->company_name,
            'network'            => 'o2',
            'number_of_lines'    => $simCards,
            'sales_person_id'    => $opportunity->activeAssigned()->first()->id,
            'lead_generator_id'  => $opportunity->creator->id,
            'turnover'           => round($tariffTotal + $vasTotal, 2),
            'hardware_fund'      => round($hardwareFund, 2),
            'hardware_fund_vat'  => round($hardwareFundVat, 2),
            'handling_fees'      => round($dealCalculator->overview->handlingFee, 2),
            'handsets'           => round($handsetTotal, 2),
            'sims'               => round($simCardTotal, 2),
            'sim_saves'          => round($simCardTotal / 2, 2),
            'delivery'           => round(20, 2),
            'total_cashback'     => round($cashBack, 2),
            'total_cashback_vat' => round($cashBackVat, 2),
            'board_gp'           => round($dealCalculator->overview->totalProfit, 2),
            'additional_percent' => round((($dealCalculator->overview->lineRental * 36) * 0.01) - ($dealCalculator->overview->bcad * 0.01),
                2),
            'additional_pounds'  => round($simCards * 50, 2),
        ]);
    }

    public function generateSalesSheet($customer, $opportunity)
    {

        $fileType = CustomerFileType::where('slug', 'sales_sheet')->first();

        $file = $customer->files()->create([
            'related_type'          => 'mobileOpportunity',
            'related_id'            => $opportunity->id,
            'customer_file_type_id' => $fileType->id,
        ]);

        $name = "$fileType->slug-$file->id.pdf";
        $path = "$customer->id/$fileType->slug/$name";

        $file->update([
            'location' => $path
        ]);

        $dealCalculator = $opportunity->selectedDealCalculator()
                                      ->with([
                                          'creator',
                                          'accessories',
                                          'contributions',
                                          'credits',
                                          'handsets',
                                          'primaryConnections',
                                          'secondaryConnections',
                                          'connections',
                                          'overview',
                                      ])->first();

        $this->updateCashFlow($dealCalculator, $opportunity);

        SnappyPdf::loadView('mobile.opportunities.pdf.sales-sheet', [
            'dealCalculator' => $dealCalculator,
            'customer'       => $customer,
            'opportunity'    => $opportunity,
        ])
                 ->setOption('margin-bottom', 0)
                 ->setOption('margin-top', 0)
                 ->setOption('margin-left', 0)
                 ->setOption('margin-right', 0)
                 ->save(storage_path("app/$path"));

        $user = User::find(0)->id;

        if (request()->has('user')) {
            $user = request()->get('user');
        }

        if(auth()->user()) {
            $user = auth()->user()->id;
        }

        FulfilmentTimeLineItem::create([
            'action'                => 'Sales Sheet Generated',
            'mobile_opportunity_id' => $opportunity->id,
            'user_id'               => $user,
        ]);

        Mail::to(['dave@winwincr.co.uk'])
            ->send(new SalesSheetGenerated($opportunity, storage_path("app/$path")));
    }
}
