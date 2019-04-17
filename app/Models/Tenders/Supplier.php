<?php

namespace App\Models\Tenders;


use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'supplier_type_id',
    ];

    public function type()
    {
        return $this->belongsTo(SupplierType::class, 'supplier_type_id');
    }

    public function contacts()
    {
        return $this->hasMany(SupplierContact::class, 'supplier_id');
    }
}
