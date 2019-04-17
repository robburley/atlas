@extends('layout.master')

@section('title')
    Energy Opportunity &middot &middot; Atlas
@endsection

@section('page-title')
    Energy Opportunity &middot &middot; Atlas
@endsection

@section('page-description')
    Energy opportunity
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-flash"></i>
                Energy Opportunities @if(isset($status)) - {{ $status->name }} @elseif(isset($subTitle))
                    - {{ $subTitle }} @endif
            </h2>
        </div>
    </div>

    <br>

    @if(auth()->user()->hasPermission('show_all_leads_energy'))
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        {!! Form::open(['method'=> 'get','class' => 'form-inline']) !!}
                        <div class="row">
                            @if((isset($status) && ($status->slug == 'awaiting-bill' || $status->slug == 'awaiting-validation')) || (isset($subTitle) && $subTitle == 'Pipeline'))
                                <div class="col-sm-4 p-b-10">
                                    <div class="form-group">
                                        {!! Form::label('created', 'Created By', ['class' => 'control-label']) !!}
                                        {!! Form::select('created', FormPopulator::leadGenUsers(), request()->get('created') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                                    </div>
                                </div>
                            @endif

                            @if((isset($status) && ($status->slug <> 'awaiting-bill' || $status->slug <> 'awaiting-validation')) || (isset($subTitle) && $subTitle == 'Pipeline') )
                                <div class="col-sm-4 p-b-10">
                                    <div class="form-group">
                                        {!! Form::label('assigned', 'Assigned To', ['class' => 'control-label']) !!}
                                        {!! Form::select('assigned', FormPopulator::assignableUsers(), request()->get('assigned') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                                    </div>
                                </div>
                            @endif

                            @if(!isset($status))
                                <div class="col-sm-4 p-b-10">
                                    <div class="form-group">
                                        {!! Form::label('energy_opportunity_status_id', 'Status', ['class' => 'control-label']) !!}

                                        {!! Form::select('energy_opportunity_status_id', FormPopulator::energyStatuses() ,request()->get('energy_opportunity_status_id') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-sm-4 p-b-10">
                                <div class="form-group">
                                    {!! Form::label('created_from', 'Created From', ['class' => 'control-label']) !!}

                                    {!! Form::text('created_from', request()->get('created_from') , ['class' => 'form-control datepicker', 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-sm-4 p-b-10">
                                <div class="form-group">
                                    {!! Form::label('created_to', 'Created To', ['class' => 'control-label']) !!}

                                    {!! Form::text('created_to', request()->get('created_to') , ['class' => 'form-control datepicker', 'readonly']) !!}
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
    @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="col-sm-2">Customer</th>
                                    <th>Telephone</th>
                                    <th>Suppliers</th>
                                    @if(!isset($status))
                                        <th>Status</th>
                                    @endif
                                    <th>Callback</th>
                                    <th>Assigned To</th>
                                    <th>Created by</th>
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($opportunities as $opportunity)
                                    <tr>
                                        <td class="v-mid">
                                            @if($opportunity->qualified == 1)
                                                <i class="fa fa-fw fa-thumbs-up text-success"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="{{ $opportunity->qualified_at ? $opportunity->qualified_at->format('d/m/Y H:i') : 'NA' }}"></i>
                                            @elseif(!is_null($opportunity->qualified) && $opportunity->qualified == 0)
                                                <i class="fa fa-fw fa-thumbs-down text-danger"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="{{ $opportunity->qualified_at ? $opportunity->qualified_at->format('d/m/Y H:i') : 'NA' }}"></i>
                                            @endif
                                            <a href="/customers/{{ $opportunity->customer->id }}">
                                                {{ $opportunity->customer->company_name }}
                                            </a>
                                        </td>
                                        <td class="v-mid">
                                            {{ $opportunity->customer->telephone_number }}
                                        </td>

                                        <td class="v-mid">
                                            @foreach ($opportunity->suppliers as $supplier)
                                                <span class="label label-primary">{{ $supplier->name }}</span>
                                            @endforeach
                                        </td>

                                        @if(!isset($status))
                                            <td class="v-mid text-{{ $opportunity->status->colour }}">
                                                {{ $opportunity->status->name or '' }}
                                            </td>
                                        @endif

                                        <td class="v-mid">
                                            {{
                                            ($callback = $opportunity->callbacks()->incomplete()->first())
                                                ? $callback->time->format('d/m/Y H:i')
                                                : '--'
                                            }}
                                        </td>
                                        <td class="v-mid">{{ $opportunity->activeAssigned->first()->name or 'Not Assigned' }}</td>

                                        <td class="v-mid">{{ $opportunity->creator->name }}</td>

                                        <td class="v-mid">{{ $opportunity->created_at->format('d/m/Y') }}</td>

                                        <td class="v-mid">
                                            <a href="/customers/{{ $opportunity->customer->id }}/energy/opportunities/{{ $opportunity->id }}"
                                               class="btn btn-xs btn-white btn-icon">
                                                <i class="fa fa-fw fa-search"></i>
                                                <span>View</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">There are currently no energy opportunities for of this
                                            status.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $opportunities->appends([
                        'created_from' => request()->get('created_from'),
                        'created_to' => request()->get('created_to'),
                        'created' => request()->get('created'),
                        'assigned' => request()->get('assigned'),
                        'energy_opportunity_status_id' => request()->get('energy_opportunity_status_id'),
                    ])->links() }}
                </div>
            </div>
        </div>

    </div>

@endsection

