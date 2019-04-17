<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Models\User\UserNotification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    /**
     * Create a new dashboard controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('notifications.index');
    }

    public function show(UserNotification $notification)
    {
        return view('notifications.show', [
            'notification' => $notification
        ]);
    }


    public function update(UserNotification $notification, Request $request)
    {
        $notification->update($request->all());

        alert()->success('Notification has been read');

        return redirect('user/notifications');
    }
}
