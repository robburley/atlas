@inject('statusHelper', 'App\Helpers\MobileOpportunityStatusHelper')

@extends('layout.master')

@section('title')
    Mobile Opportunity &middot &middot; Atlas
@endsection

@section('page-title')
    Mobile Opportunity &middot &middot; Atlas
@endsection

@section('page-description')
    Mobile opportunity
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-mobile"></i>
                Mobile Opportunities @if(isset($status)) - {{ $status->name }} @elseif(isset($subTitle))
                    - {{ $subTitle }} @endif
            </h2>
        </div>
    </div>

    <br>

    @include('mobile.opportunities.partials.filters')

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-top-info">
                <div class="panel-body">
                    {!! Form::open(['url' => '/mobile/reassign-opportunities', 'method' => 'post']) !!}
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    @if((auth()->user()->hasPermission('awaiting_assignment_mobile') && isset($status) && $status->id >= $statusHelper->get('awaiting-validation') && $status->id < $statusHelper->get('awaiting-credit-check')) || isset($subTitle) && $subTitle == 'Pipeline')
                                        <th></th>
                                    @endif
                                    <th class="col-sm-2">Customer</th>
                                    <th>Telephone</th>
                                    <th class="visible-lg">Users</th>
                                    @if(!isset($status))
                                        <th>Status</th>
                                    @endif
                                    <th>Callback / Appointment</th>
                                    <th>Assigned To</th>
                                    <th>Created by</th>
                                    @if(auth()->user()->isAdmin())
                                        <th>GP</th>
                                    @endif
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($opportunities as $opportunity)
                                    <tr>
                                        @if((auth()->user()->hasPermission('awaiting_assignment_mobile') && isset($status) && $status->id >= $statusHelper->get('awaiting-validation')&& $status->id < $statusHelper->get('awaiting-credit-check')) || isset($subTitle) && $subTitle == 'Pipeline')
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

                                            @if($opportunity->mobileBills->count() > 0)
                                                <i class="fa fa-fw fa fa-file text-warning"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="Has a bill attached"
                                                ></i>
                                            @endif

                                            <a href="/customers/{{ $opportunity->customer->id }}">
                                                {{ $opportunity->customer->company_name }}
                                            </a>
                                        </td>

                                        <td class="v-mid">
                                            {{ $opportunity->customer->telephone_number }}
                                        </td>

                                        <td class="visible-lg v-mid">
                                            <i class="fa fa-fw fa-mobile"></i> {{ $opportunity->voice_users }}
                                            <i class="fa fa-fw fa-tablet"></i> {{ $opportunity->data_users }}
                                        </td>

                                        @if(!isset($status))
                                            <td class="v-mid text-{{ $opportunity->status->colour }}">
                                                {{ $opportunity->status->name or '' }}
                                            </td>
                                        @endif

                                        <td class="v-mid">
                                            @if($opportunity->appointment && ($appointment = $opportunity->appointments->first()))
                                                {{  $appointment->time ? $appointment->time->format('d/m/Y H:i') : '--' }}
                                            @elseif($callback = $opportunity->incompleteCallbacks->first())
                                                {{  $callback->time->format('d/m/Y H:i') }}
                                            @else
                                                --
                                            @endif
                                        </td>

                                        <td class="v-mid">{{ $opportunity->activeAssigned->first()->name or 'Not Assigned' }}</td>

                                        <td class="v-mid">{{ $opportunity->creator->name }}</td>

                                        @if(auth()->user()->isAdmin())
                                            <td class="v-mid">£{{ number_format($opportunity->gp, 2) }}</td>
                                        @endif

                                        <td class="v-mid">{{ $opportunity->created_at->format('d/m/Y') }}</td>

                                        <td class="v-mid">
                                            <a href="/customers/{{ $opportunity->customer->id }}/mobile/opportunities/{{ $opportunity->id }}"
                                               class="btn btn-xs btn-white btn-icon">
                                                <i class="fa fa-fw fa-search"></i>
                                                <span>View</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">There are currently no mobile opportunities for of this
                                            status.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if((auth()->user()->hasPermission('awaiting_assignment_mobile') && isset($status) && $status->id >= $statusHelper->get('awaiting-validation')&& $status->id < $statusHelper->get('awaiting-credit-check')) || isset($subTitle) && $subTitle == 'Pipeline')
                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-lg-2">
                                {!! Form::select('reassign', FormPopulator::assignableUsers() , null , ['class' => 'form-control', 'placeholder' => 'Assign To']) !!}
                            </div>

                            <div class="col-sm-4 col-md-4 col-lg-2">
                                <button class="btn btn-block btn-warning" type="submit">(Re)Assign</button>
                            </div>
                        </div>
                    @endif

                    {!! Form::close() !!}

                    {{ $opportunities->appends([
                        'created' => request()->get('created'),
                        'assigned' => request()->get('assigned'),
                        'office' => request()->get('office'),
                        'no_bill' => request()->get('no_bill'),
                        'appointment' => request()->get('appointment'),
                        'network' => request()->get('network'),
                        'created_from' => request()->get('created_from'),
                        'created_to' => request()->get('created_to'),
                        'appointment_from' => request()->get('appointment_from'),
                        'appointment_to' => request()->get('appointment_to'),
                        'dealt_from' => request()->get('dealt_from'),
                        'dealt_to' => request()->get('dealt_to'),
                        'blown' => request()->get('blown'),
                    ])->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection