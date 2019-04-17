<div class="row">
    <div class="col-sm-6">
        {!! Form::label('business_type', 'Type of Business', ['class' => 'control-label']) !!}
        {!! Form::select('business_type', ['Sole trader' => 'Sole trader','Partnership' => 'Partnership','Limited liability partnership' => 'Limited liability partnership','Private limited company' => 'Private limited company',] , null , ['class' => 'form-control']) !!}
        {!! $errors->first('business_type', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        Account Holder
    </div>
</div>

<div class="row">
    <div class="col-sm-2">
        {!! Form::label('account_holder_title', 'Title', ['class' => 'control-label']) !!}
        {!! Form::text('account_holder_title', $opportunity->salesInformation ? $opportunity->salesInformation->account_holder_title : $opportunity->customer->contacts()->first()->title, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('account_holder_title', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
    <div class="col-sm-2">
        {!! Form::label('account_holder', 'First Name(s)', ['class' => 'control-label']) !!}
        {!! Form::text('account_holder', $opportunity->salesInformation ? $opportunity->salesInformation->account_holder : $opportunity->customer->contacts()->first()->forename, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('account_holder', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
    <div class="col-sm-2">
        {!! Form::label('account_holder_last_name', 'Last Name', ['class' => 'control-label']) !!}
        {!! Form::text('account_holder_last_name', $opportunity->salesInformation ? $opportunity->salesInformation->account_holder_last_name : $opportunity->customer->contacts()->first()->surname, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('account_holder_last_name', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
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
</div>

<div class="row">
    <div class="col-sm-6">
        {!! Form::label('email', 'Email Address', ['class' => 'control-label']) !!}
        {!! Form::email('email', $opportunity->salesInformation ? $opportunity->salesInformation->email : $opportunity->customer->contacts()->first()->email_address, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('email', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>

    <div class="col-sm-6" id="company_number">
        {!! Form::label('company_number', 'Company Number', ['class' => 'control-label']) !!}
        {!! Form::text('company_number', null, ['class' => 'form-control']) !!}
        {!! $errors->first('company_number', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>


<br>

<div class="row">
    <div class="col-sm-4">
        <h4>Trading Address</h4>
    </div>
    <div class="col-sm-4" id="address2">
        <h4>Home Address</h4>
    </div>
    <div class="col-sm-4" id="address2">
        <h4>Devilery Address</h4>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
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

        {!! Form::label('address_1_time_at_address', 'Time at address (years)', ['class' => 'control-label']) !!}
        {!! Form::number('address_1_time_at_address', null, ['class' => 'form-control', 'required' => 'required', 'step' => 1, 'min' => 0]) !!}
        {!! $errors->first('address_1_time_at_address', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>

    <div class="col-sm-4">

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

        {!! Form::label('address_2_time_at_address', 'Time at address (years)', ['class' => 'control-label']) !!}
        {!! Form::number('address_2_time_at_address', null, ['class' => 'form-control', 'required' => 'required', 'step' => 1, 'min' => 0]) !!}
        {!! $errors->first('address_2_time_at_address', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>

    <div class="col-sm-4">

        {!! Form::label('address_3_line_1', 'Line 1', ['class' => 'control-label']) !!}
        {!! Form::text('address_3_line_1', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('address_3_line_1', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

        {!! Form::label('address_3_line_2', 'Line 2', ['class' => 'control-label']) !!}
        {!! Form::text('address_3_line_2', null, ['class' => 'form-control']) !!}
        {!! $errors->first('address_3_line_2', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

        {!! Form::label('address_3_line_3', 'Line 3', ['class' => 'control-label']) !!}
        {!! Form::text('address_3_line_3', null, ['class' => 'form-control']) !!}
        {!! $errors->first('address_3_line_3', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}


        {!! Form::label('address_3_line_4', 'Line 4', ['class' => 'control-label']) !!}
        {!! Form::text('address_3_line_4', null, ['class' => 'form-control']) !!}
        {!! $errors->first('address_3_line_4', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

        {!! Form::label('address_3_line_5', 'Line 5', ['class' => 'control-label']) !!}
        {!! Form::text('address_3_line_5', null, ['class' => 'form-control']) !!}
        {!! $errors->first('address_3_line_5', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

        {!! Form::label('address_3_postcode', 'Postcode', ['class' => 'control-label']) !!}
        {!! Form::text('address_3_postcode', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('address_3_postcode', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
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

<br>


@section('scripts')
    @parent
    <script>

        $('.monthDatepicker').datepicker({
            format: 'mm/yyyy',
        })

        $('.dayDatepicker').datepicker({
            format: 'dd/mm/yyyy',
        })

        $(document).ready(function () {
            $('#business_type').change(function () {
                address2($(this).val())
            })

            address2($('#business_type').val())

            selects()

            function selects() {
                $('.typeSelect').change(function () {
                    if ($(this).val() == 'New Connection') {
                        $(this).closest('.row').find('.networkText').addClass('hidden')
                    } else {
                        $(this).closest('.row').find('.networkText').removeClass('hidden')
                    }
                })
            }

            function address2(val) {
                if (val == 'Sole trader') {
                    $('#address2').html('<h4>Home Address</h4>')
                    $('#company_number').hide();
                } else {
                    $('#address2').html('<h4>Registered Address</h4>')
                    $('#company_number').show();
                }
            }
        })
    </script>
@endsection