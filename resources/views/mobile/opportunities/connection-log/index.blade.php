@inject('statusHelper', 'App\Helpers\MobileOpportunityStatusHelper') @extends('layout.master') @section('styles')
<style>
	.table-responsive>.table>thead>tr>th,
	.table-responsive>.table>tbody>tr>th,
	.table-responsive>.table>tfoot>tr>th,
	.table-responsive>.table>thead>tr>td,
	.table-responsive>.table>tbody>tr>td,
	.table-responsive>.table>tfoot>tr>td {
		white-space: nowrap;
	}
</style>
@endsection @section('title') Mobile Opportunity &middot; Connection Log &middot; Atlas @endsection @section('page-title')
Mobile Opportunity &middot; Connection Log &middot; Atlas @endsection @section('page-description') Mobile opportunity @endsection
@section('content')
<div class="row">
	<div class="col-sm-12">
		<h2 class="m-b-0 m-t-5">
			<i class="fa fa-fw fa-mobile"></i>
			Mobile Opportunities - Connection Log
		</h2>
	</div>
</div>

<br> @include('mobile.opportunities.partials.filters')

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default border-top-info">
			<div class="panel-body">
				<div class="table-wrapper">
					<div class="table-responsive">
						<table class="table table-condensed">
							<thead>
								<tr>
									<th>Customer</th>
									<th>Connections</th>
									<th>Contracted L/R</th>
									<th>Total Income</th>
									<th>Buyout</th>
									<th>Deal Inc</th>
									<th>Hardware Fund</th>
									<th>GP</th>
									<th>Closer</th>
									<th>Lead Gen</th>
									<th>Branch</th>
									<th>CC Date</th>
									<th>Dealt Date</th>
									<th>Part Connection Date</th>
									<th>Connection Date</th>
									<th>Status</th>
									<th></th>
								</tr>
							</thead>

							<tbody>
								@forelse ($opportunities as $opportunity)
								<tr>
									<td class="v-mid">
										@if($opportunity->get('appointment'))
										    <i class="fa fa-fw fa fa-calendar text-purple" data-toggle="tooltip" data-placement="top" title="Appointment"></i>
										@endif 

                                        @if($opportunity->get('hot_transfer'))
										    <i class="fa fa-fw fa fa-fire text-danger" data-toggle="tooltip" data-placement="top" title="Hot Transfer"></i>
										@endif

										<a href="/customers/{{ $opportunity->get('customer_id') }}">
											{{ $opportunity->get('Customer') }}
										</a>
									</td>

									<td class="v-mid">
										<i class="fa fa-plus text-success" data-toggle="tooltip" data-placement="top" title="New Connections"></i> {{ $opportunity->get('Connections')->get('New connection') }}

										<i class="fa fa-life-bouy text-purple" data-toggle="tooltip" data-placement="top" title="Port"></i> {{ $opportunity->get('Connections')->get('Port') }}

										<i class="fa fa-level-up text-info" data-toggle="tooltip" data-placement="top" title="Upgrade"></i> {{ $opportunity->get('Connections')->get('Upgrade') }}
									</td>

									<td class="v-mid">
                                        £{{ number_format($opportunity->get('Contracted L/R'), 2) }}
                                    </td>

									<td class="v-mid">
                                        £{{ number_format($opportunity->get('Total Income'), 2) }}
                                    </td>

									<td class="v-mid">
                                        £{{ number_format($opportunity->get('Buyout'), 2) }}
                                    </td>

									<td class="v-mid">
                                        £{{ number_format($opportunity->get('Deal Inc'), 2) }}
                                    </td>

									<td class="v-mid">
                                        £{{ number_format($opportunity->get('Hardware Fund'), 2) }}
                                    </td>

									<td class="v-mid">
                                        £{{ number_format($opportunity->get('GP'), 2) }}
                                    </td>

									<td class="v-mid">
                                        {{ $opportunity->get('Closer') }}
                                    </td>

									<td class="v-mid">
                                        {{ $opportunity->get('Lead Gen') }}
                                    </td>

									<td class="v-mid">
                                        {{ $opportunity->get('Branch') }}
                                    </td>

									<td class="v-mid">
                                        {{ $opportunity->get('CC Date') }}
                                    </td>

									<td class="v-mid">
                                        {{ $opportunity->get('Dealt Date') }}
                                    </td>

									<td class="v-mid">
                                        {{ $opportunity->get('Part Connection Date') }}
                                    </td>

									<td class="v-mid">
                                        {{ $opportunity->get('Connection Date') }}
                                    </td>

									<td class="v-mid text-{{ $opportunity->get('status_colour') }}">
                                        {{ $opportunity->get('Status') }}
									</td>


									<td class="v-mid">
										<a href="{{ $opportunity->get('path') }}" class="btn btn-xs btn-white btn-icon">
											<i class="fa fa-fw fa-search"></i>
											<span>View</span>
										</a>
									</td>
								</tr>
								@empty
								<tr>
									<td colspan="6">There are currently no mobile opportunities for of this status.
									</td>
								</tr>
								@endforelse

                                <thead>
                                    <tr>
                                        <th>Total</th>
                                        <th>
                                            <i class="fa fa-plus text-success" data-toggle="tooltip" data-placement="top" title="New Connections"></i> {{ $totalData->get('Connections')->get('New connection') }}

                                            <i class="fa fa-life-bouy text-purple" data-toggle="tooltip" data-placement="top" title="Port"></i> {{ $totalData->get('Connections')->get('Port') }}

                                            <i class="fa fa-level-up text-info" data-toggle="tooltip" data-placement="top" title="Upgrade"></i> {{ $totalData->get('Connections')->get('Upgrade') }}
                                        </th>
                                        <th></th>
                                        <th>£{{ number_format($totalData->get('Total Income'), 2) }}</th>
                                        <th>£{{ number_format($totalData->get('Buyout'), 2) }}</th>
                                        <th>£{{ number_format($totalData->get('Deal Inc'), 2) }}</th>
                                        <th>£{{ number_format($totalData->get('Hardware Fund'), 2) }}</th>
                                        <th>£{{ number_format($totalData->get('GP'), 2) }}</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>

                                    <tr>
                                        <th>Customer</th>
                                        <th>Connections</th>
                                        <th>Contracted L/R</th>
                                        <th>Total Income</th>
                                        <th>Buyout</th>
                                        <th>Deal Inc</th>
                                        <th>Hardware Fund</th>
                                        <th>GP</th>
                                        <th>Closer</th>
                                        <th>Lead Gen</th>
                                        <th>Branch</th>
                                        <th>CC Date</th>
                                        <th>Dealt Date</th>
                                        <th>Part Connection Date</th>
                                        <th>Connection Date</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
							</tbody>
						</table>
					</div>
				</div>

				{{ $opportunities->appends([ 'created' => request()->get('created'), 'assigned' => request()->get('assigned'), 'office' =>
				request()->get('office'), 'no_bill' => request()->get('no_bill'), 'appointment' => request()->get('appointment'), 'network'
				=> request()->get('network'), 'created_from' => request()->get('created_from'), 'created_to' => request()->get('created_to'),
				'appointment_from' => request()->get('appointment_from'), 'appointment_to' => request()->get('appointment_to'), 'dealt_from'
				=> request()->get('dealt_from'), 'dealt_to' => request()->get('dealt_to'), 'blown' => request()->get('blown'), ])->links()
				}}
			</div>
		</div>
	</div>
</div>
@endsection