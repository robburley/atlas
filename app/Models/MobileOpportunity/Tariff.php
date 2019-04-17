<?php

namespace App\Models\MobileOpportunity;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $fillable = [
        'tariff_type_id',
        'tariff_code',
        'uk_minutes',
        'uk_texts',
        'eu_minutes',
        'eu_texts',
        'eu_data',
        'uk_to_eu_minutes',
        'price',
        'active',
        'max_discount',
        'uk_data'
    ];

    public function type()
    {
        return $this->belongsTo(TariffType::class, 'tariff_type_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100;
    }

    public function getPriceAttribute($value)
    {
        return $value / 100;
    }

    public function getName()
    {
        $features = $this->getFeatures();

        $features = $features
            ? ' (' . $features . ')'
            : null;

        return e(strtoupper($this->tariff_code) . ' ' . '£' . $this->price . $features);
    }

    public function getFeaturesBase()
    {
        $sharer = $this->type
            ? $this->type->name == 'O2 Business Share' || $this->type->name == 'O2 Shared Data'
            : false;

        return collect([
            $sharer ? 'cross network minutes shared' : 'cross network minutes' => $this->uk_minutes,
            $sharer ? 'cross network texts shared' : 'cross network texts' => $this->uk_texts,
            $sharer ? 'data allowance  shared' : 'data allowance ' => $this->uk_data ? $this->uk_data . 'GB' : '',
        ])
            ->filter();
    }

    public function getFeatures()
    {
        return $this->getFeaturesBase()
            ->map(function ($item, $key) {
                return $item . ' ' . $key;
            })->implode(', ');
    }

    public function getFeaturesWithTags()
    {
        return $this->getFeaturesBase()
            ->map(function ($item, $key) {
                return '<strong>' . $item . '</strong> ' . $key;
            })->implode(', ');
    }

    public function scopeSearchName($query)
    {
        return request()->has('name')
            ? $query->where('tariff_code', 'LIKE', '%' . request()->get('name') . '%')
            : $query;
    }

    public function scopeSearchType($query)
    {
        return request()->has('type') && request()->get('type') > 0
            ? $query->where('tariff_type_id', request()->get('type'))
            : $query;
    }
}
