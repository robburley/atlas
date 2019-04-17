

<li class="dropdown hover-line">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa-bell-o"></i>

        @if ($notifications->unreadCount())
            <span class="badge badge-purple">{{ $notifications->unreadCount() }}</span>
        @endif
    </a>

    <ul class="dropdown-menu notifications">
        <li class="top">
            <p class="small">
                You have <strong>{{ $notifications->unreadCount() }}</strong> new {{ str_plural('notification', $notifications->unreadCount()) }}
            </p>
        </li>

        <li>
            <ul class="dropdown-menu-list list-unstyled ps-scrollbar">
                @foreach ($notifications->getLatestNotifications() as $notification)
                    <li class="active">
                        <a href="/user/notifications/{{ $notification->id }}">
                            <i class="fa-user"></i>

                            <span class="line {{ $notification->read ? '' : 'text-bold' }}">
                                {{ $notification->subject }}
                            </span>

                            <span class="line small time">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>

        <li class="external">
            <a href="/user/notifications">
                <span>View all notifications</span>
                <i class="fa fa-fw fa-arrow-right"></i>
            </a>
        </li>
    </ul>
</li>
