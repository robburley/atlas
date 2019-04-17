<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default border-top-warning">
            <div class="panel-heading">
                <h3 class="panel-title">Information</h3>

                @if($opportunity->appointment)
                    <a href="javascript:;"
                       onclick="jQuery('#update-appointment-time').modal('show', {backdrop: 'fade'})"
                       class="btn btn-success btn-xs pull-right">
                        Update Appointment
                    </a>
                @endif
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        @if(!$opportunity->appointment)
                            <h4 class="text-dark">Point Of Contact</h4>
                            @foreach($opportunity->customer->contacts()->where('decision_maker', 1)->get() as $contact)
                                {{  $contact->title  . ' ' . $contact->forename  . ' ' . $contact->surname }}

                                <br>

                                {{  $contact->mobile_number or $contact->landline_number }}<br>
                                {{  $contact->email_address }}<br>
                            @endforeach
                        @else
                            <h4 class="text-dark">Appointment Details</h4>

                            @foreach($opportunity->appointments as $appointment)
                                <strong>Date and Time:</strong>
                                {{ $appointment->time ? $appointment->time->format('d/m/Y H:i') : 'Not Set' }}

                                <br>

                                <strong>Contact:</strong>
                                {{ $appointment->contact ? $appointment->contact->full_name : 'Not Set' }}

                                <br>

                                <strong>Address:</strong>
                                {{ $appointment->site ? $appointment->site->address : 'Not Set' }}

                                <br>

                                @if($appointment->contact)
                                    @if($appointment->contact->landline_number)
                                        <strong>Landline Number
                                        </strong> {{ $appointment->contact->landline_number }}
                                        <br>
                                    @endif

                                    @if($appointment->contact->mobile_number)
                                        <strong>Mobile Number</strong>
                                        {{  $appointment->contact->mobile_number }}
                                        <br>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-sm-3">
                        <h4 class="text-dark">Created:</h4> {{ $opportunity->created_at->format('d/m/Y H:i') }}
                    </div>

                    <div class="col-sm-3">
                        <h4 class="text-dark">Created By:</h4> {{ $opportunity->creator->name }} <br>
                    </div>

                    <div class="col-sm-3">
                        <h4 class="text-dark">Current Networks:</h4>
                        {{ count($opportunity->networks) > 0 ? $opportunity->networks->pluck('name')->implode(', ') : 'None' }}
                    </div>

                    <div class="col-sm-3">
                        <h4 class="text-dark">Networks open to:</h4>
                        {{ count($opportunity->openToNetworks) > 0 ? $opportunity->openToNetworks->pluck('name')->implode(', ') : 'None' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <h4 class="text-dark">Direct Or Dealer:</h4>
                        {{ $opportunity->direct_dealer }}
                    </div>

                    <div class="col-sm-3">
                        <h4 class="text-dark">Will Decide in 30 Days:</h4>
                        {{ $opportunity->decide_30_days ? 'Yes' : 'No' }}
                    </div>

                    <div class="col-sm-3">
                        <h4 class="text-dark">Will Take New Numbers:</h4>
                        {{ $opportunity->take_new_number ? 'Yes' : 'No' }}
                    </div>

                    <div class="col-sm-3">
                        <h4 class="text-dark">Roaming or International:</h4>
                        {{ $opportunity->roaming_international }}
                    </div>
                </div>

                <div class="row m-t-25">
                    <div class="col-sm-6">
                        <div class="xe-widget xe-counter xe-counter-info border-top-info background-info">
                            <div class="xe-icon">
                                <i class="fa fa-mobile background-white text-info"></i>
                            </div>

                            <div class="xe-label">
                                <strong class="num text-white">{{ $opportunity->voice_users }}</strong>
                                <span class="text-white">Voice users</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="xe-widget xe-counter xe-counter-warning border-top-warning background-warning">
                            <div class="xe-icon">
                                <i class="fa fa-tablet background-white text-warning"></i>
                            </div>

                            <div class="xe-label">
                                <strong class="num text-white">{{ $opportunity->data_users }}</strong>
                                <span class="text-white">Data users</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="xe-widget xe-counter xe-counter-success border-top-success background-success">
                            <div class="xe-icon">
                                <i class="fa fa-gbp background-white text-success"></i>
                            </div>

                            <div class="xe-label">
                                <strong class="num text-white">&pound;{{ $opportunity->monthly_spend }}</strong>
                                <span class="text-white">Monthly spend</span>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-6">
                        <div class="xe-widget xe-counter xe-counter-purple border-top-purple background-purple">
                            <div class="xe-icon">
                                <i class="fa fa-calendar background-white text-purple"></i>
                            </div>

                            <div class="xe-label">
                                <strong class="num text-white">{{ $opportunity->contract_end_date }}</strong>
                                <span class="text-white">Contract end date</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-t-25">
                    <div class="col-sm-12">
                        <h4 class="text-dark">Notes</h4>

                        {{ $opportunity->notes }}
                    </div>
                </div>


                <div class="row">
                    @if ($opportunity->current_allowances)
                        <div class="col-sm-6 m-t-25">
                            <h4 class="text-dark">Current Allowances</h4>

                            {{ $opportunity->current_allowances }}
                        </div>
                    @endif


                    @if ($opportunity->current_hardware)
                        <div class="col-sm-6 m-t-25">
                            <h4 class="text-dark">Current Hardware</h4>
                            {{ $opportunity->current_hardware }}
                        </div>
                    @endif

                    @if ($opportunity->requirements)
                        <div class="col-sm-6 m-t-25">
                            <h4 class="text-dark">Current Requirements</h4>
                            {{ $opportunity->requirements }}
                        </div>
                    @endif

                    @if ($opportunity->new_hardware)
                        <div class="col-sm-6 m-t-25">
                            <h4 class="text-dark">New Hardware</h4>
                            {{ $opportunity->new_hardware }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <div class="panel panel-default border-top-info">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Callbacks
                </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        @foreach($opportunity->callbacks()->orderBy('time', 'desc')->get() as $callback)
                            <p>
                                @if($callback->isComplete())
                                    <s>
                                        @endif
                                        {{ $callback->assignedUser->name or 'A User' }}
                                        - {{ $callback->time->format('d/m/Y H:i') }}
                                        @if($callback->isComplete())
                                    </s>
                                @else
                                    <span class="pull-right">
                                            <a href="/customers/{{ $callback->opportunity->customer->id }}/mobile/opportunities/{{ $callback->opportunity->id }}/callbacks/{{ $callback->id }}/edit">
                                                <i class="fa fa-clock-o text-info"
                                                   title="Rearrange"></i>
                                            </a>

                                            <a href="/customers/{{ $callback->opportunity->customer->id }}/mobile/opportunities/{{ $callback->opportunity->id }}/callbacks/{{ $callback->id }}/destroy">
                                                <i class="fa fa-check text-success"
                                                   title="Complete"></i>
                                            </a>
                                        </span>
                                @endif
                            </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-6">
        <div class="panel panel-default border-top-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Files</h3>

                @if(auth()->user()->hasPermission('upload_files_mobile'))
                    <a href="javascript:"
                       onclick="jQuery('#upload-file').modal('show', {backdrop: 'fade'})"
                       class="btn btn-xs btn-success pull-right">
                        <span>Upload File</span>
                    </a>
                @endif
            </div>
            <div class="panel-body text-center">
                @foreach($opportunity->files as $file)

                    @if(! $file->type->permission || auth()->user()->hasPermission($file->type->permission->slug))
                        @if((! collect([5, 13])->contains($file->type->id) && auth()->user()->role_id == 5) || auth()->user()->role_id != 5)
                            <div class="row">
                                <div class="btn-group btn-block" role="group" aria-label="...">

                                    <a href=" {{ action('Customer\CustomerFileController@show', [$customer, $file])  }}"
                                       class="btn btn-white" style="width:90%;">
                                        {{--<i class="fa fa-user"></i>--}}
                                        <span>{{ $file->type->name }}</span>
                                    </a>

                                    @if(auth()->user()->hasPermission('delete_files_mobile'))
                                        <a href=" {{ action('Customer\CustomerFileController@destroy', [$customer, $file])  }}"
                                           class="btn btn-danger" style="width:10%;">
                                            <i class="fa fa-close"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach

                @if($opportunity->dealCalculators->first() && $opportunity->dealCalculators->first()->hasTariffs() && auth()->user()->hasPermission('awaiting_proposal_mobile'))
                    <hr>

                    <div class="row">
                        <div class="col-sm-12 text-left">
                            <h4 class="text-dark">Proposals</h4>

                            {!! Form::open(['action' => ['MobileOpportunity\ProposalController@show', $customer, $opportunity], 'method' => 'post']) !!}
                            <div class="form-group">
                                {!! Form::label('deal_calc', 'Choose a proposal to generate', ['class' => 'control-label']) !!}

                                {!! Form::select('deal_calc', $opportunity->dealCalculators()->pluck('name', 'id'), null , ['class' => 'form-control']) !!}
                            </div>
                            <button type="submit" class="btn btn-success pull-right">
                                Generate
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                @endif

                @if($opportunity->dealCalculators->first() && $opportunity->dealCalculators->first()->hasTariffs() && auth()->user()->hasPermission('awaiting_fulfilment_mobile'))
                    <hr>

                    <div class="row">
                        <div class="col-sm-12 text-left">
                            <h4 class="text-dark">Regenerate CIF</h4>

                            {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityCifController@store', $customer, $opportunity], 'method' => 'post']) !!}
                                <button type="submit" class="btn btn-success pull-right">
                                    Regenerate
                                </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if(auth()->user()->role_id != 5)
    @if(count($opportunity->allocations) > 0 && auth()->user()->hasAnyPermission(['awaiting_letterhead_mobile', 'awaiting_fulfilment_mobile']))
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default border-top-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Fulfilment Information
                        </h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            @if($opportunity->bg_ref)
                                <div class="col-sm-4">
                                    BG Reference
                                    <h4 class="text-dark">{{ $opportunity->bg_ref }}</h4>
                                </div>
                            @endif

                            @if($opportunity->ep_ref)
                                <div class="col-sm-4">
                                    C/C EP Reference
                                    <h4 class="text-dark">{{ $opportunity->ep_ref }}</h4>
                                </div>
                            @endif

                            @if($opportunity->bcad_reference)
                                <div class="col-sm-4">
                                    BCAD Reference
                                    <h4 class="text-dark">{{ $opportunity->bcad_reference }}</h4>
                                </div>
                            @endif
                        </div>

                        <hr>

                        @if(!is_null($opportunity->bond_type))
                            <div class="row">
                                <div class="col-sm-4">
                                    Bond Type

                                    <h4 class="text-dark">
                                        {{ collect(['Customer pays bond', 'Customer pays bond, refund immediately', 'We provide funds to customer'])->get($opportunity->bond_type) }}
                                    </h4>
                                </div>

                                <div class="col-sm-4">
                                    Bond Amount

                                    <h4 class="text-dark">
                                        £{{ number_format($opportunity->bond_amount, 2) }}
                                    </h4>
                                </div>
                            </div>

                            <hr>
                        @endif

                        <div class="row">
                            <div class="col-sm-12">
                                @foreach($opportunity->allocations as $allocation)
                                    <div class="row">
                                        <div class="col-sm-3">
                                            Tariff <br>
                                            <h4 class="text-dark">{{ $allocation->tariff_name }}</h4>
                                        </div>
                                        <div class="col-sm-3">
                                            Name <br>
                                            <h4 class="text-dark">
                                                {{ $allocation->name }}
                                            </h4>
                                        </div>

                                        <div class="col-sm-3">
                                            Phone Number <br>
                                            <h4 class="text-dark">
                                                {{ $allocation->phone_number }}
                                            </h4>
                                        </div>

                                        <div class="col-sm-3">
                                            Handset <br>

                                            <h4 class="text-dark">
                                                {{ $allocation->handset_name or 'No Handset' }}
                                                @if($allocation->colour ) in {{ $allocation->colour }} @endif
                                            </h4>
                                        </div>
                                    </div>

                                    <div class="row m-t-10">
                                        <div class="col-sm-3"></div>

                                        <div class="col-sm-3">
                                            Type <br>

                                            <h4 class="text-dark">
                                                {{ $allocation->type }}
                                            </h4>
                                        </div>

                                        <div class="col-sm-3">
                                            Network To <br>

                                            <h4 class="text-dark">
                                                {{ $allocation->network_to }}
                                            </h4>

                                            @if($allocation->type == 'Port')
                                                Network From <br>

                                                <h4 class="text-dark">
                                                    {{ $allocation->network_from }}
                                                </h4>
                                            @endif
                                        </div>

                                        <div class="col-sm-3">
                                            Vas <br>

                                            @forelse($allocation->vas as $vas)
                                                <h4 class="text-dark">
                                                    {{ $vas->tariff_name }}
                                                </h4>
                                            @empty
                                                <h4 class="text-dark">
                                                    No VAS added
                                                </h4>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="row m-t-10">
                                        <div class="col-sm-3">

                                        </div>
                                        <div class="col-sm-9">
                                            <div class="row">
                                                @if($allocation->pac_code)
                                                    <div class="col-sm-4 m-b-10">
                                                        Pac Code

                                                        <h4 class="text-dark">
                                                            {{ $allocation->pac_code }}
                                                        </h4>
                                                    </div>
                                                @endif

                                                @if($allocation->sim_number)
                                                    <div class="col-sm-4 m-b-10">
                                                        Sim Number

                                                        <h4 class="text-dark">
                                                            {{ $allocation->sim_number }}
                                                        </h4>
                                                    </div>
                                                @endif

                                                @if($allocation->tracking_number)
                                                    <div class="col-sm-4 m-b-10">
                                                        Tracking Number

                                                        <h4 class="text-dark">
                                                            {{ $allocation->tracking_number }}
                                                        </h4>
                                                    </div>
                                                @endif

                                                @if($allocation->port_date)
                                                    <div class="col-sm-4 m-b-10">
                                                        Port Date

                                                        <h4 class="text-dark">
                                                            {{ $allocation->port_date }}
                                                        </h4>
                                                    </div>
                                                @endif

                                                @if($allocation->connection_reference)
                                                    <div class="col-sm-4 m-b-10">
                                                        Connection Reference

                                                        <h4 class="text-dark">
                                                            {{ $allocation->connection_reference }}
                                                        </h4>
                                                    </div>
                                                @endif

                                                @if($allocation->sent_for_connection)
                                                    <div class="col-sm-4 m-b-10">
                                                        Sent For Connection

                                                        <h4 class="text-dark">
                                                            {{ $allocation->sent_for_connection->format('d/m/Y') }}
                                                        </h4>
                                                    </div>
                                                @endif

                                                @if($allocation->date_connected)
                                                    <div class="col-sm-4 m-b-10">
                                                        Date Connected

                                                        <h4 class="text-dark">
                                                            {{ $allocation->date_connected->format('d/m/Y') }}
                                                        </h4>
                                                    </div>
                                                @endif

                                                @if($allocation->account_number)
                                                    <div class="col-sm-4 m-b-10">
                                                        Account Number

                                                        <h4 class="text-dark">
                                                            {{ $allocation->account_number }}
                                                        </h4>
                                                    </div>
                                                @endif

                                                @if($allocation->contract_end_date)
                                                    <div class="col-sm-4 m-b-10">
                                                        Contract End Date

                                                        <h4 class="text-dark">
                                                            {{ $allocation->contract_end_date }}
                                                        </h4>
                                                    </div>
                                                @endif

                                                @if($allocation->imei)

                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($info = $opportunity->salesInformation)
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default border-top-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Additional Info</h3>

                        @if(auth()->user()->hasPermission('edit_customer_info_mobile'))
                            <a href="javascript:"
                               onclick="jQuery('#edit-information').modal('show', {backdrop: 'fade'})"
                               class="btn btn-xs btn-success pull-right">
                                <span>Edit</span>
                            </a>
                        @endif
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table">
                                    <tr>
                                        <td class="col-sm-3"><strong>Business Type:</strong></td>
                                        <td class="col-sm-3">{{ $info->business_type }}</td>

                                        <td class="col-sm-3"><strong>Business Name:</strong></td>
                                        <td class="col-sm-3">{{ $info->business_name }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>Account Holder:</strong></td>
                                        <td>{{ $info->account_holder_title }} {{ $info->account_holder }} {{ $info->account_holder_last_name }}</td>

                                        <td><strong>Date of Birth:</strong></td>

                                        <td>{{ $info->date_of_birth ? $info->date_of_birth->format('d/m/Y') :  'Not Set' }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>Landline Number:</strong></td>
                                        <td>{{ $info->landline_number}}</td>

                                        <td><strong>Mobile Number:</strong></td>
                                        <td>{{ $info->mobile_number }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>Email Address:</strong></td>
                                        <td>{{ $info->email }}</td>

                                        <td><strong>Business Established Date:</strong></td>
                                        <td>@if($info->business_established_date) {{ $info->business_established_date->format('m/Y') }} @endif</td>
                                    </tr>

                                    <tr>
                                        <td><strong>Company Number:</strong></td>
                                        <td>{{ $info->company_number }}</td>

                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td colspan="4">

                                        </td>
                                    </tr>

                                    <tr>
                                        <td><strong>Network porting from:</strong></td>
                                        <td>{{ $info->network_porting_from }}</td>

                                        <td><strong>Account Number:</strong></td>
                                        <td>{{ $info->current_network_account_number}}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>Last Bill Date:</strong></td>
                                        <td>{{ $info->last_bill_date }}</td>

                                        <td><strong>Last Bill Amount:</strong></td>
                                        <td>{{ $info->last_bill_amount }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>Password:</strong></td>
                                        <td>{{ $info->password }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td colspan="4">

                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong>Trading Address:</strong>
                                        </td>
                                        <td>
                                            @if($info->address_1_line_1)
                                                {{  $info->address_1_line_1 }} <br>
                                            @endif

                                            @if($info->address_1_line_2)
                                                {{  $info->address_1_line_2 }} <br>
                                            @endif

                                            @if($info->address_1_line_3)
                                                {{  $info->address_1_line_3 }} <br>
                                            @endif

                                            @if($info->address_1_line_4)
                                                {{  $info->address_1_line_4 }} <br>
                                            @endif

                                            @if($info->address_1_line_5)
                                                {{  $info->address_1_line_5 }} <br>
                                            @endif

                                            @if($info->address_1_postcode)
                                                {{  $info->address_1_postcode }}
                                            @endif
                                        </td>

                                        <td>
                                            <strong>
                                                @if($info->business_type == 'Sole trade')
                                                    Home
                                                @else
                                                    Registered
                                                @endif
                                                Address:
                                            </strong>
                                        </td>

                                        <td>
                                            @if($info->address_2_line_1)
                                                {{  $info->address_2_line_1 }} <br>
                                            @endif

                                            @if($info->address_2_line_2)
                                                {{  $info->address_2_line_2 }} <br>
                                            @endif

                                            @if($info->address_2_line_3)
                                                {{  $info->address_2_line_3 }} <br>
                                            @endif

                                            @if($info->address_2_line_4)
                                                {{  $info->address_2_line_4 }} <br>
                                            @endif

                                            @if($info->address_2_line_5)
                                                {{  $info->address_2_line_5 }} <br>
                                            @endif

                                            @if($info->address_2_postcode)
                                                {{  $info->address_2_postcode }}
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><strong>Time At Address</strong></td>
                                        <td>{{ $info->address_1_time_at_address }}</td>
                                        <td><strong>Time At Address</strong></td>
                                        <td>{{ $info->address_2_time_at_address }}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="4">

                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong>Delivery Address:</strong>
                                        </td>
                                        <td>
                                            @if($info->address_3_line_1)
                                                {{  $info->address_3_line_1 }} <br>
                                            @endif

                                            @if($info->address_3_line_2)
                                                {{  $info->address_3_line_2 }} <br>
                                            @endif

                                            @if($info->address_3_line_3)
                                                {{  $info->address_3_line_3 }} <br>
                                            @endif

                                            @if($info->address_3_line_4)
                                                {{  $info->address_3_line_4 }} <br>
                                            @endif

                                            @if($info->address_3_line_5)
                                                {{  $info->address_3_line_5 }} <br>
                                            @endif

                                            @if($info->address_3_postcode)
                                                {{  $info->address_3_postcode }}
                                            @endif
                                        </td>

                                        <td>
                                        </td>

                                        <td>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="4">

                                        </td>
                                    </tr>

                                    {{--<tr>--}}
                                    {{--<td>--}}
                                    {{--<strong>--}}
                                    {{--Network Porting From--}}
                                    {{--</strong>--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                    {{--{{ $info->network_porting_from }}--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                    {{--<strong>--}}
                                    {{--Current Network Account Number--}}
                                    {{--</strong>--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                    {{--{{ $info->current_network_account_number }}--}}
                                    {{--</td>--}}
                                    {{--</tr>--}}

                                    {{--<tr>--}}
                                    {{--<td>--}}
                                    {{--<strong>Last Bill Date</strong>--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                    {{--{{ $info->last_bill_date }}--}}
                                    {{--</td>--}}

                                    {{--<td>--}}
                                    {{--<strong>Last Bill Amount</strong>--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                    {{--{{ $info->last_bill_amount }}--}}
                                    {{--</td>--}}
                                    {{--</tr>--}}

                                    <tr>
                                        <td>
                                            <strong>Special Requirements:</strong>
                                        </td>
                                        <td colspan="3">

                                            {{ $info->special_requirements }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if(count($opportunity->salesInformation->connectionInfo) > 0)
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4><strong>Connections (legacy)</strong></h4>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <p><strong>Number</strong></p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p><strong>Type</strong></p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p><strong>Network</strong></p>
                                        </div>
                                    </div>
                                    @foreach($opportunity->salesInformation->connectionInfo as $connectionInfo)
                                        <div class="row">
                                            <div class="col-sm-4">
                                                {{ $connectionInfo->number }}
                                            </div>
                                            <div class="col-sm-4">
                                                {{ $connectionInfo->type }}
                                            </div>
                                            <div class="col-sm-4">
                                                {{ $connectionInfo->network }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif