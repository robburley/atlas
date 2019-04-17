<?php

namespace App\Helpers\TariffMatch;

class DealCalculatorHelper
{
    protected $name;
    protected $opportunity;
    protected $tariffs;
    protected $devices;
    protected $terminationFee;
    protected $discountPercent;
    protected $discountPercentSecondary;

    protected $primaryConnections   = [];
    protected $secondaryConnections = [];
    protected $contributions        = [];
    protected $handsets             = [];
    protected $accessories          = [];
    protected $credits              = [];
    protected $overview             = [
        'monthsFree'            => 6,
        'lineRental'            => 0,
        'bcad'                  => 0,
        'cashBack'              => 0,
        'monthlyDiscount'       => 0,
        'monthlyLineRental'     => 0,
        'discountMargin'        => 0,
        'discountedMonthlyCost' => 0,
        'income'                => 0,
        'cost'                  => 0,
        'handlingFee'           => 0,
        'totalProfit'           => 0,
        'profitMargin'          => 0,
        'status'                => 0,
    ];

    protected $primaryConnectionTotal   = ['total' => 0, 'commission' => 0];
    protected $secondaryConnectionTotal = ['total' => 0, 'commission' => 0];
    protected $contributionsTotal       = ['total' => 0, 'commission' => 0];
    protected $handsetsTotal            = ['total' => 0, 'commission' => 0];
    protected $accessoriesTotal         = ['total' => 0, 'commission' => 0];
    protected $creditsTotal             = ['total' => 0, 'commission' => 0];

    public function __construct(
        $name,
        $opportunity,
        $tariffs,
        $handsets,
        $terminationFee,
        $discountPercent = 0,
        $cashback = 0,
        $discountPercentSecondary = 0
    ) {
        $this->name                     = $name;
        $this->opportunity              = $opportunity;
        $this->tariffs                  = $tariffs;
        $this->devices                  = $handsets;
        $this->terminationFee           = $terminationFee;
        $this->discountPercent          = $discountPercent;
        $this->discountPercentSecondary = $discountPercentSecondary;
        $this->cashback                 = $cashback;

        $this->setConnections();
        $this->setHandsets();
        $this->setContributions();
        $this->setAccessories();
        $this->setCredits();
        $this->calculate();
    }

    public function setCredits()
    {
        $this->credits = [
            [
                'name'  => 'Line Rental Cashback',
                'value' => round($this->cashback, 2),
                'units' => 12,
                'total' => round(round($this->cashback, 2) * 12, 2),
            ],
            [
                'name'  => 'Hardware Fund',
                'value' => 0,
                'units' => 0,
                'total' => 0,
            ],
            [
                'name'  => 'Buyout',
                'value' => $this->terminationFee->sum('fee'),
                'units' => 1,
                'total' => $this->terminationFee->sum('fee'),
            ],
        ];
    }

    public function setAccessories()
    {
        $secondaries = $this->tariffs->get('secondary')->count();

        $sims = $secondaries + 1;

        $this->accessories = [
            [
                'name'  => 'O2 SIM Card',
                'value' => 10,
                'units' => $sims,
                'total' => $sims * 10,
            ],
            [
                'name'  => 'Delivery',
                'value' => 20,
                'units' => 1,
                'total' => 20,
            ],
        ];

        $totalHandsets = collect($this->handsets)->sum('units');

        $remaining = $sims - $totalHandsets;

        if ($remaining > 0) {
            array_push($this->accessories, [
                'name'  => 'Unlock Fee',
                'value' => 80,
                'units' => $remaining,
                'total' => $remaining * 80,
            ]);
        }
    }

    public function setContributions()
    {
        $this->contributions = [
            [
                'name'  => 'Customer Contribution',
                'value' => 0,
                'units' => 0,
                'total' => 0,
            ],
            [
                'name'  => 'Termination Credit',
                'value' => 0,
                'units' => 0,
                'total' => 0,
            ],
        ];
    }

    public function setHandsets()
    {
        if ($this->devices) {
            $this->devices->each(function ($device, $index) {
                if ($device) {
                    $data = [
                        'name'        => "$device->model $device->manufacturer $device->size",
                        'value'       => $device->price,
                        'units'       => 1,
                        'total'       => $device->price,
                        'handset_id'  => $device->id,
                    ];

                    array_push($this->handsets, $data);
                }
            });
        }
    }

    public function setConnections()
    {
        $this->tariffs->each(function ($type) {
            $type->each(function ($tariff) {
                if ($tariff) {
                    $primary = $tariff->tariff_type_id == 1;

                    $calculatedTerm = $primary
                        ? 30
                        : 36;

                    $modifier = 0.5;
                    $discount = $tariff->tariff_code != 'Secondary'
                        ? $this->discountPercent
                        : $this->discountPercentSecondary;

                    if ($discount >= $tariff->max_discount) {
                        $discount = $tariff->max_discount;
                    }

                    $cost = round($tariff->price * ((100 - $discount) / 100), 2);
                    $gp = round((($calculatedTerm * $cost) * $modifier), 2);

                    $data = [
                        'tariff_id'   => $tariff->id,
                        'term'        => 36,
                        'connections' => 1,
                        'cost'        => $cost,
                        'gp'          => $gp,
                        'commission'  => $gp,
                        'total'       => $cost,
                        'modifier'    => 0.5,
                        'type'        => 1,
                        'primary'     => $tariff->tariff_type_id == 1,
                        'discount'    => $discount,
                        'maxDiscount' => $tariff->max_discount,
                        'baseCost'    => $tariff->price,
                    ];

                    $primary
                        ? array_push($this->primaryConnections, $data)
                        : array_push($this->secondaryConnections, $data);
                }
            });
        });
    }

    public function calculate()
    {
        $this->calculateTotals();
        $this->calculateOverview();
    }

    public function calculateOverview()
    {
        $this->overview['lineRental'] = round(
            floatval($this->primaryConnectionTotal['total']) + floatval($this->secondaryConnectionTotal['total']),
            2
        );

        $this->overview['bcad'] = round(
            floatval($this->primaryConnectionTotal['total']) * floatval($this->overview['monthsFree']),
            2
        );

        $this->overview['cashBack'] = round(
            $this->credits[0]['total'],
            2
        );

        $this->overview['monthlyDiscount'] = round(
            ($this->overview['bcad'] + $this->overview['cashBack']) / 12,
            2
        );

        $this->overview['monthlyLineRental'] = round(
            $this->overview['lineRental'] - $this->overview['monthlyDiscount'],
            2
        );

        $this->overview['discountMargin'] = $this->overview['lineRental'] > 0
            ? round((($this->overview['monthlyDiscount'] / $this->overview['lineRental']) * 100), 2)
            : 0;
        $this->overview['discountedMonthlyCost'] = round(
            (($this->overview['lineRental'] * 12) - ($this->overview['bcad'] + $this->overview['cashBack'])) / 12,
            2
        );

        $this->overview['income'] = round(
            $this->primaryConnectionTotal['commission'] + $this->secondaryConnectionTotal['commission'] + $this->contributionsTotal['total'],
            2
        );

        $this->overview['cost'] = round(
            $this->handsetsTotal['total'] + $this->accessoriesTotal['total'] + $this->creditsTotal['total'],
            2
        );

        $this->overview['handlingFee'] = round(
            ($this->overview['income'] - $this->overview['cost']) * 0.15,
            2
        );

        $this->overview['totalProfit'] = round(
            $this->overview['income'] - $this->overview['cost'] - $this->overview['handlingFee'],
            2
        );

        $this->overview['profitMargin'] = $this->overview['income'] > 0
            ? round(($this->overview['totalProfit'] / $this->overview['income']) * 100, 2)
            : 0;

        $this->overview['status'] = $this->overview['profitMargin'] >= 30 && $this->overview['discountMargin'] <= 70;
    }

    public function calculateTotals()
    {
        $this->primaryConnectionTotal['total']        = collect($this->primaryConnections)->sum('total');
        $this->primaryConnectionTotal['commission']   = collect($this->primaryConnections)->sum('commission');
        $this->secondaryConnectionTotal['total']      = collect($this->secondaryConnections)->sum('total');
        $this->secondaryConnectionTotal['commission'] = collect($this->secondaryConnections)->sum('commission');

        $this->contributionsTotal['total']      = collect($this->contributions)->sum('total');
        $this->contributionsTotal['commission'] = collect($this->contributions)->sum('commission');

        $this->handsetsTotal['total']      = collect($this->handsets)->sum('total');
        $this->handsetsTotal['commission'] = collect($this->handsets)->sum('commission');

        $this->accessoriesTotal['total']      = collect($this->accessories)->sum('total');
        $this->accessoriesTotal['commission'] = collect($this->accessories)->sum('commission');

        $this->creditsTotal['total']      = collect($this->credits)->sum('total');
        $this->creditsTotal['commission'] = collect($this->credits)->sum('commission');
    }

    public function handle()
    {
        return collect([
            'name'                  => $this->name,
            'mobile_opportunity_id' => $this->opportunity->id,
            'primary_connections'   => $this->primaryConnections,
            'secondary_connections' => $this->secondaryConnections,
            'contributions'         => $this->contributions,
            'handsets'              => $this->handsets,
            'accessories'           => $this->accessories,
            'credits'               => $this->credits,
            'overview'              => $this->overview,
        ]);
    }
}
