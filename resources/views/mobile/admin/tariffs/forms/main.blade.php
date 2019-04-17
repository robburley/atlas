
<div class="form-group">
    <div class="row">
        {!! Form::label('tariff_type_id', 'Type', ['class' => 'col-sm-4 control-label']) !!}

        <div class="col-sm-8">
            {!! Form::select('tariff_type_id', FormPopulator::tariffTypes(),  null, ['class' => 'form-control', 'required']) !!}

            {!! $errors->first('tariff_type_id', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        {!! Form::label('tariff_code', 'Code', ['class' => 'col-sm-4 control-label']) !!}

        <div class="col-sm-8">
            {!! Form::text('tariff_code', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

            {!! $errors->first('tariff_code', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        {!! Form::label('uk_minutes', 'Minutes', ['class' => 'col-sm-4 control-label']) !!}

        <div class="col-sm-8">
            {!! Form::text('uk_minutes', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

            {!! $errors->first('uk_minutes', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        {!! Form::label('uk_texts', 'Texts', ['class' => 'col-sm-4 control-label']) !!}

        <div class="col-sm-8">
            {!! Form::text('uk_texts', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

            {!! $errors->first('uk_texts', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        {!! Form::label('uk_data', 'Data', ['class' => 'col-sm-4 control-label']) !!}

        <div class="col-sm-8">
            {!! Form::text('uk_data', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}

            {!! $errors->first('uk_data', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        {!! Form::label('price', 'Price (£)', ['class' => 'col-sm-4 control-label']) !!}

        <div class="col-sm-8">
            {!! Form::number('price', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'step' => '0.01']) !!}

            {!! $errors->first('price', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        {!! Form::label('max_discount', 'Maximum Discount (%)', ['class' => 'col-sm-4 control-label']) !!}

        <div class="col-sm-8">
            {!! Form::number('max_discount', 0, ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'step' => '1', 'max' => '100']) !!}

            {!! $errors->first('max_discount', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
        </div>
    </div>
</div>