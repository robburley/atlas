<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request)
    {
        try {
            $start = Carbon::createFromFormat('Y-m-d', request()->get('start'))->startOfMonth();
            $end = (clone $start)->endOfMonth();
        } catch (Exception $e) {
            $start = Carbon::now()->startOfMonth();
            $end = (clone $start)->endOfMonth();
        }

        $today = Carbon::now();

        $previousMonth = (clone $start)->subMonth();
        $nextMonth = (clone $start)->addMonth();

        $days = [];

        for($date = (clone $start); $date->lte($end); $date->addDay()) {
            $days[] = [
                'date' => $date->format('Y-m-d')
            ];
        }

        $dayNames = collect([]);

        $endOfWeek = (clone $start)->addDays(6);

        for($date = (clone $start); $date->lte($endOfWeek); $date->addDay()) {
            $dayNames = $dayNames->push($date->format('D'));
        }

        return collect([
            'currentMonth' => [
                'name' => $start->format('M'),
                'date' => $start->format('Y-m-d'),
            ],
            'previousMonth'  => [
                'name' => $previousMonth->format('M'),
                'date' => $previousMonth->format('Y-m-d'),
            ],
            'nextMonth'  => [
                'name' => $nextMonth->format('M'),
                'date' => $nextMonth->format('Y-m-d'),
            ],
            'activeDay' => [
                'date' => $today->format('Y-m-d')
            ],
            'days' => $days,
            'dayNames' => $dayNames
        ]);
    }
}
