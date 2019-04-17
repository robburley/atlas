<?php

namespace App\Http\Controllers\Wallboards;


use App\Http\Controllers\Controller;
use App\Models\Appointments\Appointment;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SunderlandAppointmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('whitelist-ip-guest');
    }

    public function index()
    {
        $start = Carbon::parse('tomorrow 8:00am');
        $end = Carbon::parse('tomorrow 8:30pm');

        while($start->isWeekend()) {
            $start->addDay();
        }

        while($end->isWeekend()) {
            $end->addDay();
        }

        $slots = new Collection();

        while ($start <= $end) {
            $slots = $slots->push($start->copy());

            $start->addMinutes(30);
        }

        $users = User::where('role_id', 5)
                     ->where('office_id', 2)
                     ->active()
                     ->get();

        $data = $users->keyBy('name')
                      ->map(function ($user) use ($slots) {
                          return $slots->map(function ($slot) use ($user) {
                              $startTime = $slot->copy()->subMinutes(59);
                              $endTime = $slot->copy()->addMinutes(29);

                              $appointments = Appointment::whereBetween('time', [$startTime, $endTime])
                                                         ->with([
                                                             'site',
                                                             'appointable.activeAssigned',
                                                             'appointable.creator'
                                                         ])
                                                         ->get();

                              foreach ($appointments as $current) {
                                  try {
                                      if ($current->appointable->activeAssigned->first()->id == $user->id) {
                                          $appointment = $current;
                                      }
                                  } catch (\Exception $e) {

                                  }
                              }

                              return collect([
                                  'slot'        => $slot->format('H:i'),
                                  'appointment' => $appointment ?? null
                              ]);
                          });
                      });

        return view('wallboard.sunderland-appointments', ['data' => $data]);

    }
}