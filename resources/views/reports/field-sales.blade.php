@extends('layout.master')

@section('title')
    Reports &middot; Field Sales &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file-text-o"></i>
                Field Sales Report
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
                            {!! Form::label('start', 'Qualified From', ['class' => 'control-label']) !!}

                            {!! Form::text('start', request()->get('start') ?? \Carbon\Carbon::now()->startOfMonth()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-sm-4 p-b-10">
                        <div class="form-group">
                            {!! Form::label('end', 'Qualified To', ['class' => 'control-label']) !!}

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
                                    <th>Rep Name</th>
                                    <th>Appointments Assigned</th>
                                    <th>Appointments Sat</th>
                                    <th>Sit Rate</th>
                                    <th>Deals</th>
                                    <th>Conversion</th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($agents as $agent)
                                    <tr class="">
                                        <td class="v-mid">{{ $agent['rep name'] }}</td>
                                        <td class="v-mid">{{ $agent['appointments assigned'] }}</td>
                                        <td class="v-mid">{{ $agent['appointments sat'] }}</td>
                                        <td class="v-mid">{{ $agent['sit rate'] }}</td>
                                        <td class="v-mid">{{ $agent['deals'] }}</td>
                                        <td class="v-mid">{{ $agent['conversion'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">The are no opportunities in this timeframe
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

