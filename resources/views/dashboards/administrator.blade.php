@extends('layout.master')

@section('title')
    Atlas
@endsection

@section('content')
    <div class="page-title ">
        <div class="title-env">
            <h1 class="title">Admin Dashboard</h1>
            <p class="description">Day Overview</p>
        </div>
        @if(auth()->user()->isInRoles(['Closer', 'Support Staff', 'Admin', 'Field Sales Rep']) && (auth()->user()->needsAdobeSignAccessToken() || auth()->user()->needsAdobeSignAccessTokenRefresh()))
            <div class="pull-right p-r-30">
                <a href="/oauth2/adobe-sign" class="btn btn-info m-t-5">Log In to Adobe Sign</a>
            </div>
        @endif
    </div>

    <calendar user_id="{{ auth()->user()->id }}"></calendar>


    <div class="row">
        {{--Mobile --}}
        @if(auth()->user()->hasPermission('show_all_leads_mobile'))
            <div class="col-sm-6">
                <div class="panel panel-default border-top-info">
                    <div class="panel-heading">Mobile Opportunities</div>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-mobile text-info fa-3x p-r-10"></i>
                                    Opportunities Created
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $opportunities ?? 0 }}</h4>
                            </td>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-file text-success p-r-10"></i>
                                    Bills Today
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $hasBillToday ?? 0 }}</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-thumbs-up text-success p-r-10"></i>
                                    Qualified Today
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $qualifiedOpportunities ?? 0 }}</h4>

                            </td>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-thumbs-up text-warning p-r-10"></i>
                                    Requirements Today
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $hasNoBillToday ?? 0 }}</h4>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-thumbs-down text-danger p-r-10"></i>
                                    Not Qualified Today
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $notQualifiedOpportunities ?? 0 }}</h4>
                            </td>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-phone text-danger p-r-10"></i>
                                    Hot Transfers Today
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $hotTransfersToday ?? 0 }}</h4>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{--Mobile Appointments--}}
        @if(auth()->user()->hasPermission('show_all_appointment_leads_mobile'))
            <div class="col-sm-6">
                <div class="panel panel-default border-top-purple">
                    <div class="panel-heading">Mobile Appointments</div>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-calendar text-purple p-r-10"></i>
                                    Appointments Created
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $appointmentOpportunities ?? 0 }}</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-thumbs-up text-success p-r-10"></i>
                                    Confirmed Today
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $appointmentQualifiedOpportunities ?? 0 }}</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-thumbs-down text-danger p-r-10"></i>
                                    Not Confirmed Today
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $appointmentNotQualifiedOpportunities ?? 0 }}</h4>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        @if(auth()->user()->hasPermission('show_all_leads_fixed_line'))
            {{--Fixed Line --}}
            <div class="col-sm-6">
                <div class="panel panel-default border-top-danger">
                    <div class="panel-heading">Fixed line Opportunities</div>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-mobile text-info fa-3x p-r-10"></i>
                                    Opportunities Created
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $fixedLineOpportunities ?? 0 }}</h4>
                            </td>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-file text-success p-r-10"></i>
                                    Bills Today
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $fixedLineHasBillToday ?? 0 }}</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-thumbs-up text-success p-r-10"></i>
                                    Qualified Today
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $fixedLineQualifiedOpportunities ?? 0 }}</h4>

                            </td>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-thumbs-up text-warning p-r-10"></i>
                                    Requirements Today
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $fixedLineHasNoBillToday ?? 0 }}</h4>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-thumbs-down text-danger p-r-10"></i>
                                    Not Qualified Today
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $fixedLineNotQualifiedOpportunities ?? 0 }}</h4>
                            </td>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-phone text-danger p-r-10"></i>
                                    Hot Transfers Today
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $fixedLineHotTransfersToday ?? 0 }}</h4>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{--Fixed Line Appointments--}}
            <div class="col-sm-6">
                <div class="panel panel-default border-top-warning">
                    <div class="panel-heading">Fixed Line Appointments</div>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-calendar text-purple p-r-10"></i>
                                    Appointments Created
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $fixedLineAppointmentOpportunities ?? 0 }}</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-thumbs-up text-success p-r-10"></i>
                                    Confirmed Today
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $fixedLineAppointmentQualifiedOpportunities ?? 0 }}</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4 class="text-dark">
                                    <i class="fa fa-fw fa-thumbs-down text-danger p-r-10"></i>
                                    Not Confirmed Today
                                </h4>
                            </td>
                            <td>
                                <h4 class="text-dark">{{ $fixedLineAppointmentNotQualifiedOpportunities ?? 0 }}</h4>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    {{--Leader Boards--}}
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default border-top-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Today's Mobile Opportunity Leaderboard</h3>
                    <div class="panel-options">
                        <a href="#" data-toggle="panel" class="">
                            <span class="collapse-icon">–</span>
                            <span class="expand-icon">+</span>
                        </a>
                    </div>
                </div>
                <div class="panel-body">

                    <ul class="list-group">
                        @forelse($leaderBoard as $user)
                            <li class="list-group-item">
                                <span class="badge">{{ $user['count'] }}</span>

                                {{ $loop->iteration }}. {{ $user['name'] }}
                            </li>
                        @empty
                            <li class="list-group-item">
                                No Leads today
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        @if(auth()->user()->hasPermission('show_all_appointment_leads_mobile'))
            <div class="col-sm-6">
                <div class="panel panel-default border-top-purple">
                    <div class="panel-heading">
                        <h3 class="panel-title">Today's Mobile Appointment Leaderboard</h3>

                        <div class="panel-options">
                            <a href="#" data-toggle="panel" class="">
                                <span class="collapse-icon">–</span>
                                <span class="expand-icon">+</span>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">

                        <ul class="list-group">
                            @forelse($appointmentLeaderBoard as $user)
                                <li class="list-group-item">
                                    <span class="badge">{{ $user['count'] }}</span>

                                    {{ $loop->iteration }}. {{ $user['name'] }}
                                </li>
                            @empty
                                <li class="list-group-item">
                                    No Leads today
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if(auth()->user()->hasPermission('show_all_leads_fixed_line'))
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default border-top-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Today's Fixed Line Opportunity Leaderboard</h3>
                        <div class="panel-options">
                            <a href="#" data-toggle="panel" class="">
                                <span class="collapse-icon">–</span>
                                <span class="expand-icon">+</span>
                            </a>
                        </div>
                    </div>

                    <div class="panel-body">
                        <ul class="list-group">
                            @forelse($fixedLineLeaderBoard as $user)
                                <li class="list-group-item">
                                    <span class="badge">{{ $user['count'] }}</span>

                                    {{ $loop->iteration }}. {{ $user['name'] }}
                                </li>
                            @empty
                                <li class="list-group-item">
                                    No Leads today
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default border-top-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">Today's Fixed Line Appointment Leaderboard</h3>

                        <div class="panel-options">
                            <a href="#" data-toggle="panel" class="">
                                <span class="collapse-icon">–</span>
                                <span class="expand-icon">+</span>
                            </a>
                        </div>
                    </div>

                    <div class="panel-body">
                        <ul class="list-group">
                            @forelse($fixedLineAppointmentLeaderBoard as $user)
                                <li class="list-group-item">
                                    <span class="badge">{{ $user['count'] }}</span>

                                    {{ $loop->iteration }}. {{ $user['name'] }}
                                </li>
                            @empty
                                <li class="list-group-item">
                                    No Leads today
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{--Callbacks--}}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-top-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Callbacks</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            @foreach($callbacks->chunk(10) as $chunk)
                                @forelse($chunk as $callback)
                                    <p>
                                        {{ $callback->time->format('d/m/Y H:i') }} |
                                        <a href="{{ $callback->opportunity->path() }}">
                                            {{ $callback->opportunity->customer->company_name }}
                                            - {{ $callback->assignedUser->name }}
                                        </a>
                                        | {{ $callback->opportunity->customer->telephone_number }}
                                        <span class="pull-right">
                                            <a href="{{ $callback->opportunity->path("callbacks/$callback->id/edit") }}">
                                                <i class="fa fa-fw fa-clock-o text-info" title="Rearrange"></i>
                                            </a>

                                            <a href="{{ $callback->opportunity->path("callbacks/$callback->id/destroy") }}">
                                                <i class="fa fa-fw fa-check text-success" title="Complete"></i>
                                            </a>
                                        </span>
                                    </p>
                                @empty
                                    <p>No Callbacks.</p>
                                @endforelse
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
