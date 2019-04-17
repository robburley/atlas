<div class="form-group">
    {!! Form::label('site_id', 'Site', ['class' => 'control-label col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::select('site_id', $customer->sites()->pluck('name', 'id'), null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('type', 'Meter Type', ['class' => 'control-label col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::select('type', ['Gas' => 'Gas', 'Electric' => 'Electric'], null, ['class' => 'form-control']) !!}
    </div>
</div>

{{--<div class="form-group">--}}
    {{--{!! Form::label('number', 'Meter Number', ['class' => 'control-label col-sm-3']) !!}--}}
    {{--<div class="col-sm-9">--}}
        {{--{!! Form::text('number', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

<div class="form-group">
    {!! Form::label('top_line', 'Meter Top Line', ['class' => 'control-label col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::text('top_line', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('bottom_line', 'Meter Bottom Line', ['class' => 'control-label col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::text('bottom_line', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('quantity', 'Annual Quantity', ['class' => 'control-label col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::text('quantity', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('day_rate', 'Current Day Rate', ['class' => 'control-label col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::text('day_rate', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('night_rate', 'Current Night Rate', ['class' => 'control-label col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::text('night_rate', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('current_standing_charge', 'Current Standing Charge', ['class' => 'control-label col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::text('current_standing_charge', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('contract_end_date', 'Contract End Date', ['class' => 'control-label col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::text('contract_end_date', isset($meter) && $meter->contract_end_date ? $meter->contract_end_date->format('d/m/Y') : null, ['class' => 'form-control datepicker']) !!}
    </div>
</div>