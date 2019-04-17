<?php

namespace App\Models\FixedLineOpportunity;


use App\Helpers\FixedLineOpportunityStatusHelper;
use App\Helpers\FixedLineOpportunityStatusUpdate;
use App\Models\Customer\CustomerFileType;
use App\Models\FixedLineOpportunity\Traits\FixedLineOpportunityStatusConditions;
use App\Models\FixedLineOpportunity\Traits\Relations;
use App\Models\FixedLineOpportunity\Traits\Scopes;
use App\Models\Opportunity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FixedLineOpportunity extends Opportunity
{

    use FixedLineOpportunityStatusConditions, Scopes, Relations;
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
        'validated_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'lines',
        'broadband',
        'monthly_spend',
        'contract_end_date',
        'contract_end_date_confirmed',
        'decide_30_days',
        'type',
        'notes',
        'current_allowances',
        'current_hardware',
        'new_hardware',
        'requirements',
        'qualified',
        'qualified_at',
        'not_qualified_reason',
        'appointment',
        'hot_transfer',
        'no_bill',
        'no_bill_date',
        'valid',
        'validated_at',
        'accepted',
        'provisioned',
        'provisioned_failed_reason',
        'gp',
        'mass_assigned',
        'fixed_line_opportunity_status_id',
        'status_updated_at',
        'recovered',
        'created_by',
        'created_at',
        'updated_at',
        'user_id',
        'new_callback',
        'appointment_info',
        'back_to_lead_gen',
        'customer_information'
    ];

    public function checkForUpdates()
    {
        $data = collect((new FixedLineOpportunityStatusUpdate($this))->getStatus());

        $otherData = $data->except('fixed_line_opportunity_status_id');

        $key = $data->get('fixed_line_opportunity_status_id');

        if ($data->isNotEmpty() && $key != $this->fixed_line_opportunity_status_id) {
            $this->update($data->toArray());

            $newStatus = FixedLineOpportunityStatus::find($key);

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

    public function setFixedLineOpportunityStatusIdAttribute($value)
    {
        $this->attributes['fixed_line_opportunity_status_id'] = $value;
        $this->attributes['status_updated_at'] = Carbon::now();

        $status = FixedLineOpportunityStatus::find($value);

        if ($this->exists) {
            $this->customer->notes()->create([
                'customer_note_type_id' => 5,
                'body'                  => 'Fixed Line Opportunity ID:' . $this->id . ' has been updated to ' . $status->name,
                'notable_type'          => 'fixedLineOpportunity',
                'notable_id'            => $this->id,
            ]);
        } else {
            static::created(function ($related) use ($status) {
                $related->customer->notes()->create([
                    'customer_note_type_id' => 5,
                    'body'                  => 'Fixed Line Opportunity ID:' . $related->id . ' has been updated to ' . $status->name,
                    'notable_type'          => 'fixedLineOpportunity',
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

        if ($this->appointment) {
            $appointment = $this->appointments()->first();

            $appointment && $appointment->update(['attended' => 1]);
        }
    }

    public function setValidAttribute($value)
    {
        $this->attributes['valid'] = $value;

        $this->attributes['validated_at'] = Carbon::now();
    }

    public function recoverProcess($user)
    {
        $this->files->each(function ($file) {
            if ($file->type->slug != 'fixed_line_bills') {
                Storage::delete($file->location);

                $file->delete();
            }
        });

        $this->update([
            'fixed_line_opportunity_status_id' => (new FixedLineOpportunityStatusHelper)->get('awaiting-closer-contact'),
            'credit_check'                     => 0,
            'accepted'                         => null,
            'valid'                            => null,
            'qualified'                        => null,
            'user_id'                          => $user,
            'review_date'                      => null,
        ]);
    }

    public function setNewCallbackAttribute($value)
    {
        $this->callbacks()->create([
            'time'       => $value,
            'user_id'    => auth()->user()->id,
            'created_by' => auth()->user()->id,
        ]);
    }

    public function setGpAttribute($value)
    {
        try {
            $this->attributes['gp'] = floatval($value);
        } catch (\Exception $e) {
            $this->attributes['gp'] = 0;
        }
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
            $this->attributes['hot_transfer'] = 1;
            $this->attributes['valid'] = 1;
            $this->attributes['validated_at'] = Carbon::now();
            $this->attributes['fixed_line_opportunity_status_id'] = (new FixedLineOpportunityStatusHelper)->get('awaiting-closer-contact');
            $this->attributes['status_updated_at'] = Carbon::now();
            $this->attributes['no_bill'] = 1;
            $this->attributes['no_bill_date'] = Carbon::now();

            $this->setUserIdAttribute($info->get('user_id'));
        }
    }

    public function deleteFilesExceptBill()
    {
        $this->files()
             ->where('customer_file_type_id', '<>',
                 CustomerFileType::where('name', 'Fixed Line Bill')->first()->id)
             ->get()
             ->each(function ($file) {
                 Storage::delete($file->location);

                 $file->delete();
             });
    }

    public function path($page = null)
    {
        return '/customers/' . $this->customer->id . '/fixed-line/opportunities/' . $this->id . '/' . $page;
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

    public function scopeHasBills($query, Carbon $start, Carbon $end)
    {
        return $query->where('no_bill', 0)
                     ->whereHas('fixedLineBills', function ($q) use ($start, $end) {
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

    public function commercials()
    {
        return $this->hasOne(Commercials::class);
    }

    public function customerInformation()
    {
        return $this->hasOne(CustomerInformation::class, 'fixed_line_opportunity_id');
    }

    public function setCustomerInformationAttribute($data)
    {
        empty($this->customerInformation)
            ? $this->customerInformation()->create($data)
            : $this->customerInformation->update($data);
    }

    public function processAdobeSign()
    {
        if($this->status->order <= (new FixedLineOpportunityStatusHelper)->getOrder('awaiting-purchase-order')) {
            return $this->purchaseOrderSigned();
        }
    }

    public function purchaseOrderSigned() {

        $this->update([
            'fixed_line_opportunity_status_id' => (new FixedLineOpportunityStatusHelper)->get('awaiting-provisioning')
        ]);

        $assigned = $this->activeAssigned->first()
            ? $this->activeAssigned->first()->id
            : $this->created_by;

        $this->notifications()->create([
            'subject'   => 'Fixed Line Opportunity' . $this->id . ' has had a purchase order signed.',
            'sender_id' => $assigned,
            'user_id'   => $assigned,
        ]);

        $this->customer->notes()->create([
            'customer_note_type_id' => 9,
            'body'                  => 'Purchase Order Signed',
            'notable_type'          => 'fixedLineOpportunity',
            'notable_id'            => $this->id,
            'user_id'               => $assigned,
        ]);
    }
}
