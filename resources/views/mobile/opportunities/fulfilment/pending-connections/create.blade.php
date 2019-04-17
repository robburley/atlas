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
                Pending Connection
            </h4>
        </div>
    </div>


    {!! Form::open(['action' => ['MobileOpportunity\Fulfilment\PendingConnectionsController@store', $customer, $opportunity], 'method' => 'post', 'files' => true]) !!}
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
                    @if($allocation->pendingConnection())
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

    @if(!isset($ref) || !$ref)
        <div class="row">
            <div class="col-sm-2 col-sm-offset-10">
                <h4 class="text-dark">
                    EP Reference
                </h4>
                {!! Form::text('connection_reference', $ref, ['class' => 'form-control']) !!}

                {!! $errors->first('connection_reference', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <button class="btn btn-success pull-right m-t-10" name="update" value="1">
                    <i class="fa fa-upload"></i>
                    Update
                </button>
            </div>
        </div>
    @elseif(isset($ref))
        <div class="row hidden" id="error-div">
            <div class="col-sm-2 col-sm-offset-10">
                <label>
                    <input type="checkbox" name="errors[Mobile Number Incorrect]" value="1"> Mobile Number Incorrect
                </label>

                <label>
                    <input type="checkbox" name="errors[PAC Code doesn't match CTN (s)]" value="1"> PAC Code doesn't
                    match CTN (s)
                </label>

                <label>
                    <input type="checkbox" name="errors[Sim Number Error]" value="1"> Sim Number Error
                </label>

                <label>
                    <input type="checkbox" name="errors[BCAD Doesn't match deal structure]" value="1"> BCAD Doesn't
                    match deal structure
                </label>

                <label>
                    <input type="checkbox" name="errors[Credit Check decision has expired]" value="1"> Credit Check
                    decision has expired
                </label>

                <button class="btn btn-danger pull-right m-t-10" name="error" value="1">
                    <i class="fa fa-close"></i>
                    Incorrect
                </button>
            </div>
        </div>

        <div class="row hidden" id="passed-div">
            <div class="col-sm-3 col-sm-offset-9">
                {!! Form::label('account_number', 'Account Number', ['class' => 'control-label']) !!}
                {!! Form::text('account_number', null, ['class' => 'form-control']) !!}

                {!! Form::label('date_connected', 'Date Connected', ['class' => 'control-label']) !!}
                {!! Form::text('date_connected', \Carbon\Carbon::now()->format('d/m/Y'), ['class' => 'form-control datepicker']) !!}

                {!! Form::label('contract_end_date', 'Contract End Date', ['class' => 'control-label']) !!}
                {!! Form::text('contract_end_date', \Carbon\Carbon::now()->addYears(3)->format('d/m/Y'), ['class' => 'form-control datepicker']) !!}

                {!! Form::hidden('connected', \Carbon\Carbon::now()) !!}

                <button class="btn btn-success pull-right m-t-10 m-r-10" name="passed" value="1">
                    <i class="fa fa-check"></i>
                    Passed
                </button>
            </div>
        </div>

        <div class="row" id="buttons-row">
            <div class="col-sm-12">
                {!! $errors->first('account_number', '<p class="help-block text-danger text-right"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                {!! $errors->first('date_connected', '<p class="help-block text-danger text-right"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                {!! $errors->first('contract_end_date', '<p class="help-block text-danger text-right"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

                <a class="btn btn-danger pull-right m-t-10" id="error-button">
                    <i class="fa fa-close"></i>
                    Incorrect
                </a>

                <button class="btn btn-warning pull-right m-t-10 m-r-10" name="deferred" value="1">
                    <i class="fa fa-warning"></i>
                    Deferred
                </button>

                <button class="btn btn-success pull-right m-t-10 m-r-10" id="passed-button">
                    <i class="fa fa-check"></i>
                    Passed
                </button>
            </div>
        </div>
    @endif


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

            $('#passed-button').click(function (e) {
                e.preventDefault()

                $('#passed-div').removeClass('hidden')
                $('#buttons-row').addClass('hidden')
            })
        })
    </script>
@endsection