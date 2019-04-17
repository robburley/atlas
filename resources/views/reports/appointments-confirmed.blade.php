@inject('formPopulator', 'App\Helpers\FormPopulator')
@extends('layout.master')

@section('title')
    Reports &middot; Appointment Booking &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file-text-o"></i>
                Appointment Booking Report
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
                            {!! Form::label('start', 'From', ['class' => 'control-label']) !!}

                            {!! Form::text('start', request()->get('start') ?? \Carbon\Carbon::now()->startOfDay()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-sm-4 p-b-10">
                        <div class="form-group">
                            {!! Form::label('end', 'To', ['class' => 'control-label']) !!}

                            {!! Form::text('end', request()->get('end') ?? \Carbon\Carbon::now()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-sm-4 p-b-10">
                        <div class="form-group">
                            {!! Form::label('office_id', 'Office', ['class' => 'control-label']) !!}

                            {!! Form::select('office_id', $formPopulator->offices(), request()->get('office_id') , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 col-sm-offset-10 p-b-10">
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
                                    <th>Lead Generator Name</th>
                                    <th>Appointments Created</th>
                                    <th>Appointments Confirmed</th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($agents as $agent)
                                    <tr class="">
                                        <td class="v-mid">{{ $agent['lead generator name'] }}</td>
                                        <td class="v-mid">{{ $agent['appointments created'] }}</td>
                                        <td class="v-mid">{{ $agent['appointments confirmed'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">The are no opportunities in this time frame
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

