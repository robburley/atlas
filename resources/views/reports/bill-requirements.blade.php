@extends('layout.master')

@section('title')
    Reports &middot; Bills vs Requirements &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file-text-o"></i>
                Bills vs Requirements Report
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
                            {!! Form::label('start_date', 'From', ['class' => 'control-label']) !!}

                            {!! Form::text('start_date', request()->get('start_date') ?? \Carbon\Carbon::now()->startOfMonth()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-sm-4 p-b-10">
                        <div class="form-group">
                            {!! Form::label('end_date', 'To', ['class' => 'control-label']) !!}

                            {!! Form::text('end_date', request()->get('end_date') ?? \Carbon\Carbon::now()->endOfDay()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
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
                                    <th>Period</th>
                                    <th>Total</th>
                                    <th>With Bill</th>
                                    <th>With Requirements</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $row)
                                        <tr>
                                            <td>{{ $row['name'] }}</td>
                                            <td>{{ $row['total'] }}</td>
                                            <td>{{ $row['bill'] }} ({{ $row['billPercent'] }}%)</td>
                                            <td>{{ $row['noBill'] }} ({{ $row['noBillPercent'] }}%)</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
