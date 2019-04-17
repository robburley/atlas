<?php

namespace App\Http\Controllers\Wallboards;


use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\User\User;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Parent_;

class NantwichSalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('whitelist-ip-guest');
    }

    public function index()
    {
        $users = User::whereIn('id', [32, 34, 198, 68, 10])->get();

        $data = $users->map(function ($user) {
            return [
                'name'  => $user->name,
                'today' => $user->activeMobileAssigned()
                                ->whereBetween('dealt_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])
                                ->get()
                                ->pluck('gp')
                                ->sum(),
                'week'  => $user->activeMobileAssigned()
                                ->whereBetween('dealt_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                ->get()
                                ->pluck('gp')
                                ->sum(),
                'month' => $user->activeMobileAssigned()
                                ->whereBetween('dealt_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                                ->get()
                                ->pluck('gp')
                                ->sum(),
            ];
        })->sortByDesc('month');
        
        $data = $data->push([
            'name'  => 'Total',
            'today' => $data->sum('today'),
            'week'  => $data->sum('week'),
            'month' => $data->sum('month'),
        ]);

        return view('wallboard.nantwich-sales', ['data' => $data]);
    }
}