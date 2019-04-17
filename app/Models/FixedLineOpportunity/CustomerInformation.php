<?php

namespace App\Models\FixedLineOpportunity;


use Illuminate\Database\Eloquent\Model;

class CustomerInformation extends Model
{
    protected $table = 'fixed_line_customer_information';

    protected $fillable = [
        'fixed_line_opportunity_id',
        'company',
        'address_1',
        'address_2',
        'address_3',
        'address_4',
        'postcode',
        'customer_name',
        'position',
        'email',
        'billing_email',
        'office_number',
        'mobile_number',
    ];
}
