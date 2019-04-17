@extends('layout.master')

@section('title')
    Notifications &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-bell-o"></i>
                Notifications
            </h2>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-top-purple">
                <div class="panel-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="col-sm-2">Date</th>
                                    <th>Notification</th>
                                    <th>Sender</th>
                                    <th>Read</th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse (auth()->user()->getAllNotifications() as $notification)
                                    <tr class="@if(! $notification->isRead()) text-warning @endif">
                                        <td class="v-mid">
                                            {{ $notification->created_at->format('d/m/Y H:i') }}
                                        </td>

                                        <td class="v-mid">
                                            {{ $notification->subject }}
                                        </td>

                                        <td class="v-mid">
                                            {{ $notification->sender->name or 'Unknown' }}
                                        </td>

                                        <td class="v-mid">
                                            <a href="/user/notifications/{{ $notification->id }}"
                                               class="btn btn-xs btn-white btn-icon">
                                                <i class="fa fa-fw fa-search"></i>
                                                <span>View</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">There are currently no notifications.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ auth()->user()->getAllNotifications()->render() }}
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
@endsection
