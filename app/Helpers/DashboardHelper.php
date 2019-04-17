<?php

namespace App\Helpers;


use App\Models\User\User;

class DashboardHelper
{
    public static function getLeaderboard($start, $end)
    {
        return User::whereHas('createdMobileOpportunities', function ($query) use ($start, $end) {
            $query->where('appointment', 0)
                  ->billOrRequirements($start, $end)
                  ->ignoreUsers();
        })->get()->map(function ($user) use ($start, $end) {
            return [
                'name'  => $user->name,
                'count' => $user->createdMobileOpportunities()->billOrRequirements($start, $end)->where('appointment',
                    0)->count()
            ];
        })->sortByDesc('count');
    }

    public static function getAppointmentLeaderboard($start, $end)
    {
        return User::whereHas('createdMobileOpportunities', function ($query) use ($start, $end) {
            $query->where('appointment', 1)
                  ->billOrRequirements($start, $end)
                  ->ignoreUsers();
        })->get()->map(function ($user) use ($start, $end) {
            return [
                'name'  => $user->name,
                'count' => $user->createdMobileOpportunities()->billOrRequirements($start, $end)->where('appointment',
                    1)->count()
            ];
        })->sortByDesc('count');
    }

    public static function getFixedLineLeaderboard($start, $end)
    {
        return User::whereHas('createdFixedLineOpportunities', function ($query) use ($start, $end) {
            $query->where('appointment', 0)
                  ->billOrRequirements($start, $end)
                  ->ignoreUsers();
        })->get()->map(function ($user) use ($start, $end) {
            return [
                'name'  => $user->name,
                'count' => $user->createdFixedLineOpportunities()->billOrRequirements($start, $end)->where('appointment', 0)->count()
            ];
        })->sortByDesc('count');
    }

    public static function getFixedLineAppointmentLeaderboard($start, $end)
    {
        return User::whereHas('createdFixedLineOpportunities', function ($query) use ($start, $end) {
            $query->where('appointment', 1)
                  ->billOrRequirements($start, $end)
                  ->ignoreUsers();
        })->get()->map(function ($user) use ($start, $end) {
            return [
                'name'  => $user->name,
                'count' => $user->createdFixedLineOpportunities()->billOrRequirements($start, $end)->where('appointment', 1)->count()
            ];
        })->sortByDesc('count');
    }
}