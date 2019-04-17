@extends('layout.master')

@section('title')
    Position &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file"></i>
                Positions
                <a href="/recruitment/positions/create" class="btn btn-success pull-right">
                    New Position
                </a>
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    {!! Form::open(['method'=> 'get','class' => 'form-inline']) !!}
                    <div class="row">

                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('office_id', 'Office', ['class' => 'control-label']) !!}

                                {!! Form::select('office_id', FormPopulator::offices() , null , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('created_from', 'Created From', ['class' => 'control-label']) !!}

                                {!! Form::text('created_from', request()->get('created_from') ?? \Carbon\Carbon::now()->startOfMonth()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('created_to', 'Created To', ['class' => 'control-label']) !!}

                                {!! Form::text('created_to', request()->get('created_to') ?? \Carbon\Carbon::now()->endOfDay()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-sm-4 p-b-10">
                            <button type="submit" class="btn btn-success btn-block" style="">Filter</button>
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
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Open</th>
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($positions as $position)
                                    <tr>
                                        <td class="v-mid">
                                            {{ $position->name }}
                                        </td>

                                        <td class="v-mid">
                                            {{ $position->office->name or 'No Office'}}
                                        </td>

                                        <td class="v-mid">
                                            {{ $position->active ? 'Yes' : 'No'}}
                                        </td>

                                        <td class="v-mid">
                                            {{ $position->created_at->format('d/m/Y') }}
                                        </td>

                                        <td class="v-mid">
                                            <a href="/recruitment/positions/{{ $position->id }}/edit"
                                               class="btn btn-xs btn-white btn-icon">
                                                <i class="fa fa-fw fa-edit"></i>
                                                <span>Edit</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">There are currently no positions.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        {!! $positions->appends(['office_id' => request()->get('office_id'), 'created_from' => request()->get('created_from'), 'created_to' => request()->get('created_to')])->links() !!}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

