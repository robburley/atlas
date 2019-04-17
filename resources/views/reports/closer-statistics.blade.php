@extends('layout.master')

@section('title')
    Reports &middot; Closer Statistics &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file-text-o"></i>
                Closers Statistics
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

                            {!! Form::text('start', request()->get('start') ?? \Carbon\Carbon::now()->startOfDay()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
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
                                    <th>Leads issued</th>
                                    <th>Leads blown</th>
                                    <th>Leads qualified</th>
                                    <th>Leads un qualified</th>
                                    <th>Props sent</th>
                                    <th>Deal calcls done</th>
                                    <th>PO's sent out</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($data as $row)
                                    <tr>
                                        <td>
                                            <strong>
                                                <a href="/reports/mobile/closer-statistics/{{ $row->get('user_id') }}?start={{ request()->start }}&end={{ request()->end }}" class="btn btn-xs btn-info">
                                                    {{ $row->get('name') }}
                                                </a>
                                            </strong>
                                        </td>
                                        <th>{{ $row->get('leads issued') }}</th>
                                        <th>{{ $row->get('leads blown') }}</th>
                                        <th>{{ $row->get('leads qualified') }}</th>
                                        <th>{{ $row->get('leads un qualified') }}</th>
                                        <th>{{ $row->get('props sent') }}</th>
                                        <th>{{ $row->get('deal calcls done') }}</th>
                                        <th>{{ $row->get('pos sent out') }}</th>
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
