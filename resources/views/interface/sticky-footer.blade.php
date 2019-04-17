@inject('notifications', 'App\Services\UserNotificationsService')
@inject('upcomingEvents', 'App\Services\UserEventService')

<div class="footer-sticked-chat">
    <ul class="chat-conversations list-unstyled">
        <li id="events-window" class="">
            <a class="chat-user clickable" id="events-closed">
                Todays Events
            </a>
            @if($upcomingEvents->countUpcomingEvents())
                <span class="badge badge-black">{{ $upcomingEvents->countUpcomingEvents() }}</span>
            @endif

            <div class="conversation-window">
                <a class="chat-user clickable" id="events-open">
                    <span class="close">×</span>
                    Todays Events
                </a>
                <ul class="conversation-messages ps-scrollbar ps-scroll-down ps-container ps-active-y m-h-280">
                    @forelse ($upcomingEvents->getUpcomingEvents() as $event)
                        <li class="time">{{ $event->date_time->diffForHumans() }}</li>
                        <li>
                            <div class="user-info">
                                {{ $event->date_time->format('H:i') }}
                            </div>

                            <div class="message-entry">
                                {{ $event->title }}
                            </div>
                        </li>
                    @empty
                        <li class="time">No events today</li>
                    @endforelse

                    <div class="ps-scrollbar-x-rail in-scrolling" style="left: 0px; bottom: 3px;">
                        <div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps-scrollbar-y-rail in-scrolling" style="top: 0px; height: 248px; right: 2px;">
                        <div class="ps-scrollbar-y" style="top: 0px; height: 113px;"></div>
                    </div>
                </ul>

                <div class="chat-form" style="margin-bottom: -10px;">
                    <a href="/" class="btn btn-block btn-primary">
                        Go to Calendar
                        <i class="fa fa-fw fa-arrow-right pull-right"></i>
                    </a>

                </div>
            </div>
        </li>

        <li id="notifications-window" class="">
            <a class="chat-user notification clickable" id="notifications-closed">
                Notifications
            </a>
            @if($notifications->unreadCount())
                <span class="badge badge-black">{{ $notifications->unreadCount() }}</span>
            @endif

            <div class="conversation-window">
                <a class="chat-user notification clickable" id="notifications-open">
                    <span class="close">×</span>
                    Notifications
                </a>

                <ul class="conversation-messages ps-scrollbar ps-scroll-down ps-container ps-active-y m-h-280">
                    @forelse ($notifications->getLatestNotifications() as $notification)
                        <li class="time">{{ $notification->created_at->diffForHumans() }}</li>
                        <li>

                            <div class="message-entry">
                                <p>{{ $notification->subject }}</p>
                            </div>
                            <div class="user-info">
                                <a href="/user/notifications/{{ $notification->id }}" class="btn btn-white">
                                    <i class="fa fa-search" title="View"></i>
                                </a>
                            </div>
                        </li>
                    @empty
                        <li class="time">No unread notification</li>
                    @endforelse

                    <div class="ps-scrollbar-x-rail in-scrolling" style="left: 0px; bottom: 3px;">
                        <div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps-scrollbar-y-rail in-scrolling" style="top: 0px; height: 248px; right: 2px;">
                        <div class="ps-scrollbar-y" style="top: 0px; height: 113px;"></div>
                    </div>
                </ul>
                <div class="chat-form" style="margin-bottom: -10px;">
                    <a href="/user/notifications/" class="btn btn-block btn-primary">
                        View All
                        <i class="fa fa-fw fa-arrow-right pull-right"></i>
                    </a>

                </div>
            </div>
        </li>
    </ul>
</div>