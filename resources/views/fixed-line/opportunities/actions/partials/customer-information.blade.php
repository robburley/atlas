<div class="row">
    <div class="col-sm-6">
        {!! Form::label('business_type', 'Type of Business', ['class' => 'control-label']) !!}
        {!! Form::select('business_type', ['Sole trader' => 'Sole trader','Partnership' => 'Partnership','Limited liability partnership' => 'Limited liability partnership','Private limited company' => 'Private limited company',] , null , ['class' => 'form-control']) !!}
        {!! $errors->first('business_type', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        {!! Form::label('account_holder', 'Account Holder Name', ['class' => 'control-label']) !!}
        {!! Form::text('account_holder', $opportunity->salesInformation ? $opportunity->salesInformation->account_holder : $opportunity->customer->contacts()->first()->full_name, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('account_holder', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>

    <div class="col-sm-6">
        {!! Form::label('business_name', 'Business Name', ['class' => 'control-label']) !!}
        {!! Form::text('business_name', $opportunity->salesInformation ? $opportunity->salesInformation->business_name : $opportunity->customer->company_name , ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('business_name', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        {!! Form::label('date_of_birth', 'Date of Birth', ['class' => 'control-label']) !!}
        {!! Form::text('date_of_birth', $opportunity->salesInformation && $opportunity->salesInformation->date_of_birth ? $opportunity->salesInformation->date_of_birth->format('d/m/Y') : null  , ['class' => 'form-control dayDatepicker', 'required' => 'required']) !!}
        {!! $errors->first('date_of_birth', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>

    <div class="col-sm-6">
        {!! Form::label('business_established_date', 'Business Established Date (Month/Year)', ['class' => 'control-label']) !!}
        {!! Form::text('business_established_date', $opportunity->salesInformation && $opportunity->salesInformation->business_established_date ? $opportunity->salesInformation->business_established_date->format('m/Y') : null , ['class' => 'form-control monthDatepicker', 'required' => 'required']) !!}
        {!! $errors->first('business_established_date', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        {!! Form::label('landline_number', 'Landline Number', ['class' => 'control-label']) !!}
        {!! Form::text('landline_number', $opportunity->salesInformation ? $opportunity->salesInformation->landline_number : $opportunity->customer->contacts()->first()->landline_number , ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('landline_number', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>

    <div class="col-sm-6">
        {!! Form::label('mobile_number', 'Mobile Number', ['class' => 'control-label']) !!}
        {!! Form::text('mobile_number', $opportunity->salesInformation ? $opportunity->salesInformation->mobile_number : $opportunity->customer->contacts()->first()->mobile_number, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('mobile_number', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>

    <div class="col-sm-6">
        {!! Form::label('email', 'Email Address', ['class' => 'control-label']) !!}
        {!! Form::email('email', $opportunity->salesInformation ? $opportunity->salesInformation->email : $opportunity->customer->contacts()->first()->email_address, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('email', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>

</div>


<br>

<div class="row">
    <div class="col-sm-6">
        <h4>Trading Address</h4>
    </div>
    <div class="col-sm-6" id="address2">
        <h4>Home Address</h4>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">

        {!! Form::label('address_1_line_1', 'Line 1', ['class' => 'control-label']) !!}
        {!! Form::text('address_1_line_1', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('address_1_line_1', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

        {!! Form::label('address_1_line_2', 'Line 2', ['class' => 'control-label']) !!}
        {!! Form::text('address_1_line_2', null, ['class' => 'form-control']) !!}
        {!! $errors->first('address_1_line_2', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

        {!! Form::label('address_1_line_3', 'Line 3', ['class' => 'control-label']) !!}
        {!! Form::text('address_1_line_3', null, ['class' => 'form-control']) !!}
        {!! $errors->first('address_1_line_3', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

        {!! Form::label('address_1_line_4', 'Line 4', ['class' => 'control-label']) !!}
        {!! Form::text('address_1_line_4', null, ['class' => 'form-control']) !!}
        {!! $errors->first('address_1_line_4', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

        {!! Form::label('address_1_line_5', 'Line 5', ['class' => 'control-label']) !!}
        {!! Form::text('address_1_line_5', null, ['class' => 'form-control']) !!}
        {!! $errors->first('address_1_line_5', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

        {!! Form::label('address_1_postcode', 'Postcode', ['class' => 'control-label']) !!}
        {!! Form::text('address_1_postcode', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('address_1_postcode', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

        {!! Form::label('address_1_time_at_address', 'Time at address', ['class' => 'control-label']) !!}
        {!! Form::text('address_1_time_at_address', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('address_1_time_at_address', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>

    <div class="col-sm-6">

        {!! Form::label('address_2_line_1', 'Line 1', ['class' => 'control-label']) !!}
        {!! Form::text('address_2_line_1', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('address_2_line_1', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

        {!! Form::label('address_2_line_2', 'Line 2', ['class' => 'control-label']) !!}
        {!! Form::text('address_2_line_2', null, ['class' => 'form-control']) !!}
        {!! $errors->first('address_2_line_2', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

        {!! Form::label('address_2_line_3', 'Line 3', ['class' => 'control-label']) !!}
        {!! Form::text('address_2_line_3', null, ['class' => 'form-control']) !!}
        {!! $errors->first('address_2_line_3', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}


        {!! Form::label('address_2_line_4', 'Line 4', ['class' => 'control-label']) !!}
        {!! Form::text('address_2_line_4', null, ['class' => 'form-control']) !!}
        {!! $errors->first('address_2_line_4', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

        {!! Form::label('address_2_line_5', 'Line 5', ['class' => 'control-label']) !!}
        {!! Form::text('address_2_line_5', null, ['class' => 'form-control']) !!}
        {!! $errors->first('address_2_line_5', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

        {!! Form::label('address_2_postcode', 'Postcode', ['class' => 'control-label']) !!}
        {!! Form::text('address_2_postcode', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('address_2_postcode', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

        {!! Form::label('address_2_time_at_address', 'Time at address', ['class' => 'control-label']) !!}
        {!! Form::text('address_2_time_at_address', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('address_2_time_at_address', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<hr>

<div class="row">
    <div class="col-sm-6">
        {!! Form::label('network_porting_from', 'Network porting from', ['class' => 'control-label']) !!}
        {!! Form::text('network_porting_from', null , ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('network_porting_from', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>

    <div class="col-sm-6">
        {!! Form::label('current_network_account_number', 'Account Number', ['class' => 'control-label']) !!}
        {!! Form::text('current_network_account_number', null , ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('current_network_account_number', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        {!! Form::label('last_bill_date', 'Last Bill Date', ['class' => 'control-label']) !!}
        {!! Form::text('last_bill_date', null , ['class' => 'form-control datepicker', 'required' => 'required']) !!}
        {!! $errors->first('last_bill_date', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>

    <div class="col-sm-6">
        {!! Form::label('last_bill_amount', 'Last Bill Amount', ['class' => 'control-label']) !!}
        {!! Form::text('last_bill_amount', null , ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('last_bill_amount', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
        {!! Form::text('password', null , ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('password', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        {!! Form::label('special_requirements', 'Special Requirements', ['class' => 'control-label']) !!}
        {!! Form::textarea('special_requirements', null , ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('special_requirements', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        {!! Form::label('connection_info', 'Connection Information', ['class' => 'control-label']) !!}
        <div class="row">
            <div class="col-sm-4">
                <input class="form-control" placeholder="Number" name="connection_information[number][]" type="text">
            </div>
            <div class="col-sm-4">
                <select class="form-control typeSelect" name="connection_information[type][]">
                    <option value="New Connection">New Connection</option>
                    <option value="Port">Port</option>
                </select>
            </div>
            <div class="col-sm-4 networkText hidden">
                <input class="form-control" placeholder="Network" name="connection_information[network][]" type="text">
            </div>
        </div>
        <div id="connectionInfo">

        </div>
    </div>
</div>

<br>

<div class="row">
    <div class="col-sm-12">
        <a class="btn btn-success pull-right" id="addConnectionInfo">Add Connection</a>
    </div>
</div>

<br>

<div class="row">
    <div class="col-sm-12">
        @if($opportunity->salesInformation)
            <div class="row">
                <div class="col-sm-4">
                    <h4>Number</h4>
                </div>
                <div class="col-sm-4">
                    <h4>Type</h4>
                </div>
                <div class="col-sm-4">
                    <h4>Network</h4>
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

<br>

@section('scripts')
    @parent
    <script>

        $(".monthDatepicker").datepicker({
            format: 'mm/yyyy'
        });

        $(".dayDatepicker").datepicker({
            format: 'dd/mm/yyyy'
        });

        $(document).ready(function () {
            $('#addConnectionInfo').click(function () {
                $('#connectionInfo').append('@include('fixed-line.opportunities.actions.partials.connection-info')');
                selects();
            });


            $('#business_type').change(function () {
                address2($(this).val())
            });

            address2($('#business_type').val());
            selects();

            function selects() {
                $('.typeSelect').change(function () {
                    if ($(this).val() == 'New Connection') {
                        $(this).closest('.row').find('.networkText').addClass('hidden')
                    } else {
                        $(this).closest('.row').find('.networkText').removeClass('hidden')
                    }
                });
            }

            function address2(val) {
                if (val == 'Sole trader') {
                    $('#address2').html('<h4>Home Address</h4>');
                } else {
                    $('#address2').html('<h4>Registered Address</h4>');
                }
            }
        });
    </script>
@endsection