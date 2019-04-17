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
                        <div class="col-sm-6">
                            <strong>Created:</strong> {{ $opportunity->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="col-sm-6">
                            <strong>Created By:</strong> {{ $opportunity->creator->name }} <br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <strong>Current Networks:</strong>
                            {{ count($opportunity->networks) > 0 ? $opportunity->networks->pluck('name')->implode(', ') : 'None' }}
                        </div>
                        <div class="col-sm-6">
                            <strong>Networks open to:</strong>
                            {{ count($opportunity->openToNetworks) > 0 ? $opportunity->openToNetworks->pluck('name')->implode(', ') : 'None' }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <strong>Direct Or Dealer:</strong>
                            {{ $opportunity->direct_dealer }}
                        </div>
                        <div class="col-sm-6">
                            <strong>Will Decide in 30 Days:</strong>
                            {{ $opportunity->decide_30_days ? 'Yes' : 'No' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <strong>Will Take New Numbers:</strong>
                            {{ $opportunity->take_new_number ? 'Yes' : 'No' }}
                        </div>
                        <div class="col-sm-6">
                            <strong>Roaming or International:</strong>
                            {{ $opportunity->roaming_international }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-6">
                    <div class="xe-widget xe-counter xe-counter-info border-top-info">
                        <div class="xe-icon">
                            <i class="fa fa-mobile"></i>
                        </div>

                        <div class="xe-label">
                            <strong class="num">{{ $opportunity->voice_users }}</strong>
                            <span>Voice users</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="xe-widget xe-counter xe-counter-warning border-top-warning">
                        <div class="xe-icon">
                            <i class="fa fa-tablet"></i>
                        </div>

                        <div class="xe-label">
                            <strong class="num">{{ $opportunity->data_users }}</strong>
                            <span>Data users</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="xe-widget xe-counter xe-counter-success border-top-success">
                        <div class="xe-icon">
                            <i class="fa fa-gbp"></i>
                        </div>

                        <div class="xe-label">
                            <strong class="num">&pound;{{ $opportunity->monthly_spend }}</strong>
                            <span>Monthly spend</span>
                        </div>
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="xe-widget xe-counter xe-counter-purple border-top-purple">
                        <div class="xe-icon">
                            <i class="fa fa-calendar"></i>
                        </div>

                        <div class="xe-label">
                            <strong class="num">{{ $opportunity->contract_end_date }}</strong>
                            <span>Contract end date</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-top-purple">
                <div class="panel-heading">
                    <h3 class="panel-title">Notes</h3>
                </div>

                <div class="panel-body">
                    {{ $opportunity->notes }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @if ($opportunity->current_allowances)
            <div class="col-sm-6">
                <div class="panel panel-default border-top-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Current Allowances</h3>
                    </div>

                    <div class="panel-body">
                        {{ $opportunity->current_allowances }}
                    </div>
                </div>
            </div>
        @endif

        @if ($opportunity->current_hardware)
            <div class="col-sm-6">
                <div class="panel panel-default border-top-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">Current Hardware</h3>
                    </div>

                    <div class="panel-body">
                        {{ $opportunity->current_hardware }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="row">

        @if ($opportunity->requirements)
            <div class="col-sm-6">
                <div class="panel panel-default border-top-purple">
                    <div class="panel-heading">
                        <h3 class="panel-title">Current Requirements</h3>
                    </div>

                    <div class="panel-body">
                        {{ $opportunity->requirements }}
                    </div>
                </div>
            </div>
        @endif

        @if ($opportunity->new_hardware)
            <div class="col-sm-6">
                <div class="panel panel-default border-top-purple">
                    <div class="panel-heading">
                        <h3 class="panel-title">New Hardware</h3>
                    </div>

                    <div class="panel-body">
                        {{ $opportunity->new_hardware }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if($info = $opportunity->salesInformation)
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default border-top-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Additional Info</h3>
                        @if(auth()->user()->hasPermission('edit_customer_info_fixed_line'))
                            <a href="javascript:"
                               onclick="jQuery('#edit-information').modal('show', {backdrop: 'fade'});"
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

                                        <td>@if($info->date_of_birth) {{ $info->date_of_birth->format('d/m/Y') }} @endif</td>

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
                                            @if($info->address_1_line_1) {{  $info->address_1_line_1 }}
                                            <br> @endif
                                            @if($info->address_1_line_2) {{  $info->address_1_line_2 }}
                                            <br> @endif
                                            @if($info->address_1_line_3) {{  $info->address_1_line_3 }}
                                            <br> @endif
                                            @if($info->address_1_line_4) {{  $info->address_1_line_4 }}
                                            <br> @endif
                                            @if($info->address_1_line_5) {{  $info->address_1_line_5 }}
                                            <br> @endif
                                            @if($info->address_1_postcode) {{  $info->address_1_postcode }} @endif
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
                                            @if($info->address_2_line_1) {{  $info->address_2_line_1 }}
                                            <br> @endif
                                            @if($info->address_2_line_2) {{  $info->address_2_line_2 }}
                                            <br> @endif
                                            @if($info->address_2_line_3) {{  $info->address_2_line_3 }}
                                            <br> @endif
                                            @if($info->address_2_line_4) {{  $info->address_2_line_4 }}
                                            <br> @endif
                                            @if($info->address_2_line_5) {{  $info->address_2_line_5 }}
                                            <br> @endif
                                            @if($info->address_2_postcode) {{  $info->address_2_postcode }} @endif
                                        </td>
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


                        <div class="row">
                            <div class="col-sm-12">
                                <h4><strong>Connections</strong></h4>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                @if($opportunity->salesInformation)
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
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>