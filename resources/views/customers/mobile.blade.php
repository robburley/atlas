@extends('customers.layout')

@section('title')
    Mobile &middot; {{ $customer->company_name }} &middot; Atlas
@endsection

@section('page-title')
    {{ $customer->company_name }}
@endsection

@section('page-description')
    Mobile opportunities and connections
@endsection

@section('subcontent')
    <div class="row">
        <div class="col-sm-3">
            @if(auth()->user()->hasPermission('create_mobile'))
                <a href="/customers/{{ $customer->id }}/mobile/opportunities/create"
                   class="btn btn-block btn-info btn-icon btn-icon-standalone btn-icon-standalone-right">
                    <i class="fa fa-plus"></i>
                    <span>New Opportunity</span>
                </a>
            @endif

            <div class="xe-widget xe-counter xe-counter-info border-top-info">
                <div class="xe-icon">
                    <i class="fa fa-fw fa-crosshairs"></i>
                </div>

                <div class="xe-label">
                    <strong class="num">{{ $customer->getOpenMobileOpportunities() }}</strong>
                    <span>Open opportunities</span>
                </div>
            </div>
        </div>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Mobile Opportunities</h3>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Status</th>
                            <th>Networks</th>
                            <th>Users</th>
                            <th>Created by</th>
                            <th>Created at</th>
                            @if(auth()->user()->hasPermission('read_mobile'))
                                <th></th>
                            @endif
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($customer->mobileOpportunities as $opportunity)
                            <tr>
                                <td class="v-mid">
                                    <div class="label label-{{ $opportunity->status->colour }}">
                                        {{ $opportunity->status->name }}
                                    </div>
                                </td>

                                <td class="v-mid">
                                    @foreach ($opportunity->networks as $network)
                                        <span class="label label-primary">{{ $network->name }}</span>
                                    @endforeach
                                </td>

                                <td class="v-mid">
                                    <i class="fa fa-fw fa-mobile"></i> {{ $opportunity->voice_users }}
                                    <i class="fa fa-fw fa-tablet"></i> {{ $opportunity->data_users }}
                                </td>

                                <td class="v-mid">{{ $opportunity->creator->name }}</td>

                                <td class="v-mid">{{ $opportunity->created_at->format('d/m/Y') }}</td>

                                @if(auth()->user()->hasPermission('read_mobile'))
                                    <td class="v-mid">
                                        <a href="/customers/{{ $customer->id }}/mobile/opportunities/{{ $opportunity->id }}"
                                           class="btn btn-xs btn-white btn-icon">
                                            <i class="fa fa-fw fa-search"></i>
                                            <span>View</span>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">There are currently no mobile opportunities for this customer.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
