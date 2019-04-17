<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default border-top-success">
            <div class="panel-heading">
                <h3 class="panel-title">Site</h3>
            </div>

            <div class="panel-body">
                <div class="form-group">
                    {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-10">
                        {!! Form::text('name', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('name', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('address1', 'Address line 1', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-10">
                        {!! Form::text('address1', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('address1', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('address2', 'Address line 2', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-10">
                        {!! Form::text('address2', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('address2', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('address3', 'Address Line 3', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-10">
                        {!! Form::text('address3', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('address3', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('town', 'Town', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-10">
                        {!! Form::text('town', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('town', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('county', 'County', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-10">
                        {!! Form::text('county', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('county', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('postcode', 'Postcode', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-10">
                        {!! Form::text('postcode', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('postcode', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('head_office', 'Head Office', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-10">
                        {!! Form::Select('head_office', FormPopulator::yesNo() ,null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('head_office', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
