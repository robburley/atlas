<div class="form-group">
    <div class="row">
        {!! Form::label('manufacturer', 'Manufacturer', ['class' => 'col-sm-4 control-label']) !!}

        <div class="col-sm-8">
            {!! Form::text('manufacturer', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

            {!! $errors->first('manufacturer', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        {!! Form::label('model', 'Model', ['class' => 'col-sm-4 control-label']) !!}

        <div class="col-sm-8">
            {!! Form::text('model', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

            {!! $errors->first('model', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        {!! Form::label('price', 'Price', ['class' => 'col-sm-4 control-label']) !!}

        <div class="col-sm-8">
            {!! Form::number('price', null, ['class' => 'form-control', 'autocomplete' => 'off', 'min' => '0', 'step' => '0.01']) !!}

            {!! $errors->first('price', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>