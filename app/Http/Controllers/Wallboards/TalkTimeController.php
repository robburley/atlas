<?php

namespace App\Http\Controllers\Wallboards;


use App\Http\Controllers\Controller;
use App\Models\Dxi\DxiAgent;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\User\User;
use Carbon\Carbon;

class TalkTimeController extends Controller
{
    public $start;
    public $end;
    public $target;
    public $ignoredUsers = [
        768418, //Heather Stockdale
        755587, //Nicole Butler
        795936, //Sarah Hanlon
    ];

    public function __construct()
    {
        $this->middleware('whitelist-ip-guest');

        $this->start = Carbon::now()->startOfDay();

        $this->end = Carbon::now();

        $this->target = $this->getTarget();
    }

    public function index()
    {
        $agents = DxiAgent::whereNotIn('agent_id', $this->ignoredUsers)
                          ->where('branch', request()->get('branch', 'Nantwich'))
                          ->whereHas('logins', function ($query) {
                              return $query->where('day', $this->start);
                          })
                          ->whereHas('calls', function ($query) {
                              return $query->where('day', $this->start)
                                           ->whereBetween('disconnect', [$this->start, $this->end]);
                          })
                          ->with([
                              'logins' => function ($query) {
                                  $query->where('day', $this->start);
                              },
                              'calls'  => function ($query) {
                                  $query->where('day', $this->start)
                                        ->whereBetween('disconnect', [$this->start, $this->end])
                                        ->orderBy('answer', 'asc');
                              },
                          ])
                          ->get()
                          ->map(function ($agent) {
                              $agent->call_duration = $agent->calls->map(function ($call) {
                                  $call->actual_duration = $call->answer
                                      ? $call->disconnect->diffInSeconds($call->answer)
                                      : $call->duration;

                                  return $call;
                              })->sum('actual_duration');

                              $agent->call_duration_formatted = gmdate("H:i:s", $agent->call_duration);

                              $agent->colour = $this->getTrafficLight($agent->call_duration);

                              return $agent;
                          })->sortByDesc('call_duration');

        return view('wallboard.talk-time', [
            'agents' => $agents,
            'branch' => request()->get('branch', 'Nantwich')
        ]);
    }

    public function getTrafficLight($current)
    {
        if ($current >= $this->target[0]) {
            return 'success';
        }

        if ($current >= round($this->target[1])) {
            return 'warning';
        }

        return 'danger';
    }

    public function getTarget()
    {
        list($startTarget, $mod, $start) = $this->getTargetValues();

        return [
            $startTarget[0] + ($this->end->diffInSeconds($start) * $mod[0]),
            $startTarget[1] + ($this->end->diffInSeconds($start) * $mod[1]),
        ];
    }

    public function getTargetValues()
    {
        $targets = collect([
            [[0, 0,], [0.4, 0.32], $this->start->copy()->addHours(9 + 0)],
            [[1440, 1152], [0.4, 0.32], $this->start->copy()->addHours(9 + 1)],
            [[2880, 2304], [0.33, 0.27], $this->start->copy()->addHours(9 + 2)],
            [[4080, 3264], [0.4, 0.32], $this->start->copy()->addHours(9 + 3)],
            [[5520, 4416], [0.13, 0.107], $this->start->copy()->addHours(9 + 4)],
            [[6000, 4800], [0.4, 0.32], $this->start->copy()->addHours(9 + 5)],
            [[7440, 5952], [0.33, 0.27], $this->start->copy()->addHours(9 + 6)],
            [[8880, 6912], [0.4, 0.32], $this->start->copy()->addHours(9 + 7)],
            [[10080, 8064], [0.4, 0.32], $this->start->copy()->addHours(9 + 8)],
            [[10800, 8640], [0, 0,], $this->start->copy()->addHours(9 + 8)->addMinutes(30)],
        ]);

        return $targets->reject(function ($data, $index) {
            return !$this->end->gte($data[2]);
        })->last();
    }
}