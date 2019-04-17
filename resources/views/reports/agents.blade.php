@inject('formPopulator', 'App\Helpers\FormPopulator')
@extends('layout.master')

@section('title')
    Agents &middot; Closers &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file-text-o"></i>
                Agents Report
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

                                {!! Form::select('office_id', [null => 'All'] + $formPopulator->offices()->toArray(), request()->get('office_id') , ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3 p-b-10 pull-right">
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
                        <table class="table" id="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Leads</th>
                                <th>Qualified</th>
                                <th>Not Qualified</th>
                                <th>Pending Qualification</th>
                                <th>Deals</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($data as $row)
                                <tr>
                                    <td>
                                        {{ $row->get('name') }}
                                    </td>
                                    <td>
                                        {{ $row->get('leads') }}
                                    </td>
                                    <td>
                                        {{ $row->get('qualified') }}
                                    </td>
                                    <td>
                                        {{ $row->get('not-qualified') }}
                                    </td>
                                    <td>
                                        {{ $row->get('pending-qualification') }}
                                    </td>
                                    <td>
                                        {{ $row->get('deals') }}
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

@endsection

@section('scripts')
    @parent
    <script src="{{ asset('https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#table').DataTable({
                paging: false,
                'order': [5, 'desc'],
            })

            $('.table-wrapper').find('label').addClass('control-label')
            $('.table-wrapper').find('input[type=search]').addClass('form-control')
        })
    </script>
@endsection
