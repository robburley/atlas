@extends('mobile.opportunities.fulfilment.layout')

@section('fulfilment-content')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="text-dark">
                Assign Sim Cards
            </h4>
        </div>
    </div>


    {!! Form::open(['action' => ['MobileOpportunity\Fulfilment\SimsController@store', $customer, $opportunity], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-sm-12 text-right">
            @if($opportunity->salesInformation && $opportunity->salesInformation->delivery_address)
                <h4 class="text-dark">Delivery Address</h4>
                <p>{!! $opportunity->salesInformation->delivery_address !!}</p>
            @endif
        </div>

        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Tariff</th>
                    <th>Hardware</th>
                    <th>Sim Number</th>
                    <th>Phone Number</th>
                    <th>Tracking Number</th>
                </tr>

                @foreach($opportunity->allocations as $allocation)
                    <tr>
                        <td class="v-mid">
                            {{ $allocation->name }}

                            {!! Form::hidden("data[$allocation->id][id]", $allocation->id) !!}
                        </td>
                        <td>
                            {{ $allocation->type }}
                        </td>
                        <td>
                            {{ $allocation->tariff_name }}
                        </td>
                        <td>
                            {{ $allocation->handset_name ?? 'No Hardware' }} @if($allocation->colour )
                                in {{ $allocation->colour }} @endif
                        </td>
                        <td>
                            {!! Form::text("data[$allocation->id][sim_number]", $allocation->sim_number, ['class' => 'form-control']) !!}
                        </td>
                        <td>
                            {!! Form::text("data[$allocation->id][phone_number]", $allocation->phone_number, ['class' => 'form-control']) !!}
                        </td>
                        <td>
                            {!! Form::text("data[$allocation->id][tracking_number]", $allocation->tracking_number, ['class' => 'form-control']) !!}
                        </td>
                    </tr>
                @endforeach
            </table>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button class="btn btn-success pull-right m-t-10">
                <i class="fa fa-upload"></i>
                Update
            </button>
        </div>
    </div>

    {!! Form::close() !!}


@endsection