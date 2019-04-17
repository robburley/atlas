<?php

namespace App\Models\MobileOpportunity;

use App\Events\CreditCheckPassed;
use App\Helpers\MobileOpportunityStatusHelper;
use App\Helpers\MobileOpportunityStatusUpdate;
use App\Mail\MobileOpportunityQualified;
use App\Models\Admin\CashFlowItem;
use App\Models\Appointments\Appointment;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerFile;
use App\Models\Customer\CustomerFileType;
use App\Models\Customer\CustomerNote;
use App\Models\Customer\ScheduledCallback;
use App\Models\Customer\WelcomeCall;
use App\Models\MobileOpportunity\DealCalculator\DealCalculator;
use App\Models\MobileOpportunity\TariffMatch\TariffMatch;
use App\Models\MobileOpportunity\Traits\MobileOpportunityStatusConditions;
use App\Models\Opportunity;
use App\Models\User\Office;
use App\Models\User\User;
use App\Models\User\UserNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MobileOpportunity\SalesSheetController;

class MobileOpportunity extends Opportunity
{
    use MobileOpportunityStatusConditions;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'status_updated_at',
        'review_date',
        'qualified_at',
        'validated_at',
        'dealt_at',
        'credit_checked_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'voice_users',
        'data_users',
        'monthly_spend',
        'contract_end_date',
        'contract_end_date_confirmed',
        'notes',
        'current_allowances',
        'current_hardware',
        'requirements',
        'mobile_opportunity_status_id',
        'user_id',
        'valid',
        'qualified',
        'not_qualified_reason',
        'accepted',
        'credit_check',
        'credit_check_failed_reason',
        'recovered',
        'direct_dealer',
        'decide_30_days',
        'take_new_number',
        'roaming_international',
        'new_hardware',
        'new_callback',
        'qualified_at',
        'gp',
        'review_date',
        'reviewed_by',
        'no_bill',
        'no_bill_date',
        'appointment',
        'appointment_info',
        'validated_at',
        'hot_transfer',
        'blown_reason',
        'other_services',
        'mass_assigned',
        'accepted_proposal',
        'dealt_at',
        'allocated',
        'bond_amount',
        'bg_ref',
        'ep_ref',
        'bond_type',
        'bcad_reference',
        'credit_check_escalated',
        'credit_check_failed',
        'credit_check_passed',
        'credit_checked_at',
        'bond_payment_reference',
        'order_canceled',
        'fulfilment_saved_deal',
        'validated_by',
        'bcad_required'
    ];

    /**
     * Get the customer for the mobile opportunity.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the user that created the customer.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function qualifier()
    {
        return $this->belongsTo(User::class, 'qualified_by');
    }

    /**
     * Get the user that created the customer.
     */
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

    /**
     * Get the user that the customer is assigned to.
     */
    public function activeAssigned()
    {
        return $this->belongsToMany(User::class)
                    ->withTimestamps()
                    ->wherePivot('active', 1)
                    ->withPivot('active', 'created_at');
    }

    /**
     * Get the user that the customer is assigned to.
     */
    public function inactiveAssigned()
    {
        return $this->belongsToMany(User::class)
                    ->withTimestamps()
                    ->wherePivot('active', 0)
                    ->withPivot('active', 'created_at');
    }

    /**
     * Get the user that the customer is assigned to.
     */
    public function reassignable()
    {
        return $this->belongsToMany(User::class)
                    ->withTimestamps()
                    ->wherePivot('active', 1)
                    ->wherePivot('created_at', '<=', Carbon::now()->startOfDay()->subDays(3))
                    ->withPivot('active', 'created_at');
    }

    /**
     * Get the status of the mobile opportunity.
     */
    public function status()
    {
        return $this->belongsTo(MobileOpportunityStatus::class, 'mobile_opportunity_status_id');
    }

    /**
     * Get the mobile networks that are, or were, related to the opportunity.
     */
    public function networks()
    {
        return $this->belongsToMany(MobileNetwork::class)
                    ->withPivot('open_to')
                    ->wherePivot('open_to', 0);
    }

    /**
     * Get the mobile networks that are, or were, related to the opportunity.
     */
    public function openToNetworks()
    {
        return $this->belongsToMany(MobileNetwork::class)
                    ->withPivot('open_to')
                    ->wherePivot('open_to', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files()
    {
        return $this->morphMany(CustomerFile::class, 'related');
    }

    public function mobileBills()
    {
        return $this->morphMany(CustomerFile::class, 'related')
                    ->where('customer_file_type_id', CustomerFileType::where('slug', 'mobile_bills')->first()->id);
    }

    public function dealCalculator()
    {
        return $this->morphMany(CustomerFile::class, 'related')
                    ->where('customer_file_type_id', CustomerFileType::where('slug', 'deal_calculator')->first()->id);
    }

    public function proposal()
    {
        return $this->morphMany(CustomerFile::class, 'related')
                    ->where('customer_file_type_id', CustomerFileType::where('slug', 'proposal')->first()->id);
    }

    public function letterhead()
    {
        return $this->morphMany(CustomerFile::class, 'related')
                    ->where('customer_file_type_id', CustomerFileType::where('slug', 'letterhead')->first()->id);
    }

    public function purchaseOrder()
    {
        return $this->morphMany(CustomerFile::class, 'related')
                    ->where('customer_file_type_id', CustomerFileType::where('slug', 'purchase_order')->first()->id);
    }

    public function unsignedCif()
    {
        return $this->morphMany(CustomerFile::class, 'related')
                ->where('customer_file_type_id', 20);
    }

    public function unsignedCifNonEsign()
    {
        return $this->morphMany(CustomerFile::class, 'related')
                    ->where('customer_file_type_id', 24);
    }

    public function unsignedPurchaseOrder()
    {
        return $this->morphMany(CustomerFile::class, 'related')
                    ->where(
                        'customer_file_type_id',
                        CustomerFileType::where('slug', 'unsigned_purchase_order')->first()->id
                    );
    }

    public function salesSheet()
    {
        return $this->morphMany(CustomerFile::class, 'related')
                    ->where('customer_file_type_id', CustomerFileType::where('slug', 'sales_sheet')->first()->id);
    }

    public function unsignedBondAgreement()
    {
        return $this->morphMany(CustomerFile::class, 'related')
                    ->where(
                        'customer_file_type_id',
                        CustomerFileType::where('slug', 'unsigned_bond_agreement')->first()->id
                    );
    }

    public function bondAgreement()
    {
        return $this->morphMany(CustomerFile::class, 'related')
                    ->where('customer_file_type_id', CustomerFileType::where('slug', 'bond_agreement')->first()->id);
    }

    public function callbacks()
    {
        return $this->morphMany(ScheduledCallback::class, 'opportunity');
    }

    public function welcomeCall()
    {
        return $this->morphOne(WelcomeCall::class, 'opportunity');
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

    public function activeCustomerNotes()
    {
        return $this->morphMany(CustomerNote::class, 'notable')
                    ->where('active', 1);
    }

    public function salesInformation()
    {
        return $this->hasOne(MobileSalesInformation::class);
    }

    public function appointments()
    {
        return $this->morphMany(Appointment::class, 'appointable');
    }

    public function notifications()
    {
        return $this->morphMany(UserNotification::class, 'notable');
    }

    public function checkForUpdates()
    {
        $data = collect((new MobileOpportunityStatusUpdate($this))->getStatus());

        $otherData = $data->except('mobile_opportunity_status_id');

        $key = $data->get('mobile_opportunity_status_id');

        if ($data->isNotEmpty() && $key != $this->mobile_opportunity_status_id) {
            $this->update($data->toArray());

            $newStatus = MobileOpportunityStatus::find($key);

            alert()->success('Status is now ' . $newStatus->name, 'Status Updated');
        } elseif ($otherData->count() > 0) {
            $this->update($otherData);
        }
    }

    public function getStatusText($status, $name)
    {
        switch ($this) {
            case $this->status->id > $status:
                return '<p><s>' . $name . '</s></p>';
            case $this->status->id == $status:
                return '<p class="text-' . $this->status->colour . '">' . $this->status->name . '</p>';
            default:
                return '<p>' . $name . '</p>';
        }
    }

    public function scopeViewPermissions($query)
    {
        if (auth()->user()->isAdmin()) {
            return $query;
        }

        if (auth()->user()->hasAnyPermission(['show_all_branch_opportunities_mobile'])) {
            return $query->where(function ($qry) {
                $qry->whereHas('creator', function ($q) {
                    return $q->where('office_id', auth()->user()->office_id);
                });
            });
        }

        if (auth()->user()->hasAnyPermission(['show_all_leads_mobile', 'show_all_appointment_leads_mobile'])) {
            return $query->where(function ($q) {
                if (auth()->user()->hasPermission('show_all_leads_mobile')) {
                    $q->orWhere('appointment', 0);
                }

                if (auth()->user()->hasPermission('show_all_appointment_leads_mobile')) {
                    $q->orWhere('appointment', 1);
                }
            });
        }

        return $query->whereHas('activeAssigned', function ($qry) {
            $qry->where('users.id', auth()->user()->id);
        })->orWhere('created_by', auth()->user()->id);
    }

    public function setMobileOpportunityStatusIdAttribute($value)
    {
        $this->attributes['mobile_opportunity_status_id'] = $value;
        $this->attributes['status_updated_at']            = Carbon::now();

        $status = MobileOpportunityStatus::find($value);

        if ($this->exists) {
            $this->customer->notes()->create([
                'customer_note_type_id' => 5,
                'body'                  => 'Mobile Opportunity ID:' . $this->id . ' has been updated to ' . $status->name,
                'notable_type'          => 'mobileOpportunity',
                'notable_id'            => $this->id,
            ]);
        } else {
            static::created(function ($related) use ($status) {
                $related->customer->notes()->create([
                    'customer_note_type_id' => 5,
                    'body'                  => 'Mobile Opportunity ID:' . $related->id . ' has been updated to ' . $status->name,
                    'notable_type'          => 'mobileOpportunity',
                    'notable_id'            => $related->id,
                ]);
            });
        }
    }

    public function setUserIdAttribute($id)
    {
        if ($id > 0) {
            if ($this->exists) {
                $this->assigned->each(function ($user) {
                    $user->pivot->active = 0;

                    $user->pivot->save();
                });

                $this->assigned()->attach($id);

                $this->incompleteCallbacks->each(function ($callback) use ($id) {
                    $callback->update([
                        'user_id' => $id
                    ]);
                });

                return $this->checkForUpdates();
            } else {
                static::created(function ($opportunity) use ($id) {
                    $opportunity->setUserIdAttribute($id);
                });
            }
        }
    }

    public function setQualifiedAttribute($value)
    {
        $this->attributes['qualified'] = $value;

        $this->attributes['qualified_at'] = Carbon::now();

        $this->attributes['qualified_by'] = auth()->user()->id ?? null;

        if ($this->appointment) {
            $appointment = $this->appointments()->first();

            $appointment && $appointment->update(['attended' => 1]);
        }

        try {
            if ($value == 1) {
                Mail::to($this->creator)
                    ->queue(new MobileOpportunityQualified($this));
            }
        } catch (\Exception $e) {
        }
    }

    public function setValidAttribute($value)
    {
        $this->attributes['valid'] = $value;

        $this->attributes['validated_at'] = Carbon::now();

        $this->attributes['validated_by'] = auth()->user()->id;
    }

    public function recoverProcess($user)
    {
        $this->deleteFilesExceptBill();

        $this->adobeSignDocumentPurchaseOrder()->delete();

        $this->dealCalculators->each(function ($calc) {
            $calc->deactivate();
        });

        $this->update([
            'mobile_opportunity_status_id' => (new MobileOpportunityStatusHelper)->get('awaiting-closer-contact'),
            'credit_check'                 => 0,
            'accepted'                     => null,
            'valid'                        => null,
            'qualified'                    => null,
            'user_id'                      => $user,
            'review_date'                  => null,
            'allocated'                    => 0,
        ]);
    }

    public function scopeToday($query)
    {
        $query->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()]);
    }

    public function scopeQualifiedToday($query)
    {
        $query->where('qualified', 1)
              ->whereBetween('qualified_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()]);
    }

    public function scopeNotQualifiedToday($query)
    {
        $query->where('qualified', 0)
              ->whereBetween('qualified_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()]);
    }

    public function scopeValidToday($query)
    {
        $query->where('valid', 1)
                  ->whereBetween('validated_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()]);
    }

    public function scopeValidatedBetween($query, $start, $end)
    {
        try {
            $start = $start instanceof Carbon
                ? $start
                : Carbon::createFromFormat('d/m/Y', $start)->startOfDay();

            $end = $end instanceof Carbon
                ? $end
                : Carbon::createFromFormat('d/m/Y', $end)->endOfDay();
        } catch (\Exception $exception) {
            return $query;
        }

        $query->where('valid', 1)
            ->whereBetween('validated_at', [$start, $end]);
    }

    public function scopeNotValidToday($query)
    {
        $query->where('valid', 0)
              ->whereBetween('validated_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()]);
    }

    public function scopeCreatedByMe($query)
    {
        $query->where('created_by', auth()->user()->id);
    }

    public function scopeValidatedOrQualfiedBetween($query, $start, $end)
    {
        if ($start && $end) {
            return $query->where(function ($q) use ($start, $end) {
                $q->whereBetween('validated_at', [$start, $end])
                  ->orWhereBetween('qualified_at', [$start, $end]);
            });
        }
    }

    public function scopeFilters($query)
    {
        $query->assigned(request()->get('assigned'));

        $query->creatorOffice(request()->get('office'));

        $query->assignedOffice(request()->get('assigned_office'));

        $query->statusIds(request()->get('mobile_opportunity_status_id'));

        $query->createdBetween(request()->get('created_from'), request()->get('created_to'));

        $query->dealtBetweenString(request()->get('dealt_from'), request()->get('dealt_to'));

        $query->filterAppointmentDate(request()->get('appointment_from'), request()->get('appointment_to'));

        request()->has('network') && $query->whereHas('networks', function ($qry) {
            return $qry->where('mobile_networks.id', request()->get('network'));
        });

        request()->has('created') && $query->where('created_by', request()->get('created'));

        request()->has('appointment') && $query->where('appointment', request()->get('appointment'));

        request()->has('no_bill') && $query->where('no_bill', request()->get('no_bill'));

        request()->has('blown') && $query->whereHas('status', function ($qry) {
            return $qry->where('blown', 1);
        });

        request()->has('connected') && $query->whereHas('allocations', function ($qry) {
            return $qry->whereNotNull('connected');
        })->whereDoesntHave('allocations', function ($qry) {
            return $qry->whereNull('connected');
        });

        request()->has('partially_connected') && $query->whereHas('allocations', function ($qry) {
            return $qry->whereNotNull('connected');
        });

        return $query;
    }

    public function scopeDealtBetweenString($query, $start, $end)
    {
        try {
            $start = Carbon::createFromFormat('d/m/Y', $start)->startOfDay();
            $end   = Carbon::createFromFormat('d/m/Y', $end)->endOfDay();
        } catch (\Exception $exception) {
            return $query;
        }

        return $query->dealtBetween([$start, $end]);
    }

    public function scopeCreatedBetween($query, $start, $end)
    {
        try {
            $start = Carbon::createFromFormat('d/m/Y', $start)->startOfDay();
            $end   = Carbon::createFromFormat('d/m/Y', $end)->endOfDay();
        } catch (\Exception $exception) {
            return $query;
        }

        return $query->whereBetween('created_at', [$start, $end]);
    }

    public function scopeFilterAppointmentDate($query, $start, $end)
    {
        try {
            $start = Carbon::createFromFormat('d/m/Y', $start)->startOfDay();
            $end   = Carbon::createFromFormat('d/m/Y', $end)->endOfDay();
        } catch (\Exception $exception) {
            return $query;
        }

        return $query->whereHas('appointments', function ($qry) use ($start, $end) {
            $qry->whereBetween('appointments.time', [$start, $end]);
        });
    }

    public function scopeQualifiedBetween($query, $dates)
    {
        return $query->whereBetween('qualified_at', $dates);
    }

    public function scopeCreatedBy($query, $leadGenerator)
    {
        if (!empty($leadGenerator)) {
            $query->where('created_by', $leadGenerator);
        }
    }

    public function scopeStatus($query, $names)
    {
        $statuses = MobileOpportunityStatus::whereIn('name', $names)->pluck('id') ?? null;

        $statuses && $query->whereIn('mobile_opportunity_status_id', $statuses);
    }

    public function scopeStatusId($query, $id)
    {
        if ($id) {
            return $query->where('mobile_opportunity_status_id', $id);
        }

        return $query;
    }

    public function scopeStatusIds($query, $ids)
    {
        if (!empty($ids)) {
            return $query->whereIn('mobile_opportunity_status_id', $ids);
        }

        return $query;
    }

    public function scopeQualified($query)
    {
        $query->where('qualified', 1);
    }

    public function scopeNotQualified($query)
    {
        $query->where(function ($qry) {
            $qry->where('qualified', 0)
                ->orWhereHas('status', function ($q) {
                    $q->where('mobile_opportunity_statuses.name', 'Not Qualified');
                });
        });
    }

    public function scopeBlown($query)
    {
        $query->whereHas('status', function ($q) {
            $q->where('blown', 1);
        });
    }

    public function scopeNotBlown($query)
    {
        $query->whereHas('status', function ($q) {
            $q->where('blown', 0);
        });
    }

    public function scopeDateRange($query, $start, $end)
    {
        $start && $end && $query->whereBetween('mobile_opportunities.created_at', [$start, $end]);
    }

    public function setNewCallbackAttribute($value)
    {
        $this->callbacks()->create([
            'time'       => $value,
            'user_id'    => auth()->user()->id,
            'created_by' => auth()->user()->id,
        ]);
    }

    public function scopeReassignableFilters($query)
    {
        $status = MobileOpportunityStatus::where('name', 'Awaiting Credit Check')->first()->order;

        $query->whereHas('status', function ($qry) use ($status) {
            $qry->where('order', '<', $status);
        });
    }

    public function setGpAttribute($value)
    {
        try {
            $this->attributes['gp'] = floatval($value);
        } catch (\Exception $e) {
            $this->attributes['gp'] = 0;
        }
    }

    public function scopeCallbacksBetween($query, $dates)
    {
        !empty($dates) && $query->whereHas('callbacks', function ($qry) use ($dates) {
            $qry->whereBetween('time', $dates);
        });
    }

    public function scopeAssigned($query, $user)
    {
        !empty($user) && $query->whereHas('activeAssigned', function ($q) use ($user) {
            $q->where('users.id', $user);
        });
    }

    public function setReviewDateAttribute($value)
    {
        $this->attributes['review_date'] = $value instanceof Carbon || empty($value)
            ? $value
            : Carbon::createFromFormat('d/m/Y', $value);

        $this->attributes['reviewed_by'] = auth()->user()->id;
    }

    public function setNoBillAttribute($value)
    {
        $this->attributes['no_bill'] = $value;

        $this->attributes['no_bill_date'] = Carbon::now();
    }

    public function scopeBillsToday($query)
    {
        return $query->where('no_bill', 0)
                     ->whereHas('mobileBills', function ($q) {
                         $q->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()]);
                     });
    }

    public function scopeNoBillsToday($query)
    {
        return $query->where('no_bill', 1)
                     ->whereBetween('no_bill_date', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()]);
    }

    public function scopeBillOrRequirementsToday($query)
    {
        return $query->where(function ($qry) {
            $qry->billsToday()
                ->orWhere(function ($q) {
                    $q->noBillsToday();
                });
        });
    }

    public function scopeIgnoreUsers($query)
    {
        return $query->whereNotIn('created_by', [44, 61, 89, 6]);
    }

    public function setAppointmentInfoAttribute($info)
    {
        if (array_key_exists('time', $info) && !empty($info['time'])) {
            if ($this->exists) {
                return $this->appointments()->create($info);
            }

            static::created(function ($opportunity) use ($info) {
                return $opportunity->appointments()->create($info);
            });
        }
    }

    public function setBackToLeadGenAttribute($value)
    {
        if ($value == 1) {
            $this->update([
                'no_bill'      => 0,
                'no_bill_date' => null,
            ]);
        }
    }

    public function setHotTransferAttribute($info)
    {
        $info = collect($info);

        if ($info->get('confirm') == 1) {
            $this->attributes['hot_transfer']                 = 1;
            $this->attributes['valid']                        = 1;
            $this->attributes['validated_at']                 = Carbon::now();
            $this->attributes['validated_by']                 = auth()->user()->id;
            $this->attributes['mobile_opportunity_status_id'] = (new MobileOpportunityStatusHelper)->get('awaiting-closer-contact');
            $this->attributes['status_updated_at']            = Carbon::now();
            $this->attributes['no_bill']                      = 1;
            $this->attributes['no_bill_date']                 = Carbon::now();

            $this->setUserIdAttribute($info->get('user_id'));
        }
    }

    public function deleteFilesExceptBill()
    {
        $this->files()
             ->where(
                 'customer_file_type_id',
                 '<>',
                 CustomerFileType::where('name', 'Mobile Bill')->first()->id
             )
             ->get()
             ->each(function ($file) {
                 Storage::delete($file->location);

                 $file->delete();
             });
    }

    public function dealCalculators()
    {
        return $this->hasMany(DealCalculator::class);
    }

    public function activeDealCalculator()
    {
        return $this->hasMany(DealCalculator::class)
                    ->where('active', 1);
    }

    public function selectedDealCalculator()
    {
        return $this->hasMany(DealCalculator::class)
                    ->where('active', 1)
                    ->where('primary', 1);
    }

    public function path($page = null)
    {
        return '/customers/' . $this->customer->id . '/mobile/opportunities/' . $this->id . '/' . $page;
    }

    public function scopeIsHotTransfer($query)
    {
        return $query->where('hot_transfer', 1);
    }

    public function scopeIsNotHotTransfer($query)
    {
        return $query->where(function ($qry) {
            $qry->where('hot_transfer', 0)
                ->orWhereNull('hot_transfer');
        });
    }

    public function scopeIsAppointment($query)
    {
        return $query->where('appointment', 1);
    }

    public function scopeIsNotAppointment($query)
    {
        return $query->where('appointment', 0);
    }

    public function setNotQualifiedReasonAttribute($value)
    {
        $this->customerNotes()->create([
            'body'                  => $value,
            'customer_note_type_id' => 8,
            'customer_id'           => $this->customer->id,
        ]);

        return $this->attributes['not_qualified_reason'] = $value;
    }

    public function setBlownReasonAttribute($value)
    {
        $this->customerNotes()->create([
            'body'                  => $value,
            'customer_note_type_id' => 8,
            'customer_id'           => $this->customer->id,
        ]);

        if ($this->cashFlowItem) {
            $this->cashFlowItem->update([
                'canceled_at' => Carbon::now()
            ]);
        }
    }

    public function setCreditCheckFailedReasonAttribute($value)
    {
        $this->customerNotes()->create([
            'body'                  => $value,
            'customer_note_type_id' => 8,
            'customer_id'           => $this->customer->id,
        ]);

        return $this->attributes['credit_check_failed_reason'] = $value;
    }

    public function setOtherServicesAttribute($array)
    {
        $this->customer->otherServices()->create($array);
    }

    public function scopePendingQualification($query)
    {
        $query->whereNull('qualified_at')->whereNull('qualified');
    }

    public function setAcceptedProposalAttribute($value)
    {
        $dealCalculator = DealCalculator::find($value);

        if ($dealCalculator) {
            $this->update([
                'gp'            => $dealCalculator->overview->totalProfit,
                'bcad_required' => $dealCalculator->overview->bcad > 0 || $dealCalculator->getBcadDiff() > 0
            ]);

            $this->dealCalculators->each(function ($c) use ($dealCalculator) {
                $c->update([
                    'primary' => $c->id == $dealCalculator->id
                ]);
            });
        }
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

    public function adobeSignDocumentBondAgreement()
    {
        return $this->morphOne(AdobeSignDocument::class, 'signable')
                    ->where('type', 'bond-agreement');
    }

    public function scopeCreatorOffice($query, $office)
    {
        if ($office) {
            return $query->whereHas('creator', function ($query) use ($office) {
                return $query->where('office_id', $office instanceof Office ? $office->id : $office);
            });
        }

        return $query;
    }

    public function scopeAssignedOffice($query, $office)
    {
        if ($office) {
            return $query->whereHas('activeAssigned', function ($qry) use ($office) {
                return $qry->where('office_id', $office);
            });
        }

        return $query;
    }

    public function scopeHasBills($query, Carbon $start, Carbon $end)
    {
        return $query->where('no_bill', 0)
                     ->whereHas('mobileBills', function ($q) use ($start, $end) {
                         $q->whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()]);
                     });
    }

    public function scopeNoBills($query, Carbon $start, Carbon $end)
    {
        return $query->where('no_bill', 1)
                     ->whereBetween('no_bill_date', [$start->startOfDay(), $end->endOfDay()]);
    }

    public function scopeBillOrRequirements($query, Carbon $start, Carbon $end)
    {
        return $query->where(function ($qry) use ($start, $end) {
            $qry->hasBills($start, $end)
                ->orWhere(function ($q) use ($start, $end) {
                    $q->noBills($start, $end);
                });
        });
    }

    public function scopeNoBillDate($query, Carbon $start, Carbon $end)
    {
        return $query->whereBetween('no_bill_date', [$start->startOfDay(), $end->endOfDay()]);
    }

    public function scopeValid($query, Carbon $start, Carbon $end)
    {
        $query->where('valid', 1)
              ->whereBetween('validated_at', [$start->startOfDay(), $end->endOfDay()]);
    }

    public function scopeNotValid($query, Carbon $start, Carbon $end)
    {
        $query->where('valid', 0)
              ->whereBetween('validated_at', [$start->startOfDay(), $end->endOfDay()]);
    }

    public function tariffMatch()
    {
        return $this->hasOne(TariffMatch::class);
    }

    public function cashFlowItem()
    {
        return $this->hasOne(CashFlowItem::class);
    }

    public function isBlown()
    {
        return $this->status->blown == 1;
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class, 'mobile_opportunity_id');
    }

    public function allocationsOrderedByConnection()
    {
        return $this->hasMany(Allocation::class, 'mobile_opportunity_id')
                    ->orderBy('connected', 'asc');
    }

    public function corrections()
    {
        return $this->hasMany(Correction::class, 'mobile_opportunity_id');
    }

    public function unactionedCorrections()
    {
        return $this->hasMany(Correction::class, 'mobile_opportunity_id')
                    ->where('actioned', 0);
    }

    public function processAdobeSign()
    {
        if ($this->status->order <= (new MobileOpportunityStatusHelper)->getOrder('awaiting-purchase-order')) {
            return $this->purchaseOrderSigned();
        }

        if ($this->status->order <= (new MobileOpportunityStatusHelper)->getOrder('awaiting-bond')) {
            return $this->bondAgreementSigned();
        }
    }

    public function purchaseOrderSigned()
    {
        $this->update([
            'mobile_opportunity_status_id' => (new MobileOpportunityStatusHelper)->get('awaiting-quality-control'),
            'dealt_at'                     => Carbon::now()
        ]);

        $assigned = $this->activeAssigned->first()
            ? $this->activeAssigned->first()->id
            : $this->created_by;

        $this->notifications()->create([
            'subject'   => 'Mobile Opportunity' . $this->id . ' has had a purchase order signed.',
            'sender_id' => $assigned,
            'user_id'   => $assigned,
        ]);

        $this->customer->notes()->create([
            'customer_note_type_id' => 9,
            'body'                  => 'Purchase Order Signed',
            'notable_type'          => 'mobileOpportunity',
            'notable_id'            => $this->id,
            'user_id'               => $assigned,
        ]);

        (new SalesSheetController)->generateSalesSheet($this->customer, $this);
    }

    public function bondAgreementSigned()
    {
        $assigned = $this->activeAssigned->first()
            ? $this->activeAssigned->first()->id
            : $this->created_by;

        $this->notifications()->create([
            'subject'   => 'Mobile Opportunity' . $this->id . ' has had a Bond Agreement signed.',
            'sender_id' => $assigned,
            'user_id'   => $assigned,
        ]);

        $this->customer->notes()->create([
            'customer_note_type_id' => 9,
            'body'                  => 'Bond Agreement Signed',
            'notable_type'          => 'mobileOpportunity',
            'notable_id'            => $this->id,
            'user_id'               => $assigned,
        ]);

        $this->update([
            'mobile_opportunity_status_id' => 26
        ]);
    }

    public function setBondAmountAttribute($value)
    {
        return $this->attributes['bond_amount'] = $value * 100;
    }

    public function getBondAmountAttribute($value)
    {
        return $value / 100;
    }

    public function juc()
    {
        return $this->morphMany(CustomerFile::class, 'related')
                    ->where('customer_file_type_id', CustomerFileType::where('slug', 'mobile_juc')->first()->id);
    }

    public function requiredPacCode()
    {
        return $this->allocations()
                    ->whereNull('pac_code')
                    ->whereNotNull('network_from')
                    ->where('type', 'Port')
                    ->count() > 0;
    }

    public function canHavePacCode()
    {
        return $this->allocations()
                    ->whereNotNull('network_from')
                    ->where('type', 'Port')
                    ->get()
                    ->groupBy('network_from');
    }

    public function allocationPacCode($network)
    {
        $allocation = $this->allocations()
                           ->whereNotNull('network_from')
                           ->where('type', 'Port')
                           ->where('network_from', $network)
                           ->first();

        return $allocation
            ? $allocation->pac_code
            : null;
    }

    public function scopeAwaitingPacCode($query)
    {
        return $query->connectedOverride()
                     ->where(
                         'mobile_opportunity_status_id',
                         (new MobileOpportunityStatusHelper)->get('awaiting-fulfilment')
                     )
                     ->whereHas('allocations', function ($query) {
                         return $query->whereNotNull('network_from')
                                      ->where('type', 'Port')
                                      ->whereNull('pac_code');
                     });
    }

    public function scopeAwaitingBcad($query)
    {
        return $query->connectedOverride()
                     ->where(
                         'mobile_opportunity_status_id',
                         (new MobileOpportunityStatusHelper)->get('awaiting-fulfilment')
                     )
                     ->whereNull('bcad_reference')
                     ->where('bcad_required', 1)
                     ->whereDoesntHave('juc');
    }

    public function scopePendingBcad($query)
    {
        return $query->connectedOverride()
                     ->where(
                         'mobile_opportunity_status_id',
                         (new MobileOpportunityStatusHelper)->get('awaiting-fulfilment')
                     )
                     ->whereNull('bcad_reference')
                     ->where('bcad_required', 1)
                     ->whereHas('juc');
    }

    public function requiresBcad()
    {
        return $this->allocations->count()                             > 0 && $this->bcad_required == 1
            ? $this->selectedDealCalculator()->first()->overview->bcad > 0
            : false;
    }

    public function bcadReferenceComplete()
    {
        return !empty($this->bcad_reference);
    }

    public function scopeAwaitingSims($query)
    {
        return $query->connectedOverride()
                     ->where(
                         'mobile_opportunity_status_id',
                         (new MobileOpportunityStatusHelper)->get('awaiting-fulfilment')
                     )
                     ->whereHas('allocations', function ($qry) {
                         $qry->whereNull('tracking_number');
                     });
    }

    public function hasAllocations()
    {
        return $this->allocations->count();
    }

    public function requiresSims()
    {
        return $this->allocations->count() > 0 &&
            $this->allocations()
                 ->whereNotNull('tracking_number')
                 ->whereNotNull('sim_number')
                 ->count() > 0;
    }

//    public function scopeAwaitingUnlocks($query)
//    {
//        return $query->connectedOverride()
//                     ->where('mobile_opportunity_status_id',
//                         (new MobileOpportunityStatusHelper)->get('awaiting-fulfilment'))
//                     ->whereHas('allocations', function ($qry) {
//                         $qry->where('type', 'Port')
//                             ->whereNull('handset_id');
//                     });
//    }

    public function scopeAwaitingUnlocks($query)
    {
        return $query->connectedOverride()
                     ->where(
                         'mobile_opportunity_status_id',
                         (new MobileOpportunityStatusHelper)->get('awaiting-fulfilment')
                     )
                     ->whereHas('allocations', function ($qry) {
                         $qry->where('type', 'Port')
                             ->where('network_from', '<>', 'O2')
                             ->whereNull('unlocked_requested')
                             ->where(function ($query) {
                                 return $query->whereNull('handset_id')
                                              ->orWhereHas('handset', function ($q) {
                                                  return $q->where('model', 'Additional Sim Card');
                                              });
                             });
                     });
    }

    public function scopePendingUnlock($query)
    {
        return $query->connectedOverride()
                     ->where(
                         'mobile_opportunity_status_id',
                         (new MobileOpportunityStatusHelper)->get('awaiting-fulfilment')
                     )
                     ->whereHas('allocations', function ($qry) {
                         $qry->where('type', 'Port')
                             ->where('network_from', '<>', 'O2')
                             ->whereNotNull('unlocked_requested')
                             ->whereNull('unlocked_confirmed')
                             ->where(function ($query) {
                                 return $query->whereNull('handset_id')
                                              ->orWhereHas('handset', function ($q) {
                                                  return $q->where('model', 'Additional Sim Card');
                                              });
                             });
                     });
    }

    public function awaitingUnlock()
    {
        return $this->allocations()
                    ->where('type', 'Port')
                    ->whereNotNull('network_from')
                    ->where('network_from', '<>', 'O2')
                    ->where(function ($query) {
                        return $query->whereNull('handset_id')
                                     ->orWhereHas('handset', function ($q) {
                                         return $q->where('model', 'Additional Sim Card');
                                     });
                    })
                    ->count() > 0;
    }

    public function unlockPending()
    {
        return $this->allocations()
                    ->whereNotNull('network_from')
                    ->where('network_from', '<>', 'O2')
                    ->whereNotNull('unlocked_requested')
                    ->whereNull('unlocked_confirmed')
                    ->where(function ($query) {
                        return $query->whereNull('handset_id')
                                     ->orWhereHas('handset', function ($q) {
                                         return $q->where('model', 'Additional Sim Card');
                                     });
                    })
                    ->count() > 0;
    }

    public function unlockComplete()
    {
        return $this->allocations()
                    ->whereNotNull('network_from')
                    ->where('network_from', '<>', 'O2')
                    ->whereNotNull('unlocked_requested')
                    ->whereNotNull('unlocked_confirmed')
                    ->where(function ($query) {
                        return $query->whereNull('handset_id')
                                     ->orWhereHas('handset', function ($q) {
                                         return $q->where('model', 'Additional Sim Card');
                                     });
                    })
                    ->count() > 0;
    }

    public function scopeAwaitingStock($query)
    {
        return $query->connectedOverride()
                     ->where('mobile_opportunity_status_id', (new MobileOpportunityStatusHelper)->get('awaiting-fulfilment'))
                     ->where(function ($qry) {
                         $qry->where(function ($qry) {
                             return $qry->whereNotNull('bcad_reference')
                                        ->where('bcad_required', 1);
                         })->orWhere(function ($qry) {
                             return $qry->whereNull('bcad_reference')
                                        ->where('bcad_required', 0);
                         });
                     })
                     ->where(function ($qry) {
                         $qry->where(function ($qry) {
                             return $qry->whereNotNull('bond_type')
                                        ->whereNotNull('bond_payment_reference');
                         })->orWhere(function ($qry) {
                             return $qry->whereNull('bond_type');
                         });
                     })
                     ->whereHas('allocations', function ($qry) {
                         $qry->whereNotNull('tender_complete')
                             ->whereNull('stock_ordered')
                             ->whereHas('handset', function ($q) {
                                 $q->where('pre_order', 0);
                             })
                             ->whereNotNull('tracking_number')
                             ->whereNotNull('sim_number')
                             ->where(function ($q) {
                                 return $q->where(function ($query) {
                                     return $query->where('type', 'Port')
                                                ->whereNotNull('pac_code');
                                 })
                                    ->orWhere(function ($query) {
                                        return $query->where('type', 'New connection');
                                    });
                             });
                     });
    }

    public function scopeAwaitingImei($query)
    {
        return $query->connectedOverride()
                     ->where('mobile_opportunity_status_id', (new MobileOpportunityStatusHelper)->get('awaiting-fulfilment'))
                     ->whereHas('allocations', function ($qry) {
                         $qry->whereNotNull('stock_ordered')
                             ->whereNull('imei');
                     });
    }

    public function willNeedStock()
    {
        return $this->allocations()
                    ->whereHas('handset', function ($q) {
                        $q->where('pre_order', 0);
                    })
                    ->count() > 0;
    }

    public function needsStock()
    {
        if (!is_null($this->bond_type) && !$this->bond_payment_reference) {
            return false;
        }

        return $this->allocations()
                    ->whereNotNull('tender_complete')
                    ->whereHas('handset', function ($q) {
                        $q->where('pre_order', 0);
                    })
                    ->count() > 0;
    }

    public function allStockOrdered()
    {
        return $this->allocations()
                    ->whereNull('stock_ordered')
                    ->whereHas('handset', function ($q) {
                        $q->where('pre_order', 0);
                    })
                    ->count() == 0;
    }

    public function anyStockOrdered()
    {
        return $this->allocations()
                    ->whereNull('stock_ordered')
                    ->whereHas('handset', function ($q) {
                        $q->where('pre_order', 0);
                    })
                    ->count() == 0;
    }

    public function canBePorted()
    {
        return $this->allocations()
                    ->where('type', 'Port')
                    ->count() > 0;
    }

    public function readyToPort()
    {
        foreach ($this->allocations as $allocation) {
            if ($allocation->portable()) {
                return true;
            }
        }

        return false;
    }

    public function portDateSet()
    {
        return $this->allocations()
                    ->where('type', 'Port')
                    ->whereNull('port_date')
                    ->count() == 0;
    }

    public function scopeAwaitingPort($query)
    {
        $status = (new MobileOpportunityStatusHelper())->get('awaiting-fulfilment');

        return $query->connectedOverride()
                     ->where('mobile_opportunity_status_id', $status)
                     ->where(function ($qry) {
                         $qry->where(function ($qry) {
                             return $qry->whereNotNull('bcad_reference')
                                        ->where('bcad_required', 1);
                         })->orWhere(function ($qry) {
                             return $qry->whereNull('bcad_reference')
                                        ->where('bcad_required', 0);
                         });
                     })
                     ->where(function ($qry) {
                         $qry->where(function ($qry) {
                             return $qry->whereNotNull('bond_type')
                                        ->whereNotNull('bond_payment_reference');
                         })->orWhere(function ($qry) {
                             return $qry->whereNull('bond_type')
                                        ->whereNull('bond_payment_reference');
                         });
                     })
                     ->whereHas('allocations', function ($qry) {
                         return $qry->where('type', 'Port')
                                    ->whereNull('port_date')
                                    ->whereNotNull('pac_code')
                                    ->whereNotNull('tracking_number')
                                    ->whereNotNull('sim_number')
                                    ->where(function ($q) {
                                        return $q->where(function ($qry) {
                                            return $qry->whereNotNull('stock_ordered')
                                                       ->whereHas('handset', function ($q) {
                                                           return $q->where('pre_order', 0);
                                                       });
                                        })->orWhere(function ($qry) {
                                            return $qry->doesntHave('handset')
                                                       ->orWhereHas('handset', function ($q) {
                                                           return $q->where('pre_order', 1);
                                                       });
                                        })->orWhere(function ($qry) {
                                            return $qry->where('network_from', 'O2');
                                        });
                                    });
                     });
    }

    public function scopeAwaitingBondPayment($query)
    {
        $status = (new MobileOpportunityStatusHelper())->get('awaiting-fulfilment');

        return $query->connectedOverride()
                    ->where('mobile_opportunity_status_id', $status)
                    ->whereNotNull('bond_type')
                    ->whereNull('bond_payment_reference')
                    ->where(function ($qry) {
                        $qry->where(function ($qry) {
                            return $qry->whereNotNull('bcad_reference')
                                        ->where('bcad_required', 1);
                        })->orWhere(function ($qry) {
                            return $qry->whereNull('bcad_reference')
                                        ->where('bcad_required', 0);
                        });
                    })
                    ->where(function ($qry) {
                        $qry->where(function ($qry) {
                            return $qry->whereNotNull('bond_type')
                                       ->whereNull('bond_payment_reference');
                        });
                    })
                    ->whereHas('allocations', function ($qry) {
                        return $qry->where(function ($q) {
                            return  $q->whereNotNull('tracking_number')
                                    ->orWhere(function ($query) {
                                        return $query->where('type', 'Port')
                                                        ->whereNotNull('pac_code')
                                                        ->whereNotNull('tracking_number');
                                    });
                        });
                    });
    }

    public function readyForBondPayment()
    {
        foreach ($this->allocations as $allocation) {
            if ($allocation->readyForBondPayment()) {
                return true;
            }
        }

        return false;
    }

    public function scopeAwaitingConnection($query)
    {
        $status = (new MobileOpportunityStatusHelper())->get('awaiting-fulfilment');

        return $query->connectedOverride()
                     ->where('mobile_opportunity_status_id', $status)
                     ->where(function ($qry) {
                         $qry->where(function ($qry) {
                             return $qry->whereNotNull('bcad_reference')
                                        ->where('bcad_required', 1);
                         })->orWhere(function ($qry) {
                             return $qry->whereNull('bcad_reference')
                                        ->where('bcad_required', 0);
                         });
                     })
                     ->where(function ($qry) {
                         $qry->where(function ($qry) {
                             return $qry->whereNotNull('bond_type')
                                        ->whereNotNull('bond_payment_reference');
                         })->orWhere(function ($qry) {
                             return $qry->whereNull('bond_type');
                         });
                     })
                     ->whereHas('allocations', function ($qry) {
                         return $qry->whereNull('sent_for_connection')
                                    ->where(function ($q) {
                                        $q->whereNotNull('port_date')
                                          ->orWhere(function ($query) {
                                              $query->where('type', 'New connection')
                                                    ->whereNotNull('tracking_number');
                                          });
                                    });
                     });
    }

    public function hasAwaitingConnections()
    {
        foreach ($this->allocations as $allocation) {
            if ($allocation->connectable() && !$allocation->sent_for_connection) {
                return true;
            }
        }

        return false;
    }

    public function scopePendingConnection($query)
    {
        return $query->connectedOverride()
                     ->where(
                         'mobile_opportunity_status_id',
                         (new MobileOpportunityStatusHelper)->get('awaiting-fulfilment')
                     )
                     ->whereHas('allocations', function ($query) {
                         return $query->whereNotNull('sent_for_connection')
                                      ->whereNull('connection_deferred')
                                      ->whereNull('connection_error')
                                      ->whereNull('connected');
                     });
    }

    public function hasPendingConnections()
    {
        return $this->allocations()
                    ->whereNotNull('sent_for_connection')
                    ->whereNull('connection_deferred')
                    ->whereNull('connection_error')
                    ->whereNull('connected')
                    ->count() > 0;
    }

    public function scopeConnectionDeferred($query)
    {
        return $query->connectedOverride()
                     ->where(
                         'mobile_opportunity_status_id',
                         (new MobileOpportunityStatusHelper)->get('awaiting-fulfilment')
                     )
                     ->whereHas('allocations', function ($query) {
                         return $query->whereNotNull('sent_for_connection')
                                      ->whereNotNull('connection_deferred')
                                      ->whereNull('connection_error')
                                      ->whereNull('connected');
                     });
    }

    public function hasDeferredConnections()
    {
        return $this->allocations()
                    ->whereNotNull('sent_for_connection')
                    ->whereNotNull('connection_deferred')
                    ->whereNull('connection_error')
                    ->whereNull('connected')
                    ->count() > 0;
    }

    public function scopeConnectionError($query)
    {
        return $query->connectedOverride()
                     ->where(
                         'mobile_opportunity_status_id',
                         (new MobileOpportunityStatusHelper)->get('awaiting-fulfilment')
                     )
                     ->whereHas('allocations', function ($query) {
                         return $query->whereNotNull('sent_for_connection')
                                      ->whereNotNull('connection_error')
                                      ->whereNull('connected');
                     });
    }

    public function hasConnectionErrors()
    {
        return $this->allocations()
                    ->whereNotNull('sent_for_connection')
                    ->whereNotNull('connection_error')
                    ->whereNull('connected')
                    ->count() > 0;
    }

    public function scopeConnected($query)
    {
        return $query->connectedOverride()
                     ->where(
                         'mobile_opportunity_status_id',
                         (new MobileOpportunityStatusHelper)->get('awaiting-fulfilment')
                     )
                     ->whereHas('allocations', function ($query) {
                         return $query->whereNotNull('sent_for_connection')
                                      ->whereNotNull('connected');
                     });
    }

    public function hasConnectedLines()
    {
        return $this->allocations()
                    ->whereNotNull('sent_for_connection')
                    ->whereNotNull('connected')
                    ->count() > 0;
    }

    public function setCreditCheckEscalatedAttribute($value)
    {
        FulfilmentTimeLineItem::create([
            'action'                => 'Credit Check Escalated',
            'mobile_opportunity_id' => $this->id,
            'user_id'               => auth()->user()->id,
        ]);
    }

    public function setCreditCheckFailedAttribute($value)
    {
        if ($this->cashFlowItem) {
            $this->cashFlowItem->update([
                'declined_at' => Carbon::now()
            ]);
        }

        FulfilmentTimeLineItem::create([
            'action'                => 'Credit Check Failed',
            'mobile_opportunity_id' => $this->id,
            'user_id'               => auth()->user()->id,
        ]);
    }

    public function setCreditCheckPassedAttribute($value)
    {
//        event(new CreditCheckPassed($this));

        FulfilmentTimeLineItem::create([
            'action'                => 'Credit Check Passed',
            'mobile_opportunity_id' => $this->id,
            'user_id'               => auth()->user()->id,
        ]);

        return $this->attributes['credit_checked_at'] = Carbon::now();
    }

    public function fulfilmentTimeLine()
    {
        return $this->hasMany(FulfilmentTimeLineItem::class, 'mobile_opportunity_id');
    }

    public function fulfilmentTimeLineOpportunity()
    {
        return $this->hasMany(FulfilmentTimeLineItem::class, 'mobile_opportunity_id')
                    ->whereNull('allocation_id');
    }

    public function fulfilmentTimeLineAllocation()
    {
        return $this->hasMany(FulfilmentTimeLineItem::class, 'mobile_opportunity_id')
                    ->whereNotNull('allocation_id');
    }

    public function getGroupedTimeLine()
    {
        $items = $this->fulfilmentTimeLineAllocation()
                      ->with(['allocation', 'user'])
                      ->get()
                      ->groupBy('allocation_id');

        return $items;
    }

    public function scopeConnectedOverride($query)
    {
        return $query->has('allocations');
    }

    public function scopeDealtBetween($query, $dates)
    {
        return $query->whereBetween('dealt_at', $dates)
                     ->orWhereHas('purchaseOrder', function ($qry) use ($dates) {
                         return $qry->whereBetween('created_at', $dates);
                     });
    }

    public function scopeDealt($query)
    {
        return $query->whereNotNull('dealt_at')
                     ->orHas('purchaseOrder');
    }

    public function setBondPaymentReferenceAttribute($value)
    {
        FulfilmentTimeLineItem::create([
            'action'                => 'Bond Payment Reference Added or Updated',
            'mobile_opportunity_id' => $this->id,
            'user_id'               => auth()->user()->id,
        ]);

        $this->attributes['bond_payment_reference'] = $value;
    }

    public function setOrderCanceledAttribute($value)
    {
        if ($this->cashFlowItem) {
            $this->cashFlowItem->update([
                'canceled_at' => Carbon::now()
            ]);
        }
    }

    public function setFulfilmentSavedDealAttribute($value)
    {
        if ($this->cashFlowItem) {
            $this->cashFlowItem->update([
                'canceled_at' => null
            ]);
        }
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function countConnectionsByType($type)
    {
        return $this->allocations->where('type', $type)->count();
    }

    public function getActiveEpRef()
    {
        $allocation = $this->allocations()
                    ->whereNotNull('connection_reference')
                    ->whereNull('connected')
                    ->first();

        return $allocation
                ? $allocation->connection_reference
                : '';
    }

    public function scopeAwaitingCorrection($query)
    {
        return $query->where(function ($q) {
            $q->where('mobile_opportunity_status_id', 24)
                ->orWhere(function ($qry) {
                    $qry->where('mobile_opportunity_status_id', '<=', 10)
                    ->has('unactionedCorrections');
                });
        });
    }

    public function scopeNotFullyConnected($query)
    {
        return $query->whereHas('allocations', function ($qry) {
            return $qry->whereNull('connected');
        });
    }
}
