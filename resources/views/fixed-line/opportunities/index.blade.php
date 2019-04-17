@inject('statusHelper', 'App\Helpers\MobileOpportunityStatusHelper')

@extends('layout.master')

@section('title')
    Fixed Line Opportunity &middot &middot; Atlas
@endsection

@section('page-title')
    Fixed Line Opportunity &middot &middot; Atlas
@endsection

@section('page-description')
    Fixed Line Opportunity
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-mobile"></i>
                Fixed Line Opportunities @if(isset($status)) - {{ $status->name }} @elseif(isset($subTitle))
                    - {{ $subTitle }} @endif
            </h2>
        </div>
    </div>

    <br>

    <div class="row">
        @if(auth()->user()->hasPermission('show_all_leads_fixed_line') || auth()->user()->hasPermission('show_all_appointment_leads_fixed_line') || (isset($subTitle) && ($subTitle == 'My Qualified Leads' || $subTitle == 'Team Awaiting Bill')))
            <div class="col-sm-10">
                <div class="panel panel-default border-top-purple">
                    <div class="panel-body">
                        {!! Form::open(['method'=> 'get','class' => 'form-inline']) !!}
                        <div class="row">
                            @if((isset($status) && ($status->slug == 'awaiting-bill' || $status->slug == 'awaiting-validation')) || (isset($subTitle) && $subTitle == 'Pipeline'))
                                <div class="col-sm-4 p-b-10">
                                    <div class="form-group">
                                        {!! Form::label('created', 'Created By', ['class' => 'control-label']) !!}
                                        {!! Form::select('created', FormPopulator::leadGenUsers(), request()->get('created') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                                    </div>
                                </div>
                            @endif

                            @if((isset($status) && ($status->slug <> 'awaiting-bill' || $status->slug <> 'awaiting-validation')) || (isset($subTitle) && $subTitle == 'Pipeline') )
                                <div class="col-sm-4 p-b-10">
                                    <div class="form-group">
                                        {!! Form::label('assigned', 'Assigned To', ['class' => 'control-label']) !!}
                                        {!! Form::select('assigned', FormPopulator::assignableUsers(null, 'fixed_line'), request()->get('assigned') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                                    </div>
                                </div>
                            @endif

                            @if(!isset($status))
                                <div class="col-sm-4 p-b-10">
                                    <div class="form-group">
                                        {!! Form::label('fixed_line_opportunity_status_id', 'Status', ['class' => 'control-label']) !!}

                                        {!! Form::select('fixed_line_opportunity_status_id', FormPopulator::FixedLineStatuses() , request()->get('fixed_line_opportunity_status_id'), ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-sm-4 p-b-10">
                                <div class="form-group">
                                    {!! Form::label('created_from', 'Created From', ['class' => 'control-label']) !!}

                                    {!! Form::text('created_from', request()->get('created_from') ?? \Carbon\Carbon::now()->startOfMonth()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-sm-4 p-b-10">
                                <div class="form-group">
                                    {!! Form::label('created_to', 'Created To', ['class' => 'control-label']) !!}

                                    {!! Form::text('created_to', request()->get('created_to') ?? \Carbon\Carbon::now()->endOfDay()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                                </div>
                            </div>

                            @if(isset($subTitle) && $subTitle == 'Pipeline')
                                <div class="col-sm-4 p-b-10">
                                    <div class="form-group">
                                        {!! Form::label('no_bill', 'Bills and Requirements', ['class' => 'control-label']) !!}

                                        {!! Form::select('no_bill', [0 => 'Bills', 1 => 'Requirements'], request()->get('no_bill') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                                    </div>
                                </div>
                            @endif

                            @if(auth()->user()->hasPermission('show_all_leads_fixed_line') && auth()->user()->hasPermission('show_all_appointment_leads_fixed_line'))
                                <div class="col-sm-4 p-b-10">
                                    <div class="form-group">
                                        {!! Form::label('appointment', 'Lead Type', ['class' => 'control-label']) !!}

                                        {!! Form::select('appointment', [null => 'Both', 0 => 'Non Appointment', 1 => 'Appointment'], request()->get('appointment') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-sm-4 p-b-10">
                                <div class="form-group">
                                    {!! Form::label('appointment_from', 'Appointment From', ['class' => 'control-label']) !!}

                                    {!! Form::text('appointment_from', request()->get('appointment_from') , ['class' => 'form-control datepicker', 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-sm-4 p-b-10">
                                <div class="form-group">
                                    {!! Form::label('appointment_to', 'Appointment To', ['class' => 'control-label']) !!}

                                    {!! Form::text('appointment_to', request()->get('appointment_to') , ['class' => 'form-control datepicker', 'readonly']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 p-b-10">
                                <button type="submit" class="btn btn-success pull-right" style="">Filter</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        @endif


        @if(isset($total) || $opportunities->count() > 0)
            <div class="col-sm-2">
                <div class="panel panel-default border-top-success">
                    <div class="panel-body text-center">
                        <h4>
                            Total Leads:
                            <br>

                            {{ isset($total) ? $total : $opportunities->total()  }}
                        </h4>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-top-info">
                <div class="panel-body">
                    {!! Form::open(['url' => '/fixed-line/reassign-opportunities', 'method' => 'post']) !!}
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    @if(auth()->user()->hasPermission('awaiting_assignment_fixed_line') && isset($status) && $status->id >= $statusHelper->get('awaiting-validation')&& $status->id < $statusHelper->get('awaiting-credit-check'))
                                        <th></th>
                                    @endif
                                    <th class="col-sm-2">Customer</th>
                                    <th>Telephone</th>
                                    <th>Networks</th>
                                    <th>Users</th>
                                    @if(!isset($status))
                                        <th>Status</th>
                                    @endif
                                    <th>Callback / Appointment</th>
                                    <th>Assigned To</th>
                                    <th>Created by</th>
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($opportunities as $opportunity)
                                    <tr>
                                        @if(auth()->user()->hasPermission('awaiting_assignment_fixed_line') && isset($status) && $status->id >= $statusHelper->get('awaiting-validation')&& $status->id < $statusHelper->get('awaiting-credit-check'))
                                            <td>
                                                <label>
                                                    {!! Form::checkbox('opportunity[]', $opportunity->id, null) !!}
                                                </label>
                                            </td>
                                        @endif
                                        <td class="v-mid">
                                            @if($opportunity->qualified == 1)
                                                <i class="fa fa-fw fa-thumbs-up text-success"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="{{ $opportunity->qualified_at ? $opportunity->qualified_at->format('d/m/Y H:i') : 'NA' }}"></i>
                                            @elseif(!is_null($opportunity->qualified) && $opportunity->qualified == 0)
                                                <i class="fa fa-fw fa-thumbs-down text-danger"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="{{ $opportunity->qualified_at ? $opportunity->qualified_at->format('d/m/Y H:i') : 'NA' }}"></i>
                                            @endif

                                            @if($opportunity->appointment)
                                                <i class="fa fa-fw fa fa-calendar text-purple"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="Appointment"
                                                ></i>
                                            @endif

                                            @if(! is_null($opportunity->valid) && $opportunity->valid == 0)
                                                <i class="fa fa-fw fa fa-crosshairs text-danger"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="Sent back to lead generator"
                                                ></i>
                                            @endif


                                            @if($opportunity->hot_transfer)
                                                <i class="fa fa-fw fa fa-fire text-danger"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="Hot Transfer"
                                                ></i>
                                            @endif

                                            @if($opportunity->inactiveAssigned->count() > 0)
                                                    <i class="fa fa-fw fa fa-refresh text-info"
                                                       data-toggle="tooltip"
                                                       data-placement="top"
                                                       title="Opportunity Reassigned"
                                                    ></i>
                                            @endif

                                            <a href="/customers/{{ $opportunity->customer->id }}">
                                                {{ $opportunity->customer->company_name }}
                                            </a>
                                        </td>
                                        <td class="v-mid">
                                            {{ $opportunity->customer->telephone_number }}
                                        </td>

                                        <td class="v-mid">
                                            @foreach ($opportunity->networks as $network)
                                                <span class="label label-primary">{{ $network->name }}</span>
                                            @endforeach
                                        </td>

                                        <td class="v-mid">
                                            <i class="fa fa-fw fa-phone"></i> {{ $opportunity->lines }}
                                            <i class="fa fa-fw fa-at"></i> {{ $opportunity->broadband }}
                                        </td>

                                        @if(!isset($status))
                                            <td class="v-mid text-{{ $opportunity->status->colour }}">
                                                {{ $opportunity->status->name or '' }}
                                            </td>
                                        @endif

                                        <td class="v-mid">
                                            @if($opportunity->appointment && ($appointment = $opportunity->appointments()->first()))
                                                {{  $appointment->time ? $appointment->time->format('d/m/Y H:i') : '--' }}
                                            @elseif($callback = $opportunity->callbacks()->incomplete()->first())
                                                {{  $callback->time->format('d/m/Y H:i') }}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td class="v-mid">{{ $opportunity->activeAssigned->first()->name or 'Not Assigned' }}</td>

                                        <td class="v-mid">{{ $opportunity->creator->name }}</td>

                                        <td class="v-mid">{{ $opportunity->created_at->format('d/m/Y') }}</td>

                                        <td class="v-mid">
                                            <a href="/customers/{{ $opportunity->customer->id }}/fixed-line/opportunities/{{ $opportunity->id }}"
                                               class="btn btn-xs btn-white btn-icon">
                                                <i class="fa fa-fw fa-search"></i>
                                                <span>View</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">There are currently no Fixed line opportunities for of this
                                            status.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if(auth()->user()->hasPermission('awaiting_assignment_fixed_line') && isset($status) && $status->id >= $statusHelper->get('awaiting-validation')&& $status->id < $statusHelper->get('awaiting-credit-check'))
                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-lg-2">
                                {!! Form::select('reassign', FormPopulator::assignableUsers(null, 'fixed_line') , null , ['class' => 'form-control', 'placeholder' => 'Assign To']) !!}
                            </div>

                            <div class="col-sm-4 col-md-4 col-lg-2">
                                <button class="btn btn-block btn-warning" type="submit">(Re)Assign</button>
                            </div>
                        </div>
                    @endif

                    {!! Form::close() !!}

                    {{ $opportunities->appends([
                        'created_from' => request()->get('created_from'),
                        'created_to' => request()->get('created_to'),
                        'created' => request()->get('created'),
                        'assigned' => request()->get('assigned'),
                        'fixed_line_opportunity_status_id' => request()->get('fixed_line_opportunity_status_id'),
                    ])->links() }}
                </div>
            </div>
        </div>

    </div>

@endsection