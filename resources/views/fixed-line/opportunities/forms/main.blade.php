<div class="form-group">
    {!! Form::label('networks', 'Current Network(s)', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::select('networks[]', $networks, isset($opportunity) && $opportunity->networks ? $opportunity->networks->pluck('id')->toArray() : null, ['class' => 'form-control select2', 'multiple']) !!}

        {!! $errors->first('networks', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    {!! Form::label('type', 'Type', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::select('type', ['New' => 'New', 'Existing' => 'Existing'], null, ['class' => 'form-control select2', 'placeholder' => '']) !!}

        {!! $errors->first('type', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    {!! Form::label('lines', 'No. of Lines', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-fw fa-phone"></i>
            </span>

            {!! Form::number('lines', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}
        </div>

        {!! $errors->first('lines', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    {!! Form::label('broadband', 'No. of Boardband lines', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-fw fa-at"></i>
            </span>

            {!! Form::number('broadband', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}
        </div>

        {!! $errors->first('broadband', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

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

<div class="form-group">
    {!! Form::label('contract_end_date_confirmed', 'CED Confirmed?', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::select('contract_end_date_confirmed', ['1' => 'Yes', '0' => 'No'], null, ['class' => 'form-control select2', 'placeholder' => '']) !!}

        {!! $errors->first('contract_end_date_confirmed', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    {!! Form::label('notes', 'Notes', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 5, 'required', 'autocomplete' => 'off']) !!}

        {!! $errors->first('notes', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    {!! Form::label('new_hardware', 'New Hardware', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::textarea('new_hardware', null, ['class' => 'form-control', 'rows' => 3, 'autocomplete' => 'off', 'required']) !!}

        {!! $errors->first('new_hardware', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>


@if(auth()->user()->hasPermission('hot_transfer_fixed_line') && ! isset($opportunity))
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

                {!! Form::select('hot_transfer[user_id]', FormPopulator::assignableUsers(null, 'fixed_line'), null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
@endif