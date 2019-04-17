<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('first_name', 'First Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::text('first_name', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

                {!! $errors->first('first_name', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
        <div class="col-sm-6">

            {!! Form::label('last_name', 'Last Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::text('last_name', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

                {!! $errors->first('last_name', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('telephone', 'Landline Number', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::text('telephone', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

                {!! $errors->first('telephone', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>

        <div class="col-sm-6">
            {!! Form::label('mobile', 'Mobile Number', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::text('mobile', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

                {!! $errors->first('mobile', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('email', 'Email address', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::email('email', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

                {!! $errors->first('email', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            {!! Form::label('date_of_birth', 'Date of birth', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::text('date_of_birth', null, ['class' => 'form-control datepicker', 'required', 'autocomplete' => 'off']) !!}

                {!! $errors->first('date_of_birth', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('commitments', 'Commitments', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::text('commitments', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

                {!! $errors->first('commitments', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            {!! Form::label('cv', 'CV', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::file('cv') !!}

                {!! $errors->first('cv', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('children', 'Children', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::select('children', FormPopulator::yesNo() , null , ['class' => 'form-control']) !!}

                {!! $errors->first('children', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            {!! Form::label('married', 'Married', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::select('married', FormPopulator::yesNo() , null , ['class' => 'form-control']) !!}

                {!! $errors->first('married', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
    </div>
</div>