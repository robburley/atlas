<?php

namespace App\Models\JourneyTeamSurvey;

use App\Models\Customer\Customer;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class JourneyTeamSurvey extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'fixed_line_complete',
        'energy_complete',
        'water_complete',
        'it_complete',
        'vehicle_tracking_complete',
        'mobile_complete',

        'mobile_issues',
        'mobile_issues_details',

        'fixed_line_current_supplier',
        'fixed_line_current_contract_remaining',
        'fixed_line_average_monthly_bill',
        'fixed_line_issues',
        'fixed_line_review',

        'energy_current_supplier',
        'energy_current_contract_remaining',
        'energy_average_monthly_bill',
        'energy_meter_type',
        'energy_issues',
        'energy_review',

        'water_current_supplier',
        'water_current_contract_remaining',
        'water_average_monthly_bill',
        'water_issues',
        'water_review',

        'it_current_supplier',
        'it_current_contract',
        'it_service_level',
        'it_hardware_maintenance_contract_renewal',
        'it_review',

        'vehicle_tracking_current_supplier',
        'vehicle_tracking_current_contract_remaining',
        'vehicle_tracking_average_monthly_bill',
        'vehicle_tracking_review',
        'vehicle_tracking_issues',

        'fixed_line_bill',
        'fixed_line_bill_set',
        'fixed_line_bill_requirements',
        'energy_bill',
        'energy_bill_set',
        'energy_bill_requirements',
        'water_bill',
        'water_bill_set',
        'water_bill_requirements',
        'it_bill',
        'it_bill_set',
        'it_bill_requirements',
        'vehicle_tracking_bill',
        'vehicle_tracking_bill_set',
        'vehicle_tracking_bill_requirements',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sectionsComplete()
    {
        return collect([
            $this->mobile_complete,
            $this->fixed_line_complete,
            $this->energy_complete,
            $this->water_complete,
            $this->it_complete,
            $this->vehicle_tracking_complete,
        ])
            ->filter()
            ->count();
    }

    public function sectionsCount()
    {
        return collect([
            $this->mobile_complete,
            $this->fixed_line_complete,
            $this->energy_complete,
            $this->water_complete,
            $this->it_complete,
            $this->vehicle_tracking_complete,
        ])->count();
    }

    public function setFixedLineBillAttribute($file)
    {
        if ($file instanceof UploadedFile) {
            $file->storeAs('journey-team-surveys/' . $this->id, 'fixed-line-bill.' . $file->extension());

            $this->attributes['fixed_line_bill'] = 'journey-team-surveys/' . $this->id . '/fixed-line-bill.' . $file->extension();

            $this->attributes['fixed_line_bill_requirements'] = false;
        }
    }

    public function setEnergyBillAttribute($file)
    {
        if ($file instanceof UploadedFile) {
            $file->storeAs('journey-team-surveys/' . $this->id, 'energy-bill.' . $file->extension());

            $this->attributes['energy_bill'] = 'journey-team-surveys/' . $this->id . '/energy-bill.' . $file->extension();

            $this->attributes['energy_bill_requirements'] = false;
        }
    }

    public function setWaterBillAttribute($file)
    {
        if ($file instanceof UploadedFile) {
            $file->storeAs('journey-team-surveys/' . $this->id, 'water-bill.' . $file->extension());

            $this->attributes['water_bill'] = 'journey-team-surveys/' . $this->id . '/water-bill.' . $file->extension();

            $this->attributes['water_bill_requirements'] = false;
        }
    }

    public function setItBillAttribute($file)
    {
        if ($file instanceof UploadedFile) {
            $file->storeAs('journey-team-surveys/' . $this->id, 'it-bill.' . $file->extension());

            $this->attributes['it_bill'] = 'journey-team-surveys/' . $this->id . '/it-bill.' . $file->extension();

            $this->attributes['it_bill_requirements'] = false;
        }
    }

    public function setVehicleTrackingBillAttribute($file)
    {
        if ($file instanceof UploadedFile) {
            $file->storeAs('journey-team-surveys/' . $this->id, 'vehicle-tracking-bill.' . $file->extension());

            $this->attributes['vehicle_tracking_bill'] = 'journey-team-surveys/' . $this->id . '/vehicle-tracking-bill.' . $file->extension();

            $this->attributes['vehicle_tracking_bill_requirements'] = false;
        }
    }
}
