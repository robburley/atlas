<?php

namespace App\Http\Controllers\Reports\General;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarEventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $from = Carbon::createFromFormat('d/m/Y', $request->get('from'))->startOfDay();
            $to = Carbon::createFromFormat('d/m/Y', $request->get('to'))->endOfDay();
        } catch (\Exception $e) {
            $from = Carbon::now()->startOfMonth();
            $to = Carbon::now()->endOfDay();
        }

        $sortBy = $request->has('sort')
            ? $request->get('sort')
            : 'created';

        $agents = User::where('role_id', 4)
            ->whereHas('events', function ($query) use ($from, $to) {
                $query->whereBetween('created_at', [$from, $to])
                    ->orWhereBetween('date_time', [$from, $to]);
            })
            ->with([
                'events' => function ($query) use ($from, $to) {
                    $query->whereBetween('created_at', [$from, $to])
                        ->orWhereBetween('date_time', [$from, $to]);
                }
            ])
            ->get();

        $agents = $agents->map(function ($agent) use ($from, $to) {
            return [
                'lead generator name' => $agent->name,
                'created' => $agent->events->filter(function ($event) use ($from, $to) {
                    return $event->created_at >= $from && $event->created_at <= $to;
                })->count(),
                'set' => $agent->events->filter(function ($event) use ($from, $to) {
                    return $event->date_time >= $from && $event->date_time <= $to;
                })->count()
            ];
        })->sortByDesc($sortBy);

        return view('reports.calendar-events', [
            'agents' => $agents
        ]);
    }

}
