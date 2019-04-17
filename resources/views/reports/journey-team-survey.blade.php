@extends('layout.master')

@section('title')
    Reports &middot; Journey Team Survey &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file-text-o"></i>
                Journey Team Survey Report
            </h2>
        </div>
    </div>

    <br>

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

                            {!! Form::text('start', request()->get('start') ?? \Carbon\Carbon::now()->startOfMonth()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-sm-4 p-b-10">
                        <div class="form-group">
                            {!! Form::label('end', 'Created To', ['class' => 'control-label']) !!}

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

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Questionnaires Completed</th>
                                    <th class="text-center">Mobile</th>
                                    <th class="text-center">Fixed Line</th>
                                    <th class="text-center">Energy</th>
                                    <th class="text-center">Water</th>
                                    <th class="text-center">IT</th>
                                    <th class="text-center">Vehicle Tracking</th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($agents as $agent)
                                    <tr class="">
                                        <td class="v-mid text-center">{{ $agent['lead generator name'] }}</td>
                                        <td class="v-mid text-center">{{ $agent['total'] }}</td>
                                        <td class="v-mid text-center">{{ $agent['mobile_complete'] }}</td>
                                        <td class="v-mid text-center">{{ $agent['fixed_line_complete'] }}</td>
                                        <td class="v-mid text-center">{{ $agent['energy_complete'] }}</td>
                                        <td class="v-mid text-center">{{ $agent['water_complete'] }}</td>
                                        <td class="v-mid text-center">{{ $agent['it_complete'] }}</td>
                                        <td class="v-mid text-center">{{ $agent['vehicle_tracking_complete'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">The are no surveys in this timeframe
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

