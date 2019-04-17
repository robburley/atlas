<div class="form-group">
    <div class="row">
        {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}

        <div class="col-sm-10">
            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

            {!! $errors->first('name', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>
