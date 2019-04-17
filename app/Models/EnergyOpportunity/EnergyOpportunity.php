<?php

namespace App\Models\EnergyOpportunity;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerFile;
use App\Models\Customer\CustomerFileType;
use App\Models\Customer\CustomerNote;
use App\Models\Customer\ScheduledCallback;
use App\Models\Customer\WelcomeCall;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class EnergyOpportunity extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'status_updated_at',
        'qualified_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'monthly_spend',
        'number_of_sites',
        'looking_for_prices',
        'direct_or_broker',
        'typical_contact_length',
        'supplier_to_avoid',
        'energy_procurement',
        'price_comparison',
        'kva_mapping_report',
        'contract_validation',
        'energy_audit',
        'notes',
        'energy_opportunity_status_id',
        'valid',
        'qualified',
        'not_qualified_reason',
        'user_id',
        'new_callback',
        'meter',
        'detach_meter',
        'accepted',
    ];

    /**
     * Get the customer for the energy opportunity.
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
    public function reassignable()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->wherePivot('active', 1)
            ->wherePivot('created_at', '<=', Carbon::now()->startOfDay()->subDays(3))
            ->withPivot('active', 'created_at');
    }

    /**
     * Get the status of the energy opportunity.
     */
    public function status()
    {
        return $this->belongsTo(EnergyOpportunityStatus::class, 'energy_opportunity_status_id');
    }

    public function meters()
    {
        return $this->belongsToMany(EnergyMeter::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files()
    {
        return $this->morphMany(CustomerFile::class, 'related');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function energyBills()
    {
        return $this->morphMany(CustomerFile::class, 'related')
            ->where('customer_file_type_id', CustomerFileType::where('slug', 'energy_bills')->first()->id);
    }

    public function letterOfAuthority()
    {

        return $this->morphMany(CustomerFile::class, 'related')
            ->where('customer_file_type_id', CustomerFileType::where('slug', 'letter_of_authority')->first()->id);
    }

    public function currentSupplierResponse()
    {

        return $this->morphMany(CustomerFile::class, 'related')
            ->where('customer_file_type_id', CustomerFileType::where('slug', 'current_supplier_response')->first()->id);
    }

    public function energyTender()
    {

        return $this->morphMany(CustomerFile::class, 'related')
            ->where('customer_file_type_id', CustomerFileType::where('slug', 'energy_tender')->first()->id);
    }

    public function energyTenderResponse()
    {

        return $this->morphMany(CustomerFile::class, 'related')
            ->where('customer_file_type_id', CustomerFileType::where('slug', 'energy_tender_response')->first()->id);
    }

    public function energyQuote()
    {

        return $this->morphMany(CustomerFile::class, 'related')
            ->where('customer_file_type_id', CustomerFileType::where('slug', 'energy_quote')->first()->id);
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

    /**
     * Get the suppliers that are, or were, related to the opportunity.
     */
    public function suppliers()
    {
        return $this->belongsToMany(EnergySupplier::class);
    }

    public function checkForUpdates()
    {
        if ($this->status->blown) {
            return;
        }

        $updated = 1;

        switch ($this) {
            case $this->energy_opportunity_status_id <= 1 && $this->energyBills->count() > 0:
                $data = ['energy_opportunity_status_id' => 2];

                break;
            case $this->energy_opportunity_status_id <= 2 && $this->letterOfAuthority->count() > 0:
                $data = ['energy_opportunity_status_id' => 3];

                break;

            case $this->energy_opportunity_status_id <= 3 && $this->valid == 1:
                $data = ['energy_opportunity_status_id' => 4];

                break;
            case $this->energy_opportunity_status_id <= 4 && count($this->activeAssigned) > 0:
                if (count($this->lastCallback()->get()) > 0
                    && $this->lastCallback()->first()->time >= Carbon::now()->startOfDay()->addMonth()
                ) {

                    $data = ['energy_opportunity_status_id' => 6];

                    break;
                }

                $data = ['energy_opportunity_status_id' => 5];

                break;

            case $this->energy_opportunity_status_id <= 6 && $this->qualified == 1:
                $data = ['energy_opportunity_status_id' => 7];

                break;

            case $this->energy_opportunity_status_id <= 8 && $this->energyTender->count() > 0:
                $data = ['energy_opportunity_status_id' => 9];

                break;

            case $this->energy_opportunity_status_id <= 10 && $this->energyQuote->count() > 0:
                $data = ['energy_opportunity_status_id' => 11];

                break;

            case $this->energy_opportunity_status_id <= 11 && $this->accepted == 1:
                $data = ['energy_opportunity_status_id' => 12];

                break;
            default:
                $data = [];
                $updated = 0;
        }

        if ($updated) {
            $this->update($data);

            $key = array_key_exists('energy_opportunity_status_id', $data)
                ? $data['energy_opportunity_status_id']
                : $this->status->id;

            $newStatus = EnergyOpportunityStatus::find($key);

            alert()->success('Status is now ' . $newStatus->name, 'Status Updated');
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
        return auth()->user()->isAdmin() || auth()->user()->hasPermission('show_all_leads_energy')
            ? $query
            : $query->whereHas('activeAssigned', function ($qry) {
                $qry->where('users.id', auth()->user()->id);
            })->orWhere('created_by', auth()->user()->id);
    }

    public function setEnergyOpportunityStatusIdAttribute($value)
    {
        $this->attributes['energy_opportunity_status_id'] = $value;
        $this->attributes['status_updated_at'] = Carbon::now();

        $status = EnergyOpportunityStatus::find($value);

        if ($this->exists) {
            $this->customer->notes()->create([
                'customer_note_type_id' => 5,
                'body' => 'Energy Opportunity ID:' . $this->id . ' has been updated to ' . $status->name,
                'notable_type' => 'energyOpportunity',
                'notable_id' => $this->id,
            ]);
        } else {
            static::created(function ($related) use ($status) {
                $related->customer->notes()->create([
                    'customer_note_type_id' => 5,
                    'body' => 'Energy Opportunity ID:' . $related->id . ' has been updated to ' . $status->name,
                    'notable_type' => 'energyOpportunity',
                    'notable_id' => $related->id,
                ]);
            });
        }
    }

    public function setUserIdAttribute($id)
    {
        $this->assigned->each(function ($user) {
            $user->pivot->active = 0;

            $user->pivot->save();
        });

        if ($id > 0) {
            $this->assigned()->attach($id);

            foreach ($this->incompleteCallbacks()->get() as $callback) {
                $callback->update([
                    'user_id' => $id
                ]);
            }
        }

        $this->checkForUpdates();
    }

    public function setQualifiedAttribute($value)
    {
        $this->attributes['qualified'] = $value;

        $this->attributes['qualified_at'] = Carbon::now();
    }

    public function recoverProcess($user)
    {
        $this->files->each(function ($file) {
            Storage::delete($file->location);

            $file->delete();
        });

        $this->update([
            'energy_opportunity_status_id' => 3,
            'credit_check' => 0,
            'accepted' => null,
            'valid' => null,
            'qualified' => null,
            'user_id' => $user,
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

    public function scopeCreatedByMe($query)
    {
        $query->where('created_by', auth()->user()->id);
    }

    public function scopeFilters($query)
    {
        collect(request()->except('page'))
            ->filter()
            ->each(function ($filter, $col) use (&$query) {
                if ($col == 'assigned') {
                    $query->whereHas('activeAssigned', function ($q) use ($filter) {
                        $q->where('users.id', $filter);
                    });
                } elseif ($col == 'created') {
                    $query->where('created_by', $filter);
                } elseif ($col == 'created_from') {
                    $query->where('created_at', '>=', Carbon::createFromFormat('d/m/Y', $filter)->startOfDay());
                } elseif ($col == 'created_to') {
                    $query->where('created_at', '<=', Carbon::createFromFormat('d/m/Y', $filter)->endOfDay());
                } else {
                    if (Schema::hasColumn('energy_opportunities', $col)) {
                        $query->where($col, $filter);
                    }
                }
            });

        return $query;
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
        $statuses = EnergyOpportunityStatus::whereIn('name', $names)->pluck('id') ?? null;

        $statuses && $query->whereIn('energy_opportunity_status_id', $statuses);
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
                    $q->where('energy_opportunity_statuses.name', 'Not Qualified');
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
        $start && $end && $query->whereBetween('energy_opportunities.created_at', [$start, $end]);
    }

    public function setNewCallbackAttribute($value)
    {
        $this->callbacks()->create([
            'time' => $value,
            'user_id' => auth()->user()->id,
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

    public function setMeterAttribute($value)
    {
        if ($this->meters()->where('energy_meters.id', $value)->count() == 0) {
            $this->meters()->attach($value);
        }
    }

    public function setDetachMeterAttribute($value)
    {
        $this->meters()->detach($value);
    }

    public function scopeReassignableFilters($query)
    {
        $status = EnergyOpportunityStatus::where('name', 'Awaiting Acceptance')->first()->id;

        $query->where('energy_opportunity_status_id', '<', $status);
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

    public function path($page = null)
    {
        return '/customers/' . $this->customer->id . '/energy/opportunities/' . $this->id . '/' . $page;
    }
}
