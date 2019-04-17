@extends('mobile.opportunities.fulfilment.layout')

@section('fulfilment-content')

    @if($opportunity->juc()->first())
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <h4 class="text-dark">
                    Update BCAD Reference
                </h4>
            </div>
        </div>

        {!! Form::model($opportunity, ['action' => ['MobileOpportunity\Fulfilment\BcadController@store', $customer, $opportunity], 'method' => 'post', 'files' => true]) !!}

        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">

                {!! Form::text('bcad_reference', null, ['class' => 'form-control']) !!}

                {!! $errors->first('bcad_reference', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

                <button class="btn btn-success pull-right m-t-10">
                    <i class="fa fa-upload"></i>
                    Update
                </button>
            </div>
        </div>

        {!! Form::close() !!}
    @else
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <h4 class="text-dark">
                    Send JUC
                </h4>
            </div>
        </div>
        {!! Form::model($opportunity, ['action' => ['MobileOpportunity\Fulfilment\BcadController@store', $customer, $opportunity], 'method' => 'post', 'files' => true]) !!}

        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                {{ Form::file('file') }}

                {!! Form::hidden('related_id', $opportunity->id) !!}

                {!! Form::hidden('related_type', 'mobileOpportunity') !!}

                {!! $errors->first('file', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

                <button class="btn btn-success pull-right m-t-10">
                    <i class="fa fa-file-excel-o"></i>
                    Upload & send
                </button>
            </div>
        </div>

        {!! Form::close() !!}

        {!! Form::model($opportunity, ['action' => ['MobileOpportunity\Fulfilment\BcadController@store', $customer, $opportunity], 'method' => 'post', 'files' => true]) !!}

        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">

                {!! Form::hidden('bcad_reference', 'BCAD12888', ['class' => 'form-control']) !!}

                <button class="btn btn-warning pull-right m-t-10">
                    <i class="fa fa-upload"></i>
                    BCAD12888
                </button>
            </div>
        </div>

        {!! Form::close() !!}

    @endif
@endsection