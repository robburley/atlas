<?php

namespace App\Models\MobileOpportunity;


use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = [
        'model',
        'manufacturer',
        'size',
        'price',
        'active',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function getNameAttribute()
    {
        return $this->manufacturer . ' ' . $this->model . ' ' . $this->size;
    }

    public function setPriceAttribute($value)
    {
        return $this->attributes['price'] = $value * 100;
    }

    public function getPriceAttribute($value)
    {
        return $value / 100;
    }
}
