@extends('mobile.opportunities.fulfilment.layout')

@section('fulfilment-content')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="text-dark">
                Unlocks
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Tariff</th>
                    <th>Hardware</th>
                    <th>Unlock</th>
                </tr>

                @foreach($opportunity->allocations as $allocation)
                    @if(!empty($allocation->network_from) && $allocation->network_from != 'O2' && (!$allocation->handset || $allocation->handset->model == 'Additional Sim Card'))
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
                                {{ $allocation->handset->name ?? 'No hardware' }} @if($allocation->colour ) in {{ $allocation->colour }} @endif
                            </td>
                            <td>
                                {!! Form::open(['action' => ['MobileOpportunity\Fulfilment\UnlocksController@store', $customer, $opportunity], 'method' => 'post']) !!}

                                {!! Form::hidden('allocation_id', $allocation->id) !!}
                                @if($allocation->unlocked_requested)
                                    @if(!$allocation->unlocked_confirmed)
                                        {!! Form::hidden('unlocked_confirmed', 1) !!}
                                        <button class="btn btn-success">
                                            Unlock Confirmed
                                        </button>
                                    @else
                                        Unlocked
                                    @endif
                                @else
                                    {!! Form::hidden('unlocked_requested', 1) !!}
                                    <button class="btn btn-info">
                                        Unlock Requested
                                    </button>
                                @endif

                                {!! Form::close() !!}

                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    </div>


@endsection