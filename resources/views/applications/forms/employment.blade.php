<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('experience', 'Experience', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::textarea('experience', null, ['class' => 'form-control', 'rows' => 5]) !!}

                {!! $errors->first('experience', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
        <div class="col-sm-6">

            {!! Form::label('current_role', 'Current Role', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::textarea('current_role', null, ['class' => 'form-control', 'rows' => 5]) !!}

                {!! $errors->first('current_role', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-6">

            {!! Form::label('change_reason', 'Reason for change', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::textarea('change_reason', null, ['class' => 'form-control', 'rows' => 5]) !!}

                {!! $errors->first('change_reason', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            {!! Form::label('best_job', 'Best Job', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::textarea('best_job', null, ['class' => 'form-control', 'rows' => 5]) !!}

                {!! $errors->first('best_job', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-6">

            {!! Form::label('biggest_achievement', 'Biggest Achievement', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::textarea('biggest_achievement', null, ['class' => 'form-control', 'rows' => 5]) !!}

                {!! $errors->first('biggest_achievement', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>
    </div>
</div>

