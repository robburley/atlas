@extends('mobile.opportunities.fulfilment.layout')

@section('fulfilment-content')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="text-dark">
                Connected Lines
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-condensed">
                <tr>
                    <th>Type</th>
                    <th>Term</th>
                    <th>Tariff</th>
                    <th>VAS</th>
                    <th>BG Reference</th>
                    <th>BCAD</th>
                    <th>SIM Number</th>
                    <th>Mobile Number</th>
                    <th>Port Date</th>
                    <th>Account Number</th>
                    <th>Connection Date</th>
                </tr>

                @foreach($opportunity->allocations as $allocation)
                    @if($allocation->connected)
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
                                    {{ $vas->tariff_name }} <br>
                                @empty
                                    No Vas
                                @endforelse
                            </td>

                            <td>
                                {{ $allocation->opportunity->bg_ref }}
                            </td>

                            <td>
                                {{ $allocation->opportunity->bcad_reference }}
                            </td>

                            <td>
                                {{ $allocation->sim_number ?? 'No Sim Number' }}
                            </td>

                            <td class="v-mid">
                                {{ $allocation->phone_number ?? 'New Connection' }}
                            </td>

                            <td class="v-mid">
                                {{ $allocation->port_date ? $allocation->port_date->format('d/m/Y') : '--' }}
                            </td>

                            <td>
                                {{ $allocation->account_number }}
                            </td>

                            <td>
                                {{ $allocation->date_connected ? $allocation->date_connected->format('d/m/Y') : '--' }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4 class="text-dark">
                Connection Errors
            </h4>
        </div>
    </div>


    {!! Form::open(['action' => ['MobileOpportunity\Fulfilment\ConnectionErrorsController@store', $customer, $opportunity], 'method' => 'post', 'files' => true]) !!}
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
                    @if($allocation->connection_error)
                        @php($connectionErrors = $allocation->errors)
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

    @if(isset($connectionErrors))
        <div class="row">
            <div class="col-sm-12 text-right">
                @foreach($connectionErrors as $connectionError)
                    @if($connectionError->active)
                        <p class="text-danger">{{ $connectionError->error }}</p>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12">
            <button class="btn btn-success pull-right m-t-10">
                <i class="fa fa-upload"></i>
                Resolved
            </button>
        </div>
    </div>


    {!! Form::close() !!}

@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            $('#error-button').click(function (e) {
                e.preventDefault()

                $('#error-div').removeClass('hidden')
                $('#buttons-row').addClass('hidden')
            })

        })
    </script>
@endsection