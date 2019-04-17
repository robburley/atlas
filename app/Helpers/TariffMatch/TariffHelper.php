<?php

namespace App\Helpers\TariffMatch;


use App\Models\MobileOpportunity\Tariff;
use Illuminate\Support\Collection;

class TariffHelper
{
    public $minutes;
    public $data;
    public $secondaries;

    public function __construct($minutes, $data, $singleData, $secondaries)
    {
        $this->minutes = $minutes;
        $this->data = $data;
        $this->secondaries = $secondaries;
        $this->singleData = $singleData;
    }

    public function handle()
    {
        $tariffs = collect([
            'primary'   => $this->getPrimary(),
            'secondary' => $this->getSecondary(),
            'data'      => $this->getData()
        ]);

        return $tariffs;
    }

    public function getPrimary()
    {
        $tariffIds = new Collection();

        $tariff = Tariff::where('tariff_type_id', 1)
                        ->where('uk_minutes', '=', $this->minutes)
                        ->whereNotNull('uk_minutes')
                        ->where('active', 1)
                        ->first();

        $tariffIds->push($tariff);

        return $tariffIds;
    }

    public function getSecondary()
    {
        $tariffIds = new Collection();

        $remainingSecondaries = $this->secondaries;

        while ($remainingSecondaries > 0) {

            $tariff = Tariff::where('tariff_type_id', 1)
                            ->where('tariff_code', 'Secondary')
                            ->where('active', 1)
                            ->first();

            $tariffIds->push($tariff);

            $remainingSecondaries--;
        }

        return $tariffIds;
    }

    public function getData()
    {
        $shared = $this->getSharedData();

        $single = $this->getSingleData();

        return $shared['price'] < $single['price'] || $single['data'] < $this->data
            ? $shared['tariffs']
            : $single['tariffs'];
    }

    public function getSingleData()
    {
        $tariffIds = new Collection();
        $cost = 0;
        $dataGb = 0;

        $orderByDesc = "CAST(uk_data AS DECIMAL(10,0)) DESC";

        foreach ($this->singleData as $data) {
            $tariff = Tariff::where('tariff_type_id', 4)
                            ->where('uk_data', '<=', $data)
                            ->whereNotNull('uk_data')
                            ->where('active', 1)
                            ->orderByRaw($orderByDesc)
                            ->first();

            if ($tariff) {
                $tariffIds->push($tariff);

                $cost = $cost + $tariff->price;
                $dataGb = $dataGb + $tariff->uk_data;

//                $remainingData = $data - $tariff->uk_data;
//
//                while ($remainingData > 0) {
//                    $tariff = Tariff::where('tariff_type_id', 7)
//                                    ->where('uk_data', '<=', $remainingData)
//                                    ->whereNotNull('uk_data')
//                                    ->where('active', 1)
//                                    ->orderByRaw($orderByDesc)
//                                    ->first();
//
//                    if(!$tariff) {
//                        $tariff = Tariff::where('tariff_code', '1GB')->first();
//                    }
//
//                    $tariffIds->push($tariff);
//
//                    $cost = $cost + $tariff->price;
//                    $dataGb = $dataGb + $tariff->uk_data;
//                    $remainingData = $remainingData - $tariff->uk_data;
//                }
            }
        }

        return [
            'tariffs' => $tariffIds,
            'price'   => $cost,
            'data'    => $dataGb,
        ];
    }

    public function getSharedData()
    {
        $tariffIds = new Collection();

        $cost = 0;
        $data = 0;

        $remainingData = $this->data;

        $orderByDesc = "CAST(uk_data AS DECIMAL(10,0)) DESC";
        $orderByAsc = "CAST(uk_data AS DECIMAL(10,0))";

        $defaultTariff = Tariff::where('tariff_type_id', 3)
                               ->whereNotNull('uk_data')
                               ->where('active', 1)
                               ->orderByRaw($orderByAsc)
                               ->first();

        while ($remainingData > 0) {
            $tariff = Tariff::where('tariff_type_id', 3)
                            ->where('uk_data', '<=', $remainingData)
                            ->whereNotNull('uk_data')
                            ->where('active', 1)
                            ->orderByRaw($orderByDesc)
                            ->first();

            $tariff = $tariff ?: $defaultTariff;

            $tariffIds->push($tariff);

            $cost = $cost + $tariff->price;
            $data = $data + $tariff->uk_data;
            $remainingData = $remainingData - $tariff->uk_data;
        }

        return [
            'tariffs' => $tariffIds,
            'price'   => $cost,
            'data'    => $data,
        ];
    }
}