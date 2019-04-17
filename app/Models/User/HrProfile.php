<?php

namespace App\Models\User;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class HrProfile extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'date_of_birth',
        'start_date',
    ];

    protected $fillable = [
        'user_id',
        'title',
        'first_name',
        'middle_names',
        'last_name',
        'initial',
        'gender',
        'marital_status',
        'date_of_birth',
        'personal_email',
        'work_email',
        'passport_number',
        'national_insurance',
        'bank_account_number',
        'sort_code',
        'start_date',
        'line_manager',
        'job_title',
        'salary',
        'probation_period',
        'employee_number',
        'hours_of_work',
        'employee_type',
        'address_1',
        'address_2',
        'address_3',
        'address_4',
        'address_5',
        'postcode',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(HrProfileFile::class);
    }

    public function lineManager()
    {
        return $this->belongsTo(User::class, 'line_manager');
    }

    public function getFullNameAttribute()
    {
        if (!$this->first_name && !$this->last_name) {
            return $this->user->name;
        }

        return $this->title . ' ' . $this->first_name . ' ' . $this->last_name;
    }

    public function setSalaryAttribute($value)
    {
        return $this->attributes['salary'] = $value * 100;
    }

    public function getSalaryAttribute($value)
    {
        return $value / 100;
    }

    public function setDateOfBirthAttribute($value)
    {
        try {
            return $this->attributes['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $value);
        } catch (\Exception $e) {

        }
    }

    public function setStartDateAttribute($value)
    {
        try {
            return $this->attributes['start_date'] = Carbon::createFromFormat('d/m/Y', $value);
        } catch (\Exception $e) {

        }
    }

    public function getAddressAttribute()
    {
        return collect([
            $this->address_1,
            $this->address_2,
            $this->address_3,
            $this->address_4,
            $this->address_5,
            $this->postcode,
        ])->filter()->implode(', ');
    }

}
