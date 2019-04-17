<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('office_id', 'Location', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::select('office_id', FormPopulator::officesBySlug() , isset($application) && $application->office ? $application->office->slug : null , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}

                {!! $errors->first('office_id', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
        <div class="col-sm-6">

            {!! Form::label('position', 'Position', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::select('position', [], null , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}

                {!! $errors->first('position', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
    </div>
</div>