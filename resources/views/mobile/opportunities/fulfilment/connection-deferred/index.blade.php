@inject('statusHelper', 'App\Helpers\MobileOpportunityStatusHelper')

@extends('layout.master')

@section('title')
    Mobile Opportunity &middot &middot; Atlas
@endsection

@section('page-title')
    Mobile Opportunity &middot &middot; Atlas
@endsection

@section('page-description')
    Mobile opportunity
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-folder-open"></i>

                Connection Deferred
            </h2>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-top-info">
                <div class="panel-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Assigned To</th>
                                    <th>Created by</th>
                                    <th>Dealt At</th>
									<th>EP Ref</th>
                                    <th class="col-xs-1"></th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse ($opportunities as $opportunity)
                                    <tr>
                                        <td class="v-mid">
                                            @if($opportunity->hasConnectedLines())
                                                <i class="fa fa-fw fa fa-fire text-danger"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="This opportunity has connected lines"
                                                ></i>
                                            @endif

                                            <a href="/customers/{{ $opportunity->customer->id }}">
                                                {{ $opportunity->customer->company_name }}
                                            </a>
                                        </td>

                                        <td class="v-mid">{{ $opportunity->activeAssigned->first()->name or 'Not Assigned' }}</td>

                                        <td class="v-mid">{{ $opportunity->creator->name }}</td>

                                        <td class="v-mid">{{ $opportunity->dealt_at ? $opportunity->dealt_at->format('d/m/Y') : '--' }}</td>

                                        <td class="v-mid">
                                            {{ $opportunity->getActiveEpRef() }}
                                        </td>

                                        <td class="v-mid">
                                            {!! Form::open(['action' => ['MobileOpportunity\Fulfilment\ConnectionDeferredController@create', $opportunity->customer_id, $opportunity], 'method' => 'get']) !!}

                                            <button class="btn btn-xs btn-info btn-icon pull-right">
                                                <i class="fa fa-fw fa-folder-open"></i>
                                                <span>Connections</span>
                                            </button>
                                            {!! Form::close() !!}
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
                        </div>
                    </div>

                    {{ $opportunities->appends([
                        'created_from' => request()->get('created_from'),
                        'created_to' => request()->get('created_to'),
                        'created' => request()->get('created'),
                        'assigned' => request()->get('assigned'),
                        'mobile_opportunity_status_id' => request()->get('mobile_opportunity_status_id'),
                        'appointment' => request()->get('appointment'),
                        'no_bill' => request()->get('no_bill'),
                        'office' => request()->get('office'),
                        'network' => request()->get('network'),
                    ])->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection