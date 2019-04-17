<?php


namespace App\Models\FixedLineOpportunity\Traits;


use App\Models\FixedLineOpportunity\FixedLineOpportunityStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

trait Scopes
{


    public function scopeViewPermissions($query)
    {
        if (auth()->user()->isAdmin()) {
            return $query;
        }

        if (auth()->user()->hasAnyPermission(['show_all_leads_fixed_line', 'show_all_appointment_leads_fixed_line'])) {
            return $query->where(function ($q) {
                if (auth()->user()->hasPermission('show_all_leads_fixed_line')) {
                    $q->orWhere('appointment', 0);
                }

                if (auth()->user()->hasPermission('show_all_appointment_leads_fixed_line')) {
                    $q->orWhere('appointment', 1);
                }
            });
        }

        return $query->whereHas('activeAssigned', function ($qry) {
            $qry->where('users.id', auth()->user()->id);
        })->orWhere('created_by', auth()->user()->id);
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
        collect(request()->except('page'))
            ->filter(function ($value, $key) {
                return $value >= 0 && !is_null($value);
            })
            ->each(function ($filter, $col) use (&$query) {
                if (!empty($filter) || $filter == 0) {
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
                        if (Schema::hasColumn('fixed_line_opportunities', $col)) {
                            $query->where($col, $filter);
                        }
                    }
                }
            });

        $query->filterAppointmentDate(request()->get('appointment_from'), request()->get('appointment_to'));

        return $query;
    }

    public function scopeFilterAppointmentDate($query, $start, $end)
    {
        try {
            $start = Carbon::createFromFormat('d/m/Y', $start)->startOfDay();
            $end = Carbon::createFromFormat('d/m/Y', $end)->endOfDay();
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
        $statuses = FixedLineOpportunityStatus::whereIn('name', $names)->pluck('id') ?? null;

        $statuses && $query->whereIn('fixed_line_opportunity_status_id', $statuses);
    }

    public function scopeStatusId($query, $id)
    {
        return $id
            ? $query->where('fixed_line_opportunity_status_id', $id)
            : $query;
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
                    $q->where('fixed_line_opportunity_statuses.name', 'Not Qualified');
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
        $start && $end && $query->whereBetween('fixed_line_opportunities.created_at', [$start, $end]);
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

    public function scopeBillsToday($query)
    {
        return $query->whereHas('fixedLineBills', function ($q) {
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

    public function scopePendingQualification($query)
    {
        $query->whereNull('qualified_at')->whereNull('qualified');
    }
}