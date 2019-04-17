

@if(auth()->user()->hasPermission('create_appointments_mobile'))
    <div class="form-group-separator"></div>

    <div class="form-group">
        {!! Form::label('appointment', 'Appointment', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::checkbox('appointment', 1, null,  ['id' => 'appointment']) !!}

            {!! $errors->first('appointment', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
@endif