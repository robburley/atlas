<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('drive', 'Drive', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::textarea('drive', null, ['class' => 'form-control', 'rows' => 5]) !!}

                {!! $errors->first('drive', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
        <div class="col-sm-6">

            {!! Form::label('bring_to_business', 'Bring to Business', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::textarea('bring_to_business', null, ['class' => 'form-control', 'rows' => 5]) !!}

                {!! $errors->first('bring_to_business', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('suitable_reason', 'Suitable Reason', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::textarea('suitable_reason', null, ['class' => 'form-control', 'rows' => 5]) !!}

                {!! $errors->first('suitable_reason', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
        <div class="col-sm-6">

            {!! Form::label('best_attributes', 'Best Attributes', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::textarea('best_attributes', null, ['class' => 'form-control', 'rows' => 5]) !!}

                {!! $errors->first('best_attributes', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('development_areas', 'Areas of Development', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::textarea('development_areas', null, ['class' => 'form-control', 'rows' => 5]) !!}

                {!! $errors->first('development_areas', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            {!! Form::label('confidence', 'Confidence', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::selectRange('confidence', 1, 10 , null , ['class' => 'form-control']) !!}

                {!! $errors->first('confidence', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
    </div>
</div>

