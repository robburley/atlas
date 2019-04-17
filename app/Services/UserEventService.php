<?php

namespace App\Services;

class UserEventService {

    public function getUpcomingEvents()
    {
        if (auth()->user()) {
            return auth()->user()->getUpcomingEvents();
        }

        return null;
    }

    public function countUpcomingEvents()
    {
        if (auth()->user()) {
            return count(auth()->user()->getUpcomingEvents());
        }

        return null;
    }

}
