@extends('layout.master')

@section('title')
    Branch Profitability &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file-text-o"></i>
                Branch Profitability
            </h2>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-top-info">
                <div class="panel-body">
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
                            <div class="form-group">
                                {!! Form::label('office_id', 'Office', ['class' => 'control-label']) !!}

                                {!! Form::select('office_id', ['all' => 'All'] +FormPopulator::offices()->toArray(), request()->get('office_id') ?? 1, ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
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
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-wrapper">
                        <div>
                            <table class="table" id="profitability-table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Bills</th>
                                    <th>Requirements</th>
                                    <th>Total</th>
                                    <th>Qualified</th>
                                    <th>Not Qualified</th>
                                    <th>Deals</th>
                                    <th class="text-right" data-class-name="priority">GP</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($agents as $agent)
                                    <tr class="@if(!$agent['active']) active @endif">
                                        <td>{{ $agent['name'] }}</td>
                                        <td>{{ $agent['bills'] }}</td>
                                        <td>{{ $agent['requirements'] }}</td>
                                        <td>{{ $agent['total'] }}</td>
                                        <td>{{ $agent['qualified'] }}</td>
                                        <td>{{ $agent['not-qualified'] }}</td>
                                        <td>{{ $agent['deals'] }}</td>
                                        <td class="text-right">£{{ number_format($agent['gp'], 2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>

                                <tr>
                                    <th>Totals</th>
                                    <th>{{ $agents->sum('bills') }}</th>
                                    <th>{{ $agents->sum('requirements') }}</th>
                                    <th>{{ $agents->sum('total') }}</th>
                                    <th>{{ $agents->sum('qualified') }}</th>
                                    <th>{{ $agents->sum('not-qualified') }}</th>
                                    <th>{{ $agents->sum('deals') }}</th>
                                    <th class="text-right">£{{ number_format($agents->sum('gp'), 2) }}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    @parent
    <script src="{{ asset('https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#profitability-table').DataTable({
                paging: false,
                'order': [7, 'desc'],
            })

            $('.table-wrapper').find('label').addClass('control-label')
            $('.table-wrapper').find('input[type=search]').addClass('form-control')
        })
    </script>
@endsection
