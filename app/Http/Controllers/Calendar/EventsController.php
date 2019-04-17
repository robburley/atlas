<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Http\Requests\Calendar\EventRequest;
use App\Models\Calender\Event;
use App\Models\User\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user, Request $request)
    {

        if ($user != auth()->user() && !auth()->user()->hasPermission('view_all_calendars')) {
            abort(404);
        }

        try {
            $start = Carbon::createFromFormat('Y-m-d', request()->get('date'))->startOfDay();
            $end = (clone $start)->endOfDay();
        } catch (Exception $e) {
            $start = Carbon::now()->startOfDay();
            $end = (clone $start)->endOfDay();
        }

        $events = Event::where('user_id', $user->id)
            ->whereBetween('date_time', [$start, $end])
            ->orderBy('date_time', 'asc')
            ->with([
                'customer',
                'customer.sites',
                'customer.contacts',
            ])
            ->get();

        return $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'time' => $event->date_time ? $event->date_time->format('H:i') : null,
                'body' => nl2br(e($event->body)),
                'type' => $event->type,
                'customer' => $event->customer,
                'showContent' => false,
            ];
        });
    }

    public function store(User $user, EventRequest $request)
    {
        $user->events()->create($request->all());
    }

    public function show(User $user, Event $event)
    {
        return [
            'id' => $event->id,
            'title' => $event->title,
            'body' => $event->body,
            'type' => $event->type,
            'customer' => $event->customer,
            'date_time' => $event->date_time->format('d/m/Y H:i:00'),
        ];
    }

    public function update(User $user, Event $event, EventRequest $request)
    {
        $event->update($request->all());
    }

    public function destroy(User $user, Event $event)
    {
        $event->delete();
    }

    public function reassign(User $user, Request $request)
    {
        $user->events->each(function ($event) use ($request) {
            $event->update($request->all());
        });

        $user = User::find($request->get('user_id'));

        alert()->success('All calendar events have been assigned too ' . $user->name, 'Calendar Reassigned');

        return redirect()->back();
    }
}
