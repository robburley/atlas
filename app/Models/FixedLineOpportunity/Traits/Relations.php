<?php


namespace App\Models\FixedLineOpportunity\Traits;


use App\Models\Appointments\Appointment;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerFile;
use App\Models\Customer\CustomerFileType;
use App\Models\Customer\CustomerNote;
use App\Models\Customer\ScheduledCallback;
use App\Models\FixedLineOpportunity\FixedLineNetwork;
use App\Models\FixedLineOpportunity\FixedLineOpportunityStatus;
use App\Models\MobileOpportunity\AdobeSignDocument;
use App\Models\MobileOpportunity\MobileNetwork;
use App\Models\MobileOpportunity\MobileOpportunityStatus;
use App\Models\User\User;
use App\Models\User\UserNotification;

trait Relations
{

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function assigned()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->withPivot('active', 'created_at');
    }

    public function activeAssigned()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->wherePivot('active', 1)
            ->withPivot('active', 'created_at');
    }

    public function inactiveAssigned()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->wherePivot('active', 0)
            ->withPivot('active', 'created_at');
    }

    public function status()
    {
        return $this->belongsTo(FixedLineOpportunityStatus::class, 'fixed_line_opportunity_status_id');
    }

    public function networks()
    {
        return $this->belongsToMany(FixedLineNetwork::class);
    }

    public function files()
    {
        return $this->morphMany(CustomerFile::class, 'related');
    }

    public function fixedLineBills()
    {
        return $this->morphMany(CustomerFile::class, 'related')
            ->where('customer_file_type_id', CustomerFileType::where('slug', 'fixed_line_bills')->first()->id ?? 0);
    }


    public function purchaseOrder()
    {
        return $this->morphMany(CustomerFile::class, 'related')
                    ->where('customer_file_type_id', CustomerFileType::where('slug', 'purchase_order')->first()->id);
    }

    public function unsignedPurchaseOrder()
    {
        return $this->morphMany(CustomerFile::class, 'related')
                    ->where('customer_file_type_id', CustomerFileType::where('slug', 'unsigned_purchase_order')->first()->id);
    }

    public function callbacks()
    {
        return $this->morphMany(ScheduledCallback::class, 'opportunity');
    }

    public function lastCallback()
    {
        return $this->morphMany(ScheduledCallback::class, 'opportunity')
            ->orderBy('time', 'desc')
            ->whereNull('completed_at');
    }

    public function incompleteCallbacks()
    {
        return $this->morphMany(ScheduledCallback::class, 'opportunity')
            ->whereNull('completed_at');
    }

    public function customerNotes()
    {
        return $this->morphMany(CustomerNote::class, 'notable');
    }

    public function appointments()
    {
        return $this->morphMany(Appointment::class, 'appointable');
    }

    public function notifications()
    {
        return $this->morphMany(UserNotification::class, 'notable');
    }

    public function adobeSignDocument()
    {
        return $this->morphOne(AdobeSignDocument::class, 'signable');
    }

    public function adobeSignDocumentPurchaseOrder()
    {
        return $this->morphOne(AdobeSignDocument::class, 'signable')
                    ->where('type', 'purchase-order');
    }

}