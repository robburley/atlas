@extends('layout.master')

@section('title')
    Reports &middot; {{ $name }} &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file-text-o"></i>
                {{ $name }} Report
            </h2>
        </div>
    </div>

    <br>

    @if(auth()->user()->isAdmin())
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default border-top-info">
                    <div class="panel-body">
                    </div>
                    {!! Form::open(['method'=> 'get','class' => 'form-inline']) !!}
                    <div class="row">
                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('start', 'Created From', ['class' => 'control-label']) !!}

                                {!! Form::text('start', request()->get('start') ?? $start->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('end', 'Created To', ['class' => 'control-label']) !!}

                                {!! Form::text('end', request()->get('end') ?? $end->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4 p-b-10">
                            <button type="submit" class="btn btn-success btn-block">Filter</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">

                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="col-sm-2">Customer</th>
                                    <th>Telephone</th>
                                    <th>Networks</th>
                                    <th>Users</th>
                                    <th>Appointment</th>
                                    <th>Status</th>
                                    <th>Created by</th>
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($data as $opportunity)
                                    <tr>
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

                                        <td class="v-mid">
                                            @foreach ($opportunity->networks as $network)
                                                <span class="label label-primary">{{ $network->name }}</span>
                                            @endforeach
                                        </td>

                                        <td class="v-mid">
                                            <i class="fa fa-fw fa-mobile"></i> {{ $opportunity->voice_users }}
                                            <i class="fa fa-fw fa-tablet"></i> {{ $opportunity->data_users }}
                                        </td>

                                        <td class="v-mid">
                                            @if($opportunity->appointment && ($appointment = $opportunity->appointments()->first()))
                                                {{  $appointment->time ? $appointment->time->format('d/m/Y H:i') : '--' }}
                                            @elseif($callback = $opportunity->callbacks()->incomplete()->first())
                                                {{  $callback->time->format('d/m/Y H:i') }}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        
                                        <td class="v-mid text-{{ $opportunity->status->colour }}">
                                            {{ $opportunity->status->name or '' }}
                                        </td>

                                        <td class="v-mid">{{ $opportunity->creator->name }}</td>

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
                </div>
            </div>
        </div>

    </div>

@endsection
