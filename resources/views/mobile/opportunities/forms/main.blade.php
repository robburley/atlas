<div class="form-group">
    {!! Form::label('networks', 'Current Network(s)', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::select('networks[]', $networks, isset($opportunity) && $opportunity->networks ? $opportunity->networks->pluck('id')->toArray() : null, ['class' => 'form-control select2', 'multiple']) !!}

        {!! $errors->first('networks', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>


@if(!auth()->user()->hasPermission('create_appointments_mobile'))
    <div class="form-group">
        {!! Form::label('direct_dealer', 'Direct or Dealer', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::text('direct_dealer', null, ['class' => 'form-control']) !!}

            {!! $errors->first('direct_dealer', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>

    <div class="form-group-separator"></div>
@endif

@if(!auth()->user()->hasPermission('create_appointments_mobile'))
    <div class="form-group">
        {!! Form::label('take_new_number', 'Will Take New Numbers?', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::select('take_new_number', FormPopulator::yesNo(), null, ['class' => 'form-control select2', 'placeholder' => '']) !!}

            {!! $errors->first('take_new_number', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>

    <div class="form-group-separator"></div>
@endif

@if(!auth()->user()->hasPermission('create_appointments_mobile'))
    <div class="form-group">
        {!! Form::label('openToNetworks', 'Network(s) Open To', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::select('openToNetworks[]', $networks, isset($opportunity) && $opportunity->openToNetworks ? $opportunity->openToNetworks->pluck('id')->toArray() : null, ['class' => 'form-control select2', 'multiple']) !!}

            {!! $errors->first('openToNetworks', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>

    <div class="form-group-separator"></div>
@endif

@if(!auth()->user()->hasPermission('create_appointments_mobile'))

    <div class="form-group">
        {!! Form::label('roaming_international', 'Roaming and International', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::text('roaming_international', null, ['class' => 'form-control']) !!}
            {!! $errors->first('roaming_international', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>

    <div class="form-group-separator"></div>
@endif

@if(!auth()->user()->hasPermission('create_appointments_mobile'))

    <div class="form-group">
        {!! Form::label('voice_users', 'No. of Voice Users', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-fw fa-mobile"></i>
            </span>

                {!! Form::text('voice_users', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}
            </div>

            {!! $errors->first('voice_users', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>

    <div class="form-group-separator"></div>
@endif

@if(!auth()->user()->hasPermission('create_appointments_mobile'))

    <div class="form-group">
        {!! Form::label('data_users', 'No. of Data Users', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-fw fa-tablet"></i>
            </span>

                {!! Form::text('data_users', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}
            </div>

            {!! $errors->first('data_users', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>

    <div class="form-group-separator"></div>
@endif

<div class="form-group">
    {!! Form::label('monthly_spend', 'Typical Monthly Spend', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-fw fa-gbp"></i>
            </span>

            {!! Form::text('monthly_spend', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}
        </div>

        {!! $errors->first('monthly_spend', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

@if(!auth()->user()->hasPermission('create_appointments_mobile'))

    <div class="form-group">
        {!! Form::label('contract_end_date', 'Contract End Date', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-fw fa-calendar"></i>
                                    </span>

                {!! Form::text('contract_end_date', null, ['class' => 'form-control datepicker', 'required', 'autocomplete' => 'off']) !!}
            </div>

            {!! $errors->first('contract_end_date', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>

    <div class="form-group-separator"></div>
@endif

@if(!auth()->user()->hasPermission('create_appointments_mobile'))

    <div class="form-group">
        {!! Form::label('contract_end_date_confirmed', 'CED Confirmed?', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::select('contract_end_date_confirmed', ['1' => 'Yes', '0' => 'No'], null, ['class' => 'form-control select2', 'placeholder' => '']) !!}

            {!! $errors->first('contract_end_date_confirmed', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>

    <div class="form-group-separator"></div>
@endif

@if(!auth()->user()->hasPermission('create_appointments_mobile'))

    <div class="form-group">
        {!! Form::label('notes', 'Notes', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 5, 'required', 'autocomplete' => 'off']) !!}

            {!! $errors->first('notes', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>

    <div class="form-group-separator"></div>
@endif

@if(!auth()->user()->hasPermission('create_appointments_mobile'))

    <div class="form-group">
        {!! Form::label('new_hardware', 'New Hardware', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::textarea('new_hardware', null, ['class' => 'form-control', 'rows' => 3, 'autocomplete' => 'off', 'required']) !!}

            {!! $errors->first('new_hardware', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>

@endif

@if(auth()->user()->hasPermission('hot_transfer_mobile') && ! isset($opportunity))
    <div class="form-group-separator"></div>

    <div class="form-group">
        {!! Form::label('hot_transfer[confirm]', 'Hot Transfer', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::checkbox('hot_transfer[confirm]', 1, null,  ['id' => 'hot_transfer']) !!}

            {!! $errors->first('hot_transfer[confirm]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>

    <div id="ht-closer">
        <div class="form-group-separator"></div>

        <div class="form-group">
            {!! Form::label('hot_transfer[confirm]', 'Assign a Closer', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">

                {!! Form::select('hot_transfer[user_id]', FormPopulator::assignableUsers(), null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
@endif