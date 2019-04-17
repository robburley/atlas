<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'forename',
        'surname',
        'job_title',
        'description',
        'landline_number',
        'mobile_number',
        'email_address',
        'address_line1',
        'address_line2',
        'address_line3',
        'address_city',
        'address_county',
        'address_postcode',
        'decision_maker',
        'finance_contact',
        'technical_contact',
        'site_id',
    ];

    public function site()
    {
        return $this->belongsTo(CustomerSite::class, 'site_id');
    }

    public function getFullNameAttribute()
    {
        return ucwords($this->forename . ' ' . $this->surname);
    }

    public function getFullNameEmailAttribute()
    {
        return ucwords($this->forename . ' ' . $this->surname) . ' (' . ($this->email_address ? $this->email_address : 'NO EMAIL SET') . ')';
    }
}
