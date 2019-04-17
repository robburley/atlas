<?php

namespace App\Services;

class UserNotificationsService
{
    public $LatestNotifications;
    public $unreadCount;

    public function __construct()
    {
        $this->LatestNotifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->where('read', false)->get();

        $this->unreadCount = auth()->user()->notifications()->where('read', false)->count();
    }


    public function getLatestNotifications()
    {
        return $this->LatestNotifications;
    }

    public function unreadCount()
    {
        return $this->unreadCount;
    }

}
