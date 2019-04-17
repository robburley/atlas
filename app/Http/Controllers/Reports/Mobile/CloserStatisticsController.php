<?php

namespace App\Http\Controllers\Reports\Mobile;

use App\Http\Controllers\Controller;
use App\Models\User\Role;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CloserStatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $start = Carbon::createFromFormat('d/m/Y', $request->get('start'))->startOfDay();
            $end = Carbon::createFromFormat('d/m/Y', $request->get('end'))->endOfDay();
        } catch (\Exception $e) {
            $start = Carbon::now()->startOfDay();
            $end = Carbon::now()->endOfDay();
        }

        $closers = $this->getData($start, $end);

        return view('reports.closer-statistics', [
            'data' => $closers
        ]);
    }

    public function getData($start, $end)
    {
        $users = User::active()->whereHas('role', function ($query) {
            $query->where('roles.id', Role::where('name', 'Closer')->first()->id);
        })
            ->get();


        $data = $users->map(function ($user) use ($start, $end) {
            return collect([
                'user_id' => $user->id,
                'name' => $user->name,
                'leads issued' => $user->activeMobileAssigned()
                    ->wherePivot('created_at', '<=', $end)
                    ->wherePivot('created_at', '>=', $start)
                    ->count(),
                'leads blown' => $user->activeMobileAssigned()
                    ->whereBetween('status_updated_at', [$start, $end])
                    ->whereHas('status', function ($query) {
                        $query->where('mobile_opportunity_statuses.blown', 1);
                    })
                    ->count(),
                'leads qualified' => $user->activeMobileAssigned()
                    ->where('qualified', 1)
                    ->whereBetween('qualified_at', [$start, $end])
                    ->count(),
                'leads un qualified' => $user->activeMobileAssigned()
                    ->where('qualified', 0)
                    ->whereBetween('qualified_at', [$start, $end])
                    ->count(),
                'props sent' => $user->activeMobileAssigned()
                    ->whereHas('proposal', function ($query) use ($start, $end) {
                        $query->whereBetween('customer_files.created_at', [$start, $end]);
                    })
                    ->count(),
                'deal calcls done' => $user->activeMobileAssigned()
                    ->where(function ($query) use ($start, $end) {
                        $query->whereHas('dealCalculator', function ($query) use ($start, $end) {
                            $query->whereBetween('customer_files.created_at', [$start, $end]);
                        })
                            ->orWhereHas('activeDealCalculator', function ($query) use ($start, $end) {
                                $query->whereBetween('deal_calculators.created_at', [$start, $end]);
                            });
                    })
                    ->count(),
                'pos sent out' => $user->activeMobileAssigned()
                    ->whereHas('purchaseOrder', function ($query) use ($start, $end) {
                        $query->whereBetween('customer_files.created_at', [$start, $end]);
                    })
                    ->count(),
            ]);
        });

        return $data->sortByDesc('leads issued');
    }


    public function show(User $user, Request $request)
    {

        try {
            $start = Carbon::createFromFormat('d/m/Y', $request->get('start'))->startOfDay();
            $end = Carbon::createFromFormat('d/m/Y', $request->get('end'))->endOfDay();
        } catch (\Exception $e) {
            $start = Carbon::now()->startOfDay();
            $end = Carbon::now()->endOfDay();
        }

        $user = $this->getUserData($user, $start, $end);

        $allTypes = collect([
            '' => 'Please Select',
            'leads issued' => 'leads issued',
            'leads blown' => 'leads blown',
            'leads qualified' => 'leads qualified',
            'leads un qualified' => 'leads un qualified',
            'props sent' => 'props sent',
            'deal calcls done' => 'deal calcls done',
            'pos sent out' => 'pos sent out',
        ]);

        $types = $request->has('type')
            ? $allTypes->only($request->get('type'))
            : $allTypes->except('');

        return view('reports.closer-statistics-show', [
            'user' => $user,
            'types' => $types,
            'allTypes' => $allTypes,
        ]);
    }

    public function getUserData($user, $start, $end)
    {
        return collect([
            'name' => $user->name,
            'leads issued' => $user->mobileAssigned()
                ->wherePivot('created_at', '<=', $end)
                ->wherePivot('created_at', '>=', $start)
                ->orderBy('mobile_opportunity_status_id', 'asc')
                ->get(),
            'leads blown' => $user->activeMobileAssigned()
                ->whereBetween('status_updated_at', [$start, $end])
                ->whereHas('status', function ($query) {
                    $query->where('mobile_opportunity_statuses.blown', 1);
                })
                ->orderBy('mobile_opportunity_status_id', 'asc')
                ->get(),
            'leads qualified' => $user->activeMobileAssigned()
                ->where('qualified', 1)
                ->whereBetween('qualified_at', [$start, $end])
                ->orderBy('mobile_opportunity_status_id', 'asc')
                ->get(),
            'leads un qualified' => $user->activeMobileAssigned()
                ->where('qualified', 0)
                ->whereBetween('qualified_at', [$start, $end])
                ->orderBy('mobile_opportunity_status_id', 'asc')
                ->get(),
            'props sent' => $user->activeMobileAssigned()
                ->whereHas('proposal', function ($query) use ($start, $end) {
                    $query->whereBetween('customer_files.created_at', [$start, $end]);
                })
                ->orderBy('mobile_opportunity_status_id', 'asc')
                ->get(),
            'deal calcls done' => $user->activeMobileAssigned()
                ->where(function ($query) use ($start, $end) {
                    $query->whereHas('dealCalculator', function ($query) use ($start, $end) {
                        $query->whereBetween('customer_files.created_at', [$start, $end]);
                    })
                        ->orWhereHas('activeDealCalculator', function ($query) use ($start, $end) {
                            $query->whereBetween('deal_calculators.created_at', [$start, $end]);
                        });
                })
                ->orderBy('mobile_opportunity_status_id', 'asc')
                ->get(),
            'pos sent out' => $user->activeMobileAssigned()
                ->whereHas('purchaseOrder', function ($query) use ($start, $end) {
                    $query->whereBetween('customer_files.created_at', [$start, $end]);
                })
                ->orderBy('mobile_opportunity_status_id', 'asc')
                ->get(),
        ]);
    }
}
