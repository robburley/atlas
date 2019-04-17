@extends('customers.layout')

@section('title')
    Energy &middot; {{ $customer->company_name }} &middot; Atlas
@endsection

@section('page-title')
    {{ $customer->company_name }}
@endsection

@section('page-description')
    Energy opportunities and connections
@endsection

@section('subcontent')
    <div class="row">
        <div class="col-sm-3">
            @if(auth()->user()->hasPermission('create_energy'))
                <a href="/customers/{{ $customer->id }}/energy/opportunities/create"
                   class="btn btn-block btn-info btn-icon btn-icon-standalone btn-icon-standalone-right">
                    <i class="fa fa-plus"></i>
                    <span>New Opportunity</span>
                </a>
                <a href="/customers/{{ $customer->id }}/energy/meters/create"
                   class="btn btn-block btn-info btn-icon btn-icon-standalone btn-icon-standalone-right">
                    <i class="fa fa-plus"></i>
                    <span>New Meter</span>
                </a>
            @endif

            <div class="xe-widget xe-counter xe-counter-info border-top-info">
                <div class="xe-icon">
                    <i class="fa fa-fw fa-gbp"></i>
                </div>

                <div class="xe-label">
                    <strong class="num">{{ $customer->getOpenEnergyOpportunityValue() }}</strong>
                    <span>Open opportunities</span>
                </div>
            </div>
        </div>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Energy Opportunities</h3>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Status</th>
                            <th>Suppliers</th>
                            <th>Created by</th>
                            <th>Created at</th>
                            @if(auth()->user()->hasPermission('read_energy'))
                                <th></th>
                            @endif
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($customer->energyOpportunities as $opportunity)
                            <tr>
                                <td class="v-mid">
                                    <div class="label label-{{ $opportunity->status->colour }}">
                                        {{ $opportunity->status->name }}
                                    </div>
                                </td>

                                <td class="v-mid">
                                    @foreach ($opportunity->suppliers as $network)
                                        <span class="label label-primary">{{ $network->name }}</span>
                                    @endforeach
                                </td>

                                <td class="v-mid">{{ $opportunity->creator->name }}</td>

                                <td class="v-mid">{{ $opportunity->created_at->format('d/m/Y') }}</td>

                                @if(auth()->user()->hasPermission('read_energy'))
                                    <td class="v-mid">
                                        <a href="/customers/{{ $customer->id }}/energy/opportunities/{{ $opportunity->id }}"
                                           class="btn btn-xs btn-white btn-icon">
                                            <i class="fa fa-fw fa-search"></i>
                                            <span>View</span>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">There are currently no energy opportunities for this customer.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
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
                        @forelse ($customer->energyMeters as $meter)
                            <tr>
                                <td class="v-mid">
                                    {{ $meter->site->name or ''}}
                                </td>

                                <td class="v-mid">
                                    {{ $meter->type }}
                                </td>

                                <td class="v-mid">
                                    Top: {{ $meter->top_line }} <br>
                                    Bottom: {{ $meter->bottom_line }}
                                </td>

                                <td class="v-mid">
                                    <i class="fa fa-fw fa-sort-numeric-asc" data-toggle="tooltip" data-placement="top" title="Quantity"></i> {{ $meter->quantity }}  <br>
                                    <i class="fa fa-fw fa-sun-o" data-toggle="tooltip" data-placement="top" title="Day Rate"></i> {{ $meter->day_rate }} <br>
                                    <i class="fa fa-fw fa-moon-o" data-toggle="tooltip" data-placement="top" title="Night Rate"></i> {{ $meter->night_rate }} <br>
                                    <i class="fa fa-fw fa-gbp" data-toggle="tooltip" data-placement="top" title="Standing Charge"></i> {{ $meter->current_standing_charge }} <br>
                                </td>

                                <td class="v-mid">
                                    {{ $meter->contract_end_date ? $meter->contract_end_date->format('d/m/Y') : 'Not Set' }}
                                </td>

                                <td class="v-mid">
                                    {{ $meter->created_at  ? $meter->created_at->format('d/m/Y') : 'Not Set' }}
                                </td>

                                @if(auth()->user()->hasPermission('read_energy'))
                                    <td class="v-mid">
                                        <a href="/customers/{{ $customer->id }}/energy/meters/{{ $meter->id }}/edit"
                                           class="btn btn-xs btn-white btn-icon">
                                            <i class="fa fa-fw fa-edit"></i>
                                            <span>Edit</span>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">There are currently no energy meters for this customer.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
