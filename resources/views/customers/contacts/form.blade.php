<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default border-top-success">
            <div class="panel-heading">
                <h3 class="panel-title">New Contact</h3>
            </div>

            <div class="panel-body">
                <div class="form-group">
                    {!! Form::label('title', 'Title', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-1">
                        {!! Form::select('title', FormPopulator::title() , null,['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('title', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>

                    {!! Form::label('forename', 'Forename', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-2">
                        {!! Form::text('forename', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('forename', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>

                    {!! Form::label('surname', 'Surname', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-3">
                        {!! Form::text('surname', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('surname', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('job_title', 'Job Title', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-4">
                        {!! Form::text('job_title', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('job_title', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>

                    {!! Form::label('description', 'Description', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-4">
                        {!! Form::text('description', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                        {!! $errors->first('description', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('landline_number', 'Landline Number', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-fw fa-phone"></i>
                            </span>

                            {!! Form::text('landline_number', isset($telephone) ? $telephone : null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        </div>

                        {!! $errors->first('landline_number', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>

                    {!! Form::label('mobile_number', 'Mobile Number', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-fw fa-mobile"></i>
                            </span>

                            {!! Form::text('mobile_number', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        </div>

                        {!! $errors->first('mobile_number', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('email_address', 'Email Address', ['class' => 'col-sm-2 control-label']) !!}

                    <div class="col-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-fw fa-envelope-o"></i>
                            </span>

                            {!! Form::email('email_address', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        </div>

                        {!! $errors->first('email_address', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                    </div>
                </div>

                <div class="form-group-separator"></div>

                <div class="form-group">
                    {!! Form::label('decision_maker', 'Decision Maker', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        {!! Form::select('decision_maker', FormPopulator::yesNo() , null , ['class' => 'form-control']) !!}
                    </div>
                    {!! Form::label('finance_contact', 'Finance Contact', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        {!! Form::select('finance_contact', FormPopulator::yesNo() , null , ['class' => 'form-control']) !!}
                    </div>
                    {!! Form::label('technical_contact', 'Technical Contact', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        {!! Form::select('technical_contact', FormPopulator::yesNo() , null , ['class' => 'form-control']) !!}
                    </div>
                </div>

                @if(isset($customer))
                    <div class="form-group-separator"></div>

                    <div class="form-group">
                        {!! Form::label('site_id', 'Site', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('site_id', $customer->sites()->pluck('name', 'id') , null , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
