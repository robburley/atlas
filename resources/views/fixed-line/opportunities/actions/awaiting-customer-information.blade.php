<div class="row">
    {!! Form::open(['action' => ['FixedLineOpportunity\FixedLineOpportunityController@update', $customer, $opportunity], 'method' => 'post', 'class' => 'form-horizontal']) !!}
    <div class="col-sm-6">
        <h4 class="text-dark">Customer Details</h4>

        <div class="form-group">
            {!! Form::label('customer_information[company]', 'Company Name', ['class' => 'control-label col-sm-4']) !!}
            <div class="col-sm-8">
                {!! Form::text('customer_information[company]', $opportunity->customerInformation->company ?? $customer->company_name, ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('customer_information[company]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>

        <p>Registered Address</p>

        <div class="form-group">
            {!! Form::label('customer_information[address_1]', 'Building Name/No', ['class' => 'control-label col-sm-4']) !!}
            <div class="col-sm-8">
                {!! Form::text('customer_information[address_1]',  $opportunity->customerInformation->address_1 ?? ($customer->sites()->first() ? $customer->sites()->first()->address1 : null), ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('customer_information[address_1]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('customer_information[address_2]', 'Street', ['class' => 'control-label col-sm-4']) !!}
            <div class="col-sm-8">
                {!! Form::text('customer_information[address_2]', $opportunity->customerInformation->address_2 ?? ($customer->sites()->first() ? $customer->sites()->first()->address2 : null), ['class' => 'form-control']) !!}
                {!! $errors->first('customer_information[address_2]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('customer_information[address_3]', 'Town', ['class' => 'control-label col-sm-4']) !!}
            <div class="col-sm-8">
                {!! Form::text('customer_information[address_3]', $opportunity->customerInformation->address_3 ?? ($customer->sites()->first() ? $customer->sites()->first()->town : null), ['class' => 'form-control']) !!}
                {!! $errors->first('customer_information[address_3]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('customer_information[address_4]', 'County', ['class' => 'control-label col-sm-4']) !!}
            <div class="col-sm-8">
                {!! Form::text('customer_information[address_4]', $opportunity->customerInformation->address_4 ?? ($customer->sites()->first() ? $customer->sites()->first()->county : null), ['class' => 'form-control']) !!}
                {!! $errors->first('customer_information[address_4]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('customer_information[postcode]', 'Postcode', ['class' => 'control-label col-sm-4']) !!}
            <div class="col-sm-8">
                {!! Form::text('customer_information[postcode]', $opportunity->customerInformation->postcode ?? ($customer->sites()->first() ? $customer->sites()->first()->postcode : null), ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('customer_information[postcode]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>

    </div>
    <div class="col-sm-6">
        <h4 class="text-dark">Customer Contact Details</h4>

        <div class="form-group">
            {!! Form::label('customer_information[customer_name]', 'Customer Name', ['class' => 'control-label col-sm-4']) !!}
            <div class="col-sm-8">
                {!! Form::text('customer_information[customer_name]', $opportunity->customerInformation->customer_name ?? ($customer->contacts()->first() ? $customer->contacts()->first()->full_name : null), ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('customer_information[customer_name]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('customer_information[position]', 'Position', ['class' => 'control-label col-sm-4']) !!}
            <div class="col-sm-8">
                {!! Form::text('customer_information[position]', $opportunity->customerInformation->position ?? ($customer->contacts()->first() ? $customer->contacts()->first()->job_title : null), ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('customer_information[position]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('customer_information[email]', 'Email', ['class' => 'control-label col-sm-4']) !!}
            <div class="col-sm-8">
                {!! Form::text('customer_information[email]', $opportunity->customerInformation->email ?? ($customer->contacts()->first() ? $customer->contacts()->first()->email_address : null), ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('customer_information[email]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('customer_information[billing_email]', 'Billing Email', ['class' => 'control-label col-sm-4']) !!}
            <div class="col-sm-8">
                {!! Form::text('customer_information[billing_email]', $opportunity->customerInformation->billing_email ?? ($customer->contacts()->first() ? $customer->contacts()->first()->email_address : null), ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('customer_information[billing_email]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('customer_information[office_number]', 'Office Number', ['class' => 'control-label col-sm-4']) !!}
            <div class="col-sm-8">
                {!! Form::text('customer_information[office_number]', $opportunity->customerInformation->office_number ?? ($customer->contacts()->first() ? $customer->contacts()->first()->landline_number : null), ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('customer_information[office_number]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('customer_information[mobile_number]', 'Mobile Number', ['class' => 'control-label col-sm-4']) !!}
            <div class="col-sm-8">
                {!! Form::text('customer_information[mobile_number]', $opportunity->customerInformation->mobile_number ?? ($customer->contacts()->first() ? $customer->contacts()->first()->mobile_number : null), ['class' => 'form-control']) !!}
                {!! $errors->first('customer_information[mobile_number]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2 col-sm-offset-{{ $opportunity->customerInformation ? '8' : '10'}}">
            <button class="btn btn-success btn-icon btn-icon-standalone btn-block" type="submit">
                <i class="fa fa-fw fa-upload"></i>
                <span>Update</span>
            </button>
        </div>
        {!! Form::close() !!}
        @if($opportunity->customerInformation)
            <div class="col-sm-2">
                {!! Form::open(['action' => ['FixedLineOpportunity\FixedLineOpportunityController@update', $customer, $opportunity], 'method' => 'post', 'class' => 'form-horizontal']) !!}
                {!! Form::hidden('fixed_line_opportunity_status_id', 10) !!}
                <button class="btn btn-info btn-icon btn-icon-standalone btn-block" type="submit">
                    <i class="fa fa-fw fa-chevron-right"></i>
                    <span>Continue</span>
                </button>
                {!! Form::close() !!}
            </div>
        @endif
    </div>
</div>

