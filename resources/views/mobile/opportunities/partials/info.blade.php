<div role="tabpanel" class="tab-pane" id="info">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-top-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="text-{{ $opportunity->status->colour == 'blue' ? 'info' : $opportunity->status->colour }}">
                            <i class="fa-user"></i> {{ $opportunity->status->name }}
                        </span>
                        | Info</h3>
                </div>

                <div class="panel-body">
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
        <div class="col-sm-12">
            <div class="panel panel-default border-top-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">Optional Information</h3>
                </div>
                <div class="panel-body">
                </div>
            </div>
        </div>
    </div>

    @if(count($opportunity->allocations) > 0)
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default border-top-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Allocations</h3>
                    </div>

                    <div class="panel-body">
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

                                        @if($allocation->type == 'Port')
                                            <div class="col-sm-3">
                                                Network From <br>

                                                <h4 class="text-dark">
                                                    {{ $allocation->network_from }}
                                                </h4>
                                            </div>
                                        @endif

                                        <div class="col-sm-3">
                                            Network To <br>

                                            <h4 class="text-dark">
                                                {{ $allocation->network_to }}
                                            </h4>
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
                                        <td>{{ $info->account_holder }}</td>

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
                                        <td>
                                            <strong>
                                                Network Porting From
                                            </strong>
                                        </td>
                                        <td>
                                            {{ $info->network_porting_from }}
                                        </td>
                                        <td>
                                            <strong>
                                                Current Network Account Number
                                            </strong>
                                        </td>
                                        <td>
                                            {{ $info->current_network_account_number }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong>Last Bill Date</strong>
                                        </td>
                                        <td>
                                            {{ $info->last_bill_date }}
                                        </td>

                                        <td>
                                            <strong>Last Bill Amount</strong>
                                        </td>
                                        <td>
                                            {{ $info->last_bill_amount }}
                                        </td>
                                    </tr>

                                    <tr>
                                        'password'
                                    </tr>

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
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>