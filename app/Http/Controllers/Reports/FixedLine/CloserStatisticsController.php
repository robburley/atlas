<?php

namespace App\Http\Controllers\Reports\FixedLine;


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
                'user_id'            => $user->id,
                'name'               => $user->name,
                'leads issued'       => $user->activeFixedLineAssigned()
                                             ->wherePivot('created_at', '<=', $end)
                                             ->wherePivot('created_at', '>=', $start)
                                             ->count(),
                'leads blown'        => $user->activeFixedLineAssigned()
                                             ->whereBetween('status_updated_at', [$start, $end])
                                             ->whereHas('status', function ($query) {
                                                 $query->where('fixed_line_opportunity_statuses.blown', 1);
                                             })
                                             ->count(),
                'leads qualified'    => $user->activeFixedLineAssigned()
                                             ->where('qualified', 1)
                                             ->whereBetween('qualified_at', [$start, $end])
                                             ->count(),
                'leads un qualified' => $user->activeFixedLineAssigned()
                                             ->where('qualified', 0)
                                             ->whereBetween('qualified_at', [$start, $end])
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
            ''                   => 'Please Select',
            'leads issued'       => 'leads issued',
            'leads blown'        => 'leads blown',
            'leads qualified'    => 'leads qualified',
            'leads un qualified' => 'leads un qualified',
        ]);

        $types = $request->has('type')
            ? $allTypes->only($request->get('type'))
            : $allTypes->except('');

        return view('reports.closer-statistics-show', [
            'user'     => $user,
            'types'    => $types,
            'allTypes' => $allTypes,
        ]);
    }

    public function getUserData($user, $start, $end)
    {
        return collect([
            'name'               => $user->name,
            'leads issued'       => $user->fixedLineAssigned()
                                         ->wherePivot('created_at', '<=', $end)
                                         ->wherePivot('created_at', '>=', $start)
                                         ->orderBy('fixed_line_opportunity_status_id', 'asc')
                                         ->get(),
            'leads blown'        => $user->activeFixedLineAssigned()
                                         ->whereBetween('status_updated_at', [$start, $end])
                                         ->whereHas('status', function ($query) {
                                             $query->where('fixed_line_opportunity_statuses.blown', 1);
                                         })
                                         ->orderBy('fixed_line_opportunity_status_id', 'asc')
                                         ->get(),
            'leads qualified'    => $user->activeFixedLineAssigned()
                                         ->where('qualified', 1)
                                         ->whereBetween('qualified_at', [$start, $end])
                                         ->orderBy('fixed_line_opportunity_status_id', 'asc')
                                         ->get(),
            'leads un qualified' => $user->activeFixedLineAssigned()
                                         ->where('qualified', 0)
                                         ->whereBetween('qualified_at', [$start, $end])
                                         ->orderBy('fixed_line_opportunity_status_id', 'asc')
                                         ->get(),
        ]);
    }
}
