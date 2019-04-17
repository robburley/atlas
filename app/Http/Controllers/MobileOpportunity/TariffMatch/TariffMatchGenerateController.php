<?php

namespace App\Http\Controllers\MobileOpportunity\TariffMatch;

use App\Helpers\TariffMatch\TariffHelper;
use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\DealCalculator\DealCalculator;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\MobileOpportunity\Phone;
use Illuminate\Http\Request;
use App\Helpers\TariffMatch\DealCalculatorHelper;

class TariffMatchGenerateController extends Controller
{
    public function store(MobileOpportunity $opportunity)
    {
        set_time_limit(1000);

        if (!$opportunity->tariffMatch) {
            abort(404);
        }

        $lines = $opportunity
            ->tariffMatch
            ->requirements
            ->count();

        $secondaries = $lines == 1
            ? $lines
            : $lines - 1;

        $totalData = $opportunity
            ->tariffMatch
            ->requirements
            ->sum('data');

        $singleData = $opportunity
            ->tariffMatch
            ->requirements
            ->pluck('data');

        if ($opportunity->tariffMatch->expected_monthly_cost <= 40) {
            $minutes = 2000;
        } else {
            $minutes = 5000;
        }

        $tariffs = (new TariffHelper($minutes, $totalData, $singleData, $secondaries))->handle();

        $handsets = $opportunity->tariffMatch
            ->requirements
            ->pluck('device')
            ->map(function ($handset) {
                return Phone::find($handset) ?? null;
            });

        $dealCalculatorCount = count(request()->get('deal_calculators'));

        $dealCalculators = $dealCalculatorCount == 0
            ? $this->getDealCalculators($opportunity, $tariffs, $handsets)
            : $this->convertDealCalculators($dealCalculatorCount, $opportunity, $tariffs, $handsets);

        $totalMinutes = $tariffs->flatten()
                                ->map(function ($tariff) {
                                    return $tariff->uk_minutes;
                                })->sum();

        $totalData = $tariffs->flatten()
                             ->map(function ($tariff) {
                                 return $tariff->uk_data;
                             })->sum();

        return [
            'total'           => $dealCalculators['total'],
            'lines'           => $lines,
            'totalMinutes'    => $totalMinutes,
            'totalData'       => $totalData,
            'handsets'        => $handsets->groupBy('id'),
            'dealCalculators' => $dealCalculators['calcs'],
            'buyout'          => $dealCalculators['calcs']['Without Handsets'][0]['calc']['credits'][2]['total'] ?? $dealCalculators['calcs']['With Handsets'][0]['calc']['credits'][2]['total']
        ];
    }

    public function storeDealCalculator($opportunity, $dealCalculator, $primary)
    {
        if (count($opportunity->allocations) > 0) {
            $opportunity->allocations()->delete();
        }

        $data = $dealCalculator->put('primary', $primary)->only([
            'name',
            'mobile_opportunity_id',
            'primary',
        ])->toArray();

        $c = $opportunity->tariffMatch->dealCalculators()->create($data);

        if ($c->primary) {
            $c->update([
                'name' => $c->name . ' (selected)'
            ]);
        }

        collect($dealCalculator['primary_connections'])->each(function ($data) use ($c) {
            $c->primaryConnections()->create($data);
        });

        collect($dealCalculator['secondary_connections'])->each(function ($data) use ($c) {
            $c->secondaryConnections()->create($data);
        });

        collect($dealCalculator['contributions'])->each(function ($data) use ($c) {
            $c->contributions()->create($data);
        });

        collect($dealCalculator['handsets'])->each(function ($data) use ($c) {
            $c->handsets()->create($data);
        });

        collect($dealCalculator['accessories'])->each(function ($data) use ($c) {
            $c->accessories()->create($data);
        });

        collect($dealCalculator['credits'])->each(function ($data) use ($c) {
            $c->credits()->create($data);
        });

        $c->overview()->create($dealCalculator->get('overview'));

        return $c->overview->cashBack >= 0
            ? $c->load([
                'creator',
                'opportunity',
                'accessories',
                'contributions',
                'credits',
                'handsets',
                'connections',
                'primaryConnections',
                'secondaryConnections',
                'overview',
            ])
            : null;
    }

    public function convertDealCalculators($dealCalculatorsCount, $opportunity, $tariffs, $handsets)
    {
        if (!collect([3, 6])->contains($dealCalculatorsCount)) {
            $opportunity->dealCalculators()->delete();

            return $this->getDealCalculators($opportunity, $tariffs, $handsets);
        }

        $dealCalculators = ['With Handsets' => [], 'Without Handsets' => []];

        foreach (request()->get('deal_calculators') as $index => $calc) {
            if (($dealCalculatorsCount == 6 && ($index == 0 || $index == 3)) || ($dealCalculatorsCount == 3 && $index == 0)) {
                $title = 'Least Credits';
                $class = 'text-black';
            } elseif (($dealCalculatorsCount == 6 && ($index == 1 || $index == 4)) || ($dealCalculatorsCount == 3 && $index == 1)) {
                $title = 'Most Popular';
                $class = 'text-success';
            } elseif (($dealCalculatorsCount == 6 && ($index == 2 || $index == 5)) || ($dealCalculatorsCount == 3 && $index == 2)) {
                $title = 'Most Credits';
                $class = 'text-black';
            }

            $dealCalculator = DealCalculator::with([
                'creator',
                'opportunity',
                'accessories',
                'contributions',
                'credits',
                'handsets',
                'handsets.handset',
                'primaryConnections',
                'secondaryConnections',
                'overview',
            ])->find($calc['id']);

            $data = [
                'calc'    => $dealCalculator,
                'title'   => $title,
                'class'   => $dealCalculator->primary ? 'panel-warning' : $class,
                'credits' => $dealCalculator->overview->status
                    ? $dealCalculator->overview->totalProfit
                    : 0,
            ];

            count($dealCalculator->handsets) > 0
                ? array_push($dealCalculators['With Handsets'], $data)
                : array_push($dealCalculators['Without Handsets'], $data);
        }

        return [
            'calcs' => $dealCalculators,
            'total' => null
        ];
    }

    public function getDealCalculators($opportunity, $tariffs, $handsets)
    {
        $total = 0;

        $info = collect([
            [
                'title'    => 'Least Credits',
                'class'    => 'text-black',
                'modifier' => -5,
                'calc'     => null,
                'credits'  => null,
            ],
            [
                'title'    => 'Most Popular',
                'class'    => 'text-success',
                'modifier' => 5,
                'calc'     => null,
                'credits'  => null,
            ],
            [
                'title'    => 'Most Credits',
                'class'    => 'text-black',
                'modifier' => 10,
                'calc'     => null,
                'credits'  => null,
            ]
        ]);

        $dealCalculators = count($handsets) > 0
            ? collect(['With Handsets' => $info, 'Without Handsets' => $info])
            : collect(['Without Handsets' => $info]);

        $calcs = $dealCalculators->map(function ($data, $type) use (
            $opportunity,
            $tariffs,
            $handsets,
            &$total
        ) {
            $exptectedMonthlyCost = $opportunity->tariffMatch->expected_monthly_cost;

            return $data->map(function ($item) use (
                $opportunity,
                $tariffs,
                $handsets,
                $type,
                &$exptectedMonthlyCost,
                &$total
            ) {
                return $this->findBestDeal(
                    $item,
                    $opportunity,
                    $tariffs,
                    $handsets,
                    $type,
                    $exptectedMonthlyCost,
                    $total
                );
            });
        })->toArray();

        return [
            'calcs' => $calcs,
            'total' => $total
        ];
    }

    public function findBestDeal(
        $item,
        $opportunity,
        $tariffs,
        $handsets,
        $type,
        &$exptectedMonthlyCost,
        &$total
    ) {
        $cost    = 0;
        $credits = 0;
        $deal    = null;
        $target  = $exptectedMonthlyCost + $item['modifier'];

        do {
            for ($discount = 49; $discount >= 0; $discount = $discount - 1) {
                for ($discountSecondary = 62; $discountSecondary >= 0; $discountSecondary = $discountSecondary - 1) {
                    $total++;

                    $temporaryDealCalc = (new DealCalculatorHelper(
                        $type . ' - ' . $item['title'],
                        $opportunity,
                        $tariffs,
                        $type == 'With Handsets' ? $handsets : null,
                        $opportunity->tariffMatch->terminationFees,
                        $discount,
                        0,
                        $discountSecondary
                    ))->handle();

                    $cashBack = $temporaryDealCalc['overview']['discountedMonthlyCost'] - $target;

                    if ($cashBack > 0) {
                        $temporaryDealCalc = (new DealCalculatorHelper(
                            $type . ' - ' . $item['title'],
                            $opportunity,
                            $tariffs,
                            $type == 'With Handsets' ? $handsets : null,
                            $opportunity->tariffMatch->terminationFees,
                            $discount,
                            $cashBack,
                            $discountSecondary
                        ))->handle();

                        $total++;
                    }

                    if ($temporaryDealCalc['overview']['status'] == 0 && isset($deal)) {
                        break;
                    }

                    $deal = $temporaryDealCalc;

                    $cost = $deal['overview']['discountedMonthlyCost'];

                    if ($item['title'] == 'Least Credits') {
                        $exptectedMonthlyCost = $cost;
                    }

                    $credits = $deal['overview']['status']
                        ? $deal['overview']['totalProfit']
                        : 0;
                }

                if ($cost <= $target && isset($deal) && $deal['overview']['profitMargin'] >= 30 && $temporaryDealCalc['overview']['status'] == 0) {
                    break;
                }
            }

            $target = $target + ($exptectedMonthlyCost * 0.05);

            if (($exptectedMonthlyCost * 2) < $target) {
                break;
            }
        } while ($deal['overview']['status'] == 0 && $cost <= $target);

        $item['calc'] = $this->storeDealCalculator(
            $opportunity,
            $deal,
            $item['title'] == 'Most Popular' && $credits > 0 && $type == 'Without Handsets'
        );
        $item['credits'] = $credits;

        return $item;
    }
}
