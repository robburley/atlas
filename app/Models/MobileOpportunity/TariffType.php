<?php

namespace App\Models\MobileOpportunity;

use Illuminate\Database\Eloquent\Model;

class TariffType extends Model
{
    public function tariffs()
    {
        return $this->hasMany(Tariff::class, 'tariff_type_id')
            ->orderBy('tariff_code', 'asc')
            ->orderBy('price', 'asc');
    }

    public function activeTariffs()
    {
        return $this->hasMany(Tariff::class, 'tariff_type_id')
            ->where('active', 1)
            ->orderBy('tariff_code', 'asc')
            ->orderBy('price', 'asc');
    }
}
