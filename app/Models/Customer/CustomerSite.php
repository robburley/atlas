<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerSite extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'name',
        'address1',
        'address2',
        'address3',
        'town',
        'county',
        'postcode',
        'head_office',
    ];

    protected $touches = ['customer'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function getAddressAttribute()
    {
        return collect([$this->name,
            $this->address1,
            $this->address2,
            $this->address3,
            $this->town,
            $this->county,
            $this->postcode])->filter()->implode(', ');
    }
}
