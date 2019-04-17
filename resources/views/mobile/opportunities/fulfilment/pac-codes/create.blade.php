@extends('mobile.opportunities.fulfilment.layout')

@section('fulfilment-content')
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <h4 class="text-dark">
                Obtain PAC Codes
            </h4>
        </div>
    </div>

    {!! Form::open(['action' => ['MobileOpportunity\Fulfilment\PacCodeController@store', $customer, $opportunity], 'method' => 'post']) !!}

    <div class="row">
        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Tariff</th>
                    <th>Hardware</th>
                    <th>Network</th>
                    <th>PAC Code</th>
                </tr>

                @foreach($opportunity->allocations as $allocation)
                    @if($allocation->type == 'Port')
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
                                {{ $allocation->network_from }}
                            </td>
                            <td>
                                {!! Form::text("data[$allocation->id][pac_code]", $allocation->pac_code, ['class' => 'form-control']) !!}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>


            <button class="btn btn-success pull-right m-t-10">
                <i class="fa fa-folder-open"></i>
                Save
            </button>
        </div>
    </div>

    {!! Form::close() !!}
@endsection