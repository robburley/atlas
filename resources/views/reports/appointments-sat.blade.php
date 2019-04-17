@extends('layout.master')

@section('title')
    Reports &middot; Appointments to be Sat &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file-text-o"></i>
                Appointments to be Sat Report
            </h2>
        </div>
    </div>

    <br>

    <div class="row hidden-print">
        <div class="col-sm-12">
            <div class="panel panel-default border-top-info">
                <div class="panel-body">
                    {!! Form::open(['method'=> 'get','class' => 'form-inline']) !!}
                    <div class="row">
                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('start', 'Appointment From', ['class' => 'control-label']) !!}

                                {!! Form::text('start', request()->get('start') ?? \Carbon\Carbon::now()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('end', 'Appointment To', ['class' => 'control-label']) !!}

                                {!! Form::text('end', request()->get('end') ?? \Carbon\Carbon::now()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
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
    </div>

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
                                    <th>Status</th>
                                    <th>Appointment</th>
                                    <th>Assigned To</th>
                                    <th>Created by</th>
                                    <th>Created at</th>
                                    <th class="hidden-print"></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($appointments as $appointment)
                                    <tr class="">
                                        <td class="v-mid">{{ $appointment->appointable->customer->company_name }}</td>
                                        <td class="v-mid">{{ $appointment->appointable->customer->telephone_number }}</td>
                                        <td class="v-mid">{{ $appointment->appointable->status->name }}</td>
                                        <td class="v-mid">{{ $appointment->time ? $appointment->time->format('d/m/Y H:i') : '--' }}</td>
                                        <td class="v-mid">{{ $appointment->appointable->activeAssigned->first()->name or 'Not Assigned' }}</td>
                                        <td class="v-mid">{{ $appointment->appointable->creator->name }}</td>
                                        <td class="v-mid">{{ $appointment->appointable->created_at->format('d/m/Y') }}</td>
                                        <td class="v-mid hidden-print">
                                            <a href="/customers/{{ $appointment->appointable->customer->id }}/mobile/opportunities/{{ $appointment->appointable->id }}"
                                               class="btn btn-xs btn-white btn-icon">
                                                <i class="fa fa-fw fa-search"></i>
                                                <span>View</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">The are no appointments in this timeframe
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
