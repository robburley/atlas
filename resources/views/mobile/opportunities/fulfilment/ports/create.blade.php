@extends('mobile.opportunities.fulfilment.layout')

@section('fulfilment-content')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="text-dark">
                Assign Sim Cards
            </h4>
        </div>
    </div>


    {!! Form::open(['action' => ['MobileOpportunity\Fulfilment\PortsController@store', $customer, $opportunity], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Tariff</th>
                    <th>Hardware</th>
                    <th>SIM Number</th>
                    <th>Phone Number</th>
                    <th>Port Date</th>
                </tr>

                @foreach($opportunity->allocations as $allocation)
                    @if($allocation->portable())
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
                                {{ $allocation->handset_name ?? 'No Hardware' }} @if($allocation->colour ) in {{ $allocation->colour }} @endif
                            </td>
                            <td>
                                {{ $allocation->sim_number ?? 'No Sim Number' }}
                            </td>
                            <td>
                                {{ $allocation->phone_number ?? '--' }}
                            </td>
                            <td>
                                {!! Form::text("data[$allocation->id][port_date]", $allocation->port_date ? $allocation->port_date->format('d/m/Y') : null, ['class' => 'form-control datepicker', 'readonly']) !!}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>

            <button class="btn btn-success pull-right m-t-10">
                <i class="fa fa-upload"></i>
                Update
            </button>
        </div>
    </div>

    {!! Form::close() !!}
@endsection