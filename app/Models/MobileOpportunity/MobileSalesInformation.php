<?php

namespace App\Models\MobileOpportunity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MobileSalesInformation extends Model
{
    protected $table = 'mobile_sales_information';

    protected $fillable = [
        'mobile_opportunity_id',
        'account_holder',
        'date_of_birth',
        'business_name',
        'landline_number',
        'email',
        'mobile_number',
        'business_established_date',
        'network_porting_from',
        'current_network_account_number',
        'special_requirements',
        'connection_information',
        'address_1_line_1',
        'address_1_line_2',
        'address_1_line_3',
        'address_1_line_4',
        'address_1_line_5',
        'address_1_postcode',
        'address_1_time_at_address',
        'address_2_line_1',
        'address_2_line_2',
        'address_2_line_3',
        'address_2_line_4',
        'address_2_line_5',
        'address_2_postcode',
        'address_2_time_at_address',
        'address_3_line_1',
        'address_3_line_2',
        'address_3_line_3',
        'address_3_line_4',
        'address_3_line_5',
        'address_3_postcode',
        'business_type',
        'password',
        'last_bill_date',
        'last_bill_amount',
        'account_holder_title',
        'account_holder_last_name',
        'company_number',
    ];

    protected $dates = ['created_at', 'updated_at', 'date_of_birth', 'business_established_date',];

    protected $touches = ['opportunity'];

    public function opportunity()
    {
        return $this->belongsTo(MobileOpportunity::class, 'mobile_opportunity_id');
    }

    public function connectionInfo()
    {
        return $this->hasMany(MobileSalesInformationConnectionInfo::class);
    }

    public function setDateOfBirthAttribute($value)
    {
        try {
            $this->attributes['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $value);
        } catch (\Exception $e) {
        }
    }

    public function setBusinessEstablishedDateAttribute($value)
    {
        try {
            $this->attributes['business_established_date'] = Carbon::createFromFormat('m/Y', $value);
        } catch (\Exception $e) {
        }
    }

    public function setConnectionInformationAttribute($values)
    {
        if ($this->exists) {
            foreach ($values['number'] as $key => $row) {
                $this->connectionInfo()->create([
                    'number'  => $values['number'][$key] ?? '',
                    'type'    => $values['type'][$key] ?? '',
                    'network' => $values['network'][$key] ?? '',
                ]);
            }
        } else {
            static::created(function ($related) use ($values) {
                foreach ($values['number'] as $key => $row) {
                    $related->connectionInfo()->create([
                        'number'  => $values['number'][$key] ?? '',
                        'type'    => $values['type'][$key] ?? '',
                        'network' => $values['network'][$key] ?? '',
                    ]);
                }
            });
        }
    }

    public function getAddressAttribute()
    {
        return collect([
            $this->address_1_line_1,
            $this->address_1_line_2,
            $this->address_1_line_3,
            $this->address_1_line_4,
            $this->address_1_postcode,
        ])->filter()->implode(', ');
    }

    public function getDeliveryAddressAttribute()
    {
        return collect([
            $this->address_3_line_1,
            $this->address_3_line_2,
            $this->address_3_line_3,
            $this->address_3_line_4,
            $this->address_3_postcode,
        ])->filter()->implode(', <br>');
    }

    public function getAccountHolderFullNameAttribute()
    {
        return collect([
            $this->account_holder_title,
            $this->account_holder,
            $this->account_holder_last_name,
        ])->implode(' ');
    }
}
