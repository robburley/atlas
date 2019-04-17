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
                            <div class="col-sm-9 p-b-10">
                                <div class="form-group">
                                    {!! Form::label('months', 'Months', ['class' => 'control-label']) !!}

                                    {!! Form::select('months', [6 => 6, 12 => 12], request()->get('months') , ['class' => 'form-control', 'readonly']) !!}
                                </div>
                            </div>

                            <div class="col-sm-3 p-b-10">
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
                <div class="panel-heading">
                    <h3 class="panel-title">Energy Meters</h3>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Site</th>
                            <th>Type</th>
                            <th>Number</th>
                            <th>Usage</th>
                            <th>Contract End Date</th>
                            <th>Created at</th>
                            @if(auth()->user()->hasPermission('read_energy'))
                                <th></th>
                            @endif
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($meters as $meter)
                            <tr>
                                <td class="v-mid">
                                    {{ $meter->site->name or ''}}
                                </td>

                                <td class="v-mid">
                                    {{ $meter->type }}
                                </td>

                                <td class="v-mid">
                                    {{ $meter->number }}
                                </td>

                                <td class="v-mid">
                                    <i class="fa fa-fw fa-sort-numeric-asc" data-toggle="tooltip" data-placement="top" title="Quantity"></i> {{ $meter->quantity }}
                                    <i class="fa fa-fw fa-sun-o" data-toggle="tooltip" data-placement="top" title="Day Rate"></i> {{ $meter->day_rate }}
                                    <i class="fa fa-fw fa-moon-o" data-toggle="tooltip" data-placement="top" title="Night Rate"></i> {{ $meter->night_rate }}
                                    <i class="fa fa-fw fa-gbp" data-toggle="tooltip" data-placement="top" title="Standing Charge"></i> {{ $meter->current_standing_charge }}
                                </td>

                                <td class="v-mid">
                                    {{ $meter->contract_end_date ? $meter->contract_end_date->format('d/m/Y') : 'Not Set' }}
                                </td>

                                <td class="v-mid">
                                    {{ $meter->created_at  ? $meter->created_at->format('d/m/Y') : 'Not Set' }}
                                </td>

                                @if(auth()->user()->hasPermission('read_energy'))
                                    <td class="v-mid">
                                        <a href="/customers/{{ $meter->customer->id }}/energy/"
                                           class="btn btn-xs btn-white btn-icon">
                                            <i class="fa fa-fw fa-search"></i>
                                            <span>View</span>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">There are currently no quotable energy meters.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection
