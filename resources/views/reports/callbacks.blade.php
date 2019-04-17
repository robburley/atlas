@extends('layout.master')

@section('title')
    Reports &middot; Callbacks &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file-text-o"></i>
                Callbacks Report
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
                            {!! Form::label('assigned', 'Assigned To', ['class' => 'control-label']) !!}
                            {!! Form::select('assigned', FormPopulator::assignableUsers(), request()->get('assigned') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 p-b-10">
                        <div class="form-group">
                            {!! Form::label('start', 'Callback From', ['class' => 'control-label']) !!}

                            {!! Form::text('start', request()->get('start') ?? \Carbon\Carbon::now()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-sm-4 p-b-10">
                        <div class="form-group">
                            {!! Form::label('end', 'Callback To', ['class' => 'control-label']) !!}

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
                                    <th>Assigned To</th>
                                    <th>Status</th>
                                    <th>Callback</th>
                                    <th>GP</th>
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($opportunities as $opportunity)
                                    <tr>

                                        <td class="v-mid">
                                            {{ $opportunity->activeAssigned->first()->name or 'Not Assigned' }}
                                        </td>

                                        <td class="v-mid text-{{ $opportunity->status->colour }}">
                                            {{ $opportunity->status->name or '' }}
                                        </td>

                                        <td class="v-mid">
                                            {{ ($callback = $opportunity->last_callback) ? $callback->format('d/m/Y H:i') : '--' }}
                                        </td>

                                        <td class="v-mid">
                                            £{{ $opportunity->gp }}
                                        </td>


                                        <td class="v-mid">{{ $opportunity->created_at->format('d/m/Y') }}</td>

                                        <td class="v-mid">
                                            <a href="/customers/{{ $opportunity->customer->id }}/mobile/opportunities/{{ $opportunity->id }}"
                                               class="btn btn-xs btn-white btn-icon">
                                                <i class="fa fa-fw fa-search"></i>
                                                <span>View</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">There are currently no mobile opportunities for of this
                                            status.
                                        </td>
                                    </tr>
                                @endforelse

                                @if(count($opportunities) > 0)
                                    <tr>
                                        <td colspan="3"></td>
                                        <td>£{{ number_format($opportunities->sum('gp'), 2) }}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
