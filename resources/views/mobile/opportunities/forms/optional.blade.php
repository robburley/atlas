<div class="form-group">
    {!! Form::label('current_allowances', 'Current Allowances', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::textarea('current_allowances', null, ['class' => 'form-control', 'rows' => 3, 'autocomplete' => 'off']) !!}

        {!! $errors->first('current_allowances', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    {!! Form::label('current_hardware', 'Current Hardware', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::textarea('current_hardware', null, ['class' => 'form-control', 'rows' => 3, 'autocomplete' => 'off']) !!}

        {!! $errors->first('current_hardware', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    {!! Form::label('requirements', 'Current Requirements', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::textarea('requirements', null, ['class' => 'form-control', 'rows' => 5, 'autocomplete' => 'off']) !!}

        {!! $errors->first('requirements', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>