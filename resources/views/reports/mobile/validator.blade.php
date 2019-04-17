@extends('layout.master')

@section('title')
    Reports &middot; Validator &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file-text-o"></i>
                Validator Report
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
                                {!! Form::label('start', 'Validated From', ['class' => 'control-label']) !!}

                                {!! Form::text('start', request()->get('start') ?? $start->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('end', 'Validated To', ['class' => 'control-label']) !!}

                                {!! Form::text('end', request()->get('end') ?? $end->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('office', 'Office', ['class' => 'control-label']) !!}

                                {!! Form::select('office', [null => 'All'] + FormPopulator::offices()->toArray(), request()->get('office') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-12 p-b-10">
                            <button type="submit" class="btn btn-success pull-right">Filter</button>
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
                                    <th>Validated</th>
                                    <th>Qualified (Sat)</th>
                                    <th>Dealt</th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($data as $name => $item)
                                    <tr>
                                        <td>
                                            {{ $name }}
                                        </td>

                                        <td>
                                            {{ $item['validated'] }}
                                        </td>
                                        
                                        <td>
                                            {{ $item['qualified'] }}
                                            ({{ $item['qualified_percent'] }}%)
                                        </td>
                                        
                                        <td>
                                            {{ $item['dealt'] }}
                                            ({{ $item['dealt_percent'] }}%)
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">
                                            No Data for this range
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
