<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default border-top-success">
            <div class="panel-heading">
                <h3 class="panel-title">Appointment Location</h3>
            </div>

            <div class="panel-body">
                <div class="form-group">
                    {!! Form::label('appointment_info[site][name]', 'Name', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-10">
                        {!! Form::text('appointment_info[site][name]', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('appointment_info[site][name]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('appointment_info[site][address1]', 'Address line 1', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-10">
                        {!! Form::text('appointment_info[site][address1]', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('appointment_info[site][address1]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('appointment_info[site][address2]', 'Address line 2', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-10">
                        {!! Form::text('appointment_info[site][address2]', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('appointment_info[site][address2]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('appointment_info[site][address3]', 'Address Line 3', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-10">
                        {!! Form::text('appointment_info[site][address3]', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('appointment_info[site][address3]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('appointment_info[site][town]', 'Town', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-10">
                        {!! Form::text('appointment_info[site][town]', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('appointment_info[site][town]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('appointment_info[site][county]', 'County', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-10">
                        {!! Form::text('appointment_info[site][county]', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('appointment_info[site][county]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('appointment_info[site][postcode]', 'Postcode', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-10">
                        {!! Form::text('appointment_info[site][postcode]', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('appointment_info[site][postcode]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('appointment_info[site][head_office]', 'Head Office', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-10">
                        {!! Form::Select('appointment_info[site][head_office]', FormPopulator::yesNo() ,null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('appointment_info[site][head_office]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
