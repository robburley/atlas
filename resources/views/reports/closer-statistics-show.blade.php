@extends('layout.master')

@section('title')
    Reports &middot; Closer Statistics &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file-text-o"></i>
                Closer Statistics for {{ $user->get('name') }}
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
                        <div class="form-group">
                            {!! Form::label('type', 'Type', ['class' => 'control-label']) !!}

                            {!! Form::select('type', $allTypes, null , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
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
                                    <th>Type</th>
                                    <th>Customer</th>
                                    <th>Telephone</th>
                                    <th>Status</th>
                                    <th>Created by</th>
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($types as $type)
                                    @foreach($user->get($type) as $opportunity)
                                        <tr>
                                            <td>{{ $type }}</td>
                                            <td>
                                                <a href="/customers/{{ $opportunity->customer->id }}">
                                                    {{ $opportunity->customer->company_name }}
                                                </a>
                                            </td>
                                            <td class="v-mid">
                                                {{ $opportunity->customer->telephone_number }}
                                            </td>
                                            <td class="v-mid text-{{ $opportunity->status->colour }}">
                                                {{ $opportunity->status->name or '' }}
                                            </td>
                                            <td class="v-mid">{{ $opportunity->creator->name }}</td>
                                            <td class="v-mid">{{ $opportunity->created_at->format('d/m/Y') }}</td>
                                            <td class="v-mid">
                                                <a href="/customers/{{ $opportunity->customer->id }}/mobile/opportunities/{{ $opportunity->id }}"
                                                   class="btn btn-xs btn-white btn-icon">
                                                    <i class="fa fa-fw fa-search"></i>
                                                    <span>View</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
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
