<?php

namespace App\Models\Tenders;


use Illuminate\Database\Eloquent\Model;

class SupplierContact extends Model
{
    protected $fillable = [
        'email',
        'supplier_id',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
