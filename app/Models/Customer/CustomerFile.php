<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerFile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'related_id',
        'related_type',
        'customer_id',
        'customer_file_type_id',
        'location',
    ];

    protected $touches = ['customer'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function type()
    {
        return $this->belongsTo(CustomerFileType::class, 'customer_file_type_id');
    }

    public function related()
    {
        return $this->morphTo();
    }
}
