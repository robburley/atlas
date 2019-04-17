@extends('layout.master')

@section('title')
    Reports &middot; Closers &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file-text-o"></i>
                Closers Report
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
                                    <th>Name</th>
                                    <th>Issued</th>
                                    <th>Active <br>Issued</th>
                                    <th>Awaiting <br>Qualification</th>
                                    <th>Awaiting <br>Callback</th>
                                    <th>Qualified</th>
                                    <th>Not <br>Qualified</th>
                                    <th>Dealt</th>
                                    <th>Passed</th>
                                    <th>Blown</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($data as $row)
                                    <tr>
                                        <td>
                                            {{ $row->get('name') }}
                                        </td>
                                        <td>
                                            {{ $row->get('Issued') }}
                                        </td>
                                        <td>
                                            {{ $row->get('Active Issued') }}<br>
                                            <small>({{ $row->get('Active Issued Percent') }})</small>
                                        </td>
                                        <td>
                                            {{ $row->get('Awaiting Qualification') }}<br>
                                            <small>({{ $row->get('Awaiting Qualification Percent') }})</small>
                                        </td>
                                        <td>
                                            {{ $row->get('Awaiting Callback') }}<br>
                                            <small>({{ $row->get('Awaiting Callback Percent') }})</small>
                                        </td>
                                        <td>
                                            {{ $row->get('Qualified') }}<br>
                                            <small>({{ $row->get('Qualified Percent') }})</small>
                                        </td>
                                        <td>
                                            {{ $row->get('Not Qualified') }}<br>
                                            <small>({{ $row->get('Not Qualified Percent') }})</small>
                                        </td>
                                        <td>
                                            {{ $row->get('Dealt') }}<br>
                                            <small>({{ $row->get('Dealt Percent') }})</small>
                                        </td>
                                        <td>
                                            {{ $row->get('Passed') }}<br>
                                            <small>({{ $row->get('Passed Percent') }})</small>
                                        </td>
                                        <td>
                                            {{ $row->get('Blown') }}<br>
                                            <small>({{ $row->get('Blown Percent') }})</small>
                                        </td>
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
