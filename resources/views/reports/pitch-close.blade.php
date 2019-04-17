@extends('layout.master')

@section('title')
    Reports &middot; Pitch & Close &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file-text-o"></i>
                Pitch & Close Report
            </h2>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-sm-10">
            <div class="panel panel-default border-top-info">
                <div class="panel-body">
                </div>
                {!! Form::open(['method'=> 'get','class' => 'form-inline']) !!}
                <div class="row">
                    <div class="col-sm-4 p-b-10">
                        <div class="form-group">
                            {!! Form::label('created', 'Created By', ['class' => 'control-label']) !!}
                            {!! Form::select('created', ['' => 'Please Select'] +FormPopulator::leadGenUsers(), request()->get('created') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                        </div>
                    </div>

                    <div class="col-sm-4 p-b-10">
                        <div class="form-group">
                            {!! Form::label('mobile_opportunity_status_id', 'Status', ['class' => 'control-label']) !!}

                            {!! Form::select('mobile_opportunity_status_id', FormPopulator::mobileStatuses()->prepend('Please Select') , request()->get('mobile_opportunity_status_id'), ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 p-b-10">
                        <div class="form-group">
                            {!! Form::label('start', 'Qualified From', ['class' => 'control-label']) !!}

                            {!! Form::text('start', request()->get('start') ?? \Carbon\Carbon::now()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-sm-4 p-b-10">
                        <div class="form-group">
                            {!! Form::label('end', 'Qualified To', ['class' => 'control-label']) !!}

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

        <div class="col-sm-2">
            <div class="panel panel-default border-top-success">
                <div class="panel-body text-center">
                    <h4>
                        Total Leads:
                        <br>

                        {{ $opportunities->total()  }}
                    </h4>
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
                                    <th>Created by</th>
                                    <th>Assigned To</th>
                                    <th>Created at</th>
                                    <th class="col-sm-2">Customer</th>
                                    @if(!isset($status))
                                        <th>Status</th>
                                    @endif
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($opportunities as $opportunity)
                                    <tr>
                                        <td class="v-mid">{{ $opportunity->creator->name }}</td>

                                        <td class="v-mid">{{ $opportunity->activeAssigned->first()->name or 'Not Assigned' }}</td>

                                        <td class="v-mid">{{ $opportunity->created_at->format('d/m/Y H:i') }}</td>

                                        <td class="v-mid">
                                            @if($opportunity->qualified == 1)
                                                <i class="fa fa-fw fa-thumbs-up text-success" data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="{{ $opportunity->qualified_at ? $opportunity->qualified_at->format('d/m/Y H:i') : 'NA' }}"></i>
                                            @elseif(!is_null($opportunity->qualified) && $opportunity->qualified == 0)
                                                <i class="fa fa-fw fa-thumbs-down text-danger" data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="{{ $opportunity->qualified_at ? $opportunity->qualified_at->format('d/m/Y H:i') : 'NA' }}"></i>
                                            @endif
                                            @if($opportunity->appointment)
                                                <i class="fa fa-fw fa fa-calendar text-purple"></i>
                                            @endif
                                            @if(! is_null($opportunity->valid) && $opportunity->valid == 0)
                                                <i class="fa fa-fw fa fa-crosshairs text-danger"></i>
                                            @endif
                                            <a href="/customers/{{ $opportunity->customer->id }}">
                                                {{ $opportunity->customer->company_name }}
                                            </a>
                                        </td>

                                        @if(!isset($status))
                                            <td class="v-mid text-{{ $opportunity->status->colour }}">
                                                {{ $opportunity->status->name or '' }}
                                            </td>
                                        @endif

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
                                </tbody>
                            </table>

                            {{ $opportunities->appends([
                                'start' => request()->get('start'),
                                'end' => request()->get('end'),
                                'created' => request()->get('created'),
                                'mobile_opportunity_status_id' => request()->get('mobile_opportunity_status_id'),
                            ])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
