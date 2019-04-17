<div class="form-group">
    <div class="row">
        {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

            {!! $errors->first('name', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        {!! Form::label('username', 'Username', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::text('username', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

            {!! $errors->first('username', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        {!! Form::label('password', 'Password', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::password('password', ['class' => 'form-control', 'autocomplete' => 'off']) !!}

            {!! $errors->first('password', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        {!! Form::label('password_confirmation', 'Password', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'autocomplete' => 'off']) !!}

            {!! $errors->first('password_confirmation', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        {!! Form::label('email', 'Email address', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::email('email', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

            {!! $errors->first('email', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        {!! Form::label('role_id', 'Role', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::select('role_id', FormPopulator::roles(),  null, ['class' => 'form-control', 'required']) !!}

            {!! $errors->first('role_id', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        {!! Form::label('office_id', 'Office', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::select('office_id', FormPopulator::offices(),  null, ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}

            {!! $errors->first('office_id', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        {!! Form::label('active', 'Active', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::select('active', FormPopulator::yesNo(), isset($user) ? $user->active : 1, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

            {!! $errors->first('active', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>