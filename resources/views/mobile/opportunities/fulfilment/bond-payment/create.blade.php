@extends('mobile.opportunities.fulfilment.layout')

@section('fulfilment-content')
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <h4 class="text-dark">
                Update Bond Payment Reference
            </h4>
        </div>
    </div>

    {!! Form::model($opportunity, ['action' => ['MobileOpportunity\Fulfilment\BondPaymentController@store', $customer, $opportunity], 'method' => 'post', 'files' => true]) !!}

    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">

            {!! Form::text('bond_payment_reference', null, ['class' => 'form-control']) !!}

            {!! $errors->first('bond_payment_reference', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

            <button class="btn btn-success pull-right m-t-10">
                <i class="fa fa-upload"></i>
                Update
            </button>
        </div>
    </div>

    {!! Form::close() !!}
@endsection