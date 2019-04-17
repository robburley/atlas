@extends('mobile.opportunities.fulfilment.layout')

@section('fulfilment-content')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="text-dark">
                Connected
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <th>Type</th>
                    <th>Term</th>
                    <th>Tariff</th>
                    <th>VAS</th>
                    <th>Hardware</th>
                    <th>Mobile Number</th>
                    <th>Port Date</th>
                    <th>SIM Number</th>
                </tr>

                @foreach($opportunity->allocations as $allocation)
                    @if($allocation->connected())
                        @php($ref = $allocation->connection_reference)
                        <tr>
                            <td class="v-mid">
                                {{ $allocation->type }}
                            </td>

                            <td class="v-mid">
                                {{ $allocation->opportunity->selectedDealCalculator->first()->connections->first()->term ?? '36' }}
                            </td>


                            <td class="v-mid">
                                {{ $allocation->tariff_name }}
                            </td>

                            <td class="v-mid">
                                @forelse($allocation->vas as $vas)
                                    {{ $vas->tariff_name }}
                                @empty
                                    No Vas
                                @endforelse
                            </td>

                            <td class="v-mid">
                                {{ $allocation->handset_name ?? 'No Hardware' }} @if($allocation->colour ) in {{ $allocation->colour }} @endif
                            </td>

                            <td class="v-mid">
                                {{ $allocation->phone_number ?? 'New Connection' }}
                            </td>

                            <td class="v-mid">
                                {{ $allocation->port_date ? $allocation->port_date->format('d/m/Y') : '--' }}
                                {!! Form::hidden('data[]', $allocation->id, ['id' => 'id']) !!}
                            </td>

                            <td>
                                {{ $allocation->sim_number ?? 'No Sim Number' }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function(){
            $('#error-button').click(function(e){
                e.preventDefault();

                $('#error-div').removeClass('hidden')
                $('#buttons-row').addClass('hidden')
            })

        })
    </script>
@endsection