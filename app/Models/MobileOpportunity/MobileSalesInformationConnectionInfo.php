<?php

namespace App\Models\MobileOpportunity;

use Illuminate\Database\Eloquent\Model;

class MobileSalesInformationConnectionInfo extends Model
{
    protected $fillable = [
        'mobile_sales_information_id',
        'number',
        'type',
        'network',
    ];

    protected $table = 'mobile_sales_information_connection_info';

    public function salesInformation()
    {
        return $this->belongsTo(MobileSalesInformation::class);
    }
}
