<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('name', 'Position Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::text('name', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

                {!! $errors->first('name', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            {!! Form::label('office_id', 'Location', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::select('office_id', FormPopulator::offices(), null , ['class' => 'form-control']) !!}

                {!! $errors->first('office_id', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
    </div>
</div>