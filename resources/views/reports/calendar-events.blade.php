@extends('layout.master')

@section('title')
    Reports &middot; Lead Generator Calendar Events &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file-text-o"></i>
                Lead Generator Calendar Events Report
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
                    <div class="col-sm-3 p-b-10">
                        <div class="form-group">
                            {!! Form::label('from', 'Date From', ['class' => 'control-label']) !!}

                            {!! Form::text('from', request()->get('from') ?? \Carbon\Carbon::now()->startOfMonth()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-sm-3 p-b-10">
                        <div class="form-group">
                            {!! Form::label('to', 'Date To', ['class' => 'control-label']) !!}

                            {!! Form::text('to', request()->get('to') ?? \Carbon\Carbon::now()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="col-sm-3 p-b-10">
                        <div class="form-group">
                            {!! Form::label('sort', 'Order By', ['class' => 'control-label']) !!}

                            {!! Form::select('sort', ['created' => 'Created', 'set' => 'Set'] , request()->get('sort') , ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-sm-3 p-b-10">
                        <button type="submit" class="btn btn-success btn-block">Filter</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
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
                                    <th>Created</th>
                                    <th>Set</th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($agents as $agent)
                                    <tr class="">
                                        <td class="v-mid">{{ $agent['lead generator name'] }}</td>
                                        <td class="v-mid">{{ $agent['created'] }}</td>
                                        <td class="v-mid">{{ $agent['set'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">The are no events in this timeframe
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

