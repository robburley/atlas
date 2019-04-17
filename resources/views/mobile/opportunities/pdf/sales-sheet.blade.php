@php
    $primary = $dealCalculator->primaryConnections->first();
    $term = $primary
        ? $primary->term
        : $dealCalculator->secondaryConnections->first()->term;

    $tariffs = $dealCalculator->connections()->whereHas('tariff', function($query){
        return $query->whereHas('type', function($qry){
            return $qry->where('vas', 0);
        });
    })->get();

    $vas = $dealCalculator->connections()->whereHas('tariff', function($query){
        return $query->whereHas('type', function($qry){
            return $qry->where('vas', 1);
        });
    })->get();

    $tariffTotal = $tariffs->map(function($tarriff){
        return $tarriff->gp * $tarriff->connections;
    })->sum();

    $vasTotal = $vas->map(function($tarriff){
        return $tarriff->gp * $tarriff->connections;
    })->sum();

    $totalIncome = $tariffTotal + $vasTotal;

    $handsetTotal = $dealCalculator->handsets->map(function($handset){
        return $handset->value * $handset->units;
    })->sum();

    $simCardTotal = $dealCalculator->getSimCards() && $dealCalculator->getSimCards()->units > 0
        ? $dealCalculator->getSimCards()->units * $dealCalculator->getSimCards()->value
        : 0;

    $totalGp = $totalIncome - $handsetTotal - $simCardTotal;
@endphp

        <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sales Sheet | {{ $dealCalculator->name  }}</title>

    <link rel="stylesheet" href="{{ public_path('/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ public_path('/assets/css/fonts/fontawesome/css/font-awesome.min.css') }}">
    <style>
        .pdf-container {
            height: 100%;
            width: 100%;
            padding-top: 25px;
            padding-bottom: 25px;
            position: relative;
        }

        .row {
            padding-left: 50px;
            padding-right: 50px;
        }

        p {
            font-size: 14px;
        }

        body {
            font-size: 14px;
        }

        .table > thead > tr > td, .table > tbody > tr > td, .table > tfood > tr > td, .table > thead > tr > th, .table > tbody > tr > th, .table > tfood > tr > th {
            padding: 1.5px 10px;
        }

        .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
            border: 1px solid #afafaf;
        }
    </style>
</head>
<body>

<div class="pdf-container">
    <div class="row">
        <div class="col-xs-6">
            <h4>Business Sales Sheet v3.2
                <small>21/07/2017</small>
            </h4>

            <table class="table table-bordered">
                <tr>
                    <th class="col-xs-8">Company Name</th>
                    <th class="col-xs-4">Date</th>
                </tr>
                <tr>
                    <th>{{ $customer->company_name }}</th>
                    <th>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</th>
                </tr>
            </table>
        </div>

        <div class="col-xs-6">
            <h3 class="text-right">
                <img src="{{ public_path('images/winwin-logo.png') }}" style="width: 300px;">

                <br>

                Management (UK) Ltd
            </h3>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <table class="table table-bordered">
                <tr>
                    <th class="col-xs-3">Sales Person</th>
                    <th class="col-xs-3">Lead Gen</th>
                    <th class="col-xs-2">Distributor</th>
                    <th class="col-xs-2">Network</th>
                    <th class="col-xs-1">Term</th>
                    <th class="col-xs-1">Review</th>
                </tr>
                <tr>
                    <th>{{ $opportunity->activeAssigned->first()->name }}</th>
                    <th>{{ $opportunity->creator->name }}</th>
                    <th>Chess</th>
                    <th>O2</th>
                    <th>{{ $term }}</th>
                    <th>12</th>
                </tr>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <table class="table table-bordered">
                <tr>
                    <th class="col-xs-3">Registered Address</th>
                    <th class="col-xs-3">Trading Address</th>
                    <th class="col-xs-3">Billing Address</th>
                    <th class="col-xs-3">Delivery Address</th>
                </tr>
                <tr>
                    <td>{{ $opportunity->salesInformation->address_2_line_1 }}</td>
                    <td>{{ $opportunity->salesInformation->address_1_line_1 }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>{{ $opportunity->salesInformation->address_2_line_2 }}</td>
                    <td>{{ $opportunity->salesInformation->address_1_line_2 }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>{{ $opportunity->salesInformation->address_2_line_3 }}</td>
                    <td>{{ $opportunity->salesInformation->address_1_line_3 }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>{{ $opportunity->salesInformation->address_2_line_4 }}</td>
                    <td>{{ $opportunity->salesInformation->address_1_line_4 }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>{{ $opportunity->salesInformation->address_2_line_5 }}</td>
                    <td>{{ $opportunity->salesInformation->address_1_line_5 }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>{{ $opportunity->salesInformation->address_2_postcode }}</td>
                    <td>{{ $opportunity->salesInformation->address_1_postcode }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <table class="table table-bordered">
                <tr>
                    <th colspan="2" class="text-center">Account Holder Details</th>
                </tr>
                <tr>
                    <th class="col-xs-7">Account Holder Name</th>
                    <td>{{ $opportunity->salesInformation->account_holder_full_name }}</td>
                </tr>
                <tr>
                    <th>Additional Contact Person</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Telephone Number</th>
                    <td>{{ $opportunity->salesInformation->landline_number }}</td>
                </tr>
                <tr>
                    <th>Mobile Number</th>
                    <td>{{ $opportunity->salesInformation->mobile_number }}</td>
                </tr>
                <tr>
                    <th>Fax Number</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Email Address 1</th>
                    <td>{{ $opportunity->salesInformation->email }}</td>
                </tr>
                <tr>
                    <th>Email Address 2</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Limited Company Number</th>
                    <td>Y / N</td>
                </tr>
                <tr>
                    <th>Sole Trader Proofs</th>
                    <td>Y / N</td>
                </tr>
                <tr>
                    <th>Director Proof</th>
                    <td>Y / N</td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <th colspan="2" class="text-center">Operations Use Only</th>
                </tr>
                <tr>
                    <th class="col-xs-7">Account Number</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Credit Check Result</th>
                    <td></td>
                </tr>
                <tr>
                    <th>CIF Sent to Customer</th>
                    <td></td>
                </tr>
                <tr>
                    <th>CIF Recieved From Customer</th>
                    <td></td>
                </tr>
                <tr>
                    <th>PAC Requested</th>
                    <td></td>
                </tr>
                <tr>
                    <th>PAC Code</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Stock Ordered</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Welcome Call</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Buyout / DI Self Bill Raised</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Hardware Fund Self Bill Raised</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Connection Date</th>
                    <td></td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <th colspan="2" class="text-center">Deal Notes / Deal Breakdown</th>
                </tr>
                <tr>
                    <th class="col-xs-7">BCAD Code</th>
                    <td></td>
                </tr>
                <tr>
                    <th>BCAD Line Rental Value</th>
                    <td>£{{ $dealCalculator->overview->bcad }}</td>
                </tr>
                <tr>
                    <th>Monthly Line Rental Before Disc</th>
                    <td>£{{ $dealCalculator->overview->lineRental }}</td>
                </tr>
                <tr>
                    <th>Monthly Line Rental After Disc</th>
                    <td>£{{ $dealCalculator->overview->monthlyLineRental }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="min-height: 200px">
                            {{ $opportunity->salesInformation->special_requirements }}
                            &nbsp;
                        </div>
                    </td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <th class="col-xs-7">Director Sign Off</th>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <th>Operations Sign Off</th>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>

        <div class="col-xs-6">
            <table class="table table-bordered">
                <tr>
                    <th class="col-xs-4">Tariff Details</th>
                    <th class="col-xs-4">Total N/C</th>
                    <th class="col-xs-4">Total UPS</th>
                </tr>
                <tr>
                    <td>Below</td>
                    <td>{{ $dealCalculator->countNewConnections() }}</td>
                    <td>{{ $dealCalculator->countUpgradeConnections() }}</td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <th colspan="4" class="text-center">Tariff Income</th>
                </tr>
                <tr>
                    <th class="col-xs-5">Tariff Description</th>
                    <th class="col-xs-2">Qty</th>
                    <th class="col-xs-2">GP</th>
                    <th class="col-xs-3">Total GP</th>
                </tr>

                @foreach($tariffs as $connection)
                    <tr>
                        <td>{{ $connection->tariff->type->name . ' ' . $connection->tariff->tariff_code }}</td>
                        <td>{{ $connection->connections }}</td>
                        <td>£{{ number_format($connection->gp, 2) }}</td>
                        <td>£{{ number_format($connection->connections * $connection->gp, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="3" class="text-right">Total</th>
                    <td>{{ number_format($tariffTotal, 2) }}</td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <th colspan="4" class="text-center">VAS/Additional Income</th>
                </tr>
                <tr>
                    <th class="col-xs-5">VAS Description</th>
                    <th class="col-xs-2">Qty</th>
                    <th class="col-xs-2">GP</th>
                    <th class="col-xs-3">Total GP</th>
                </tr>

                @foreach($vas as $connection)
                    <tr>
                        <td>{{ $connection->tariff->type->name . ' ' . $connection->tariff->tariff_code }}</td>
                        <td>{{ $connection->connections }}</td>
                        <td>£{{ number_format($connection->gp, 2) }}</td>
                        <td>£{{ number_format($connection->connections * $connection->gp, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="3" class="text-right">Total</th>
                    <th>{{ number_format($vasTotal, 2) }}</th>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <th class="col-xs-6">Total Income</th>
                    <th>£{{ number_format($totalIncome, 2) }}</th>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <th colspan="4" class="text-center">Handsets and SIMs</th>
                </tr>
                <tr>
                    <th class="col-xs-5">Make/Model/Colour</th>
                    <th class="col-xs-2">Qty</th>
                    <th class="col-xs-2">GP</th>
                    <th class="col-xs-3">Total GP</th>
                </tr>
                @foreach($dealCalculator->handsets as $handset)
                    <tr>
                        <td>
                            @if($handset->handset)
                                {{ $handset->handset->name }}
                            @else
                                {{ $handset->name }}
                            @endif

                            @if($handset->colour)
                                in {{ $handset->colour }}
                            @endif
                        </td>
                        <td>{{ $handset->units }}</td>
                        <td>£{{ number_format($handset->value, 2) }}</td>
                        <td>£{{ number_format($handset->units * $handset->value, 2) }}</td>
                    </tr>
                @endforeach

                @if($dealCalculator->getSimCards() && $dealCalculator->getSimCards()->units > 0)
                    <tr>
                        <td>
                            SIM Cards
                        </td>
                        <td>{{ $dealCalculator->getSimCards()->units }}</td>
                        <td>£{{ number_format($dealCalculator->getSimCards()->value, 2) }}</td>
                        <td>
                            £{{ number_format($simCardTotal, 2) }}</td>
                    </tr>
                @endif

                @if($dealCalculator->getHardwareFund() && $dealCalculator->getHardwareFund()->total > 0)
                    <tr>
                        <td>
                            Hardware Fund
                        </td>
                        <td>{{ $dealCalculator->getHardwareFund()->units }}</td>
                        <td>£{{ number_format($dealCalculator->getHardwareFund()->value, 2) }}</td>
                        <td>
                            £{{ number_format($dealCalculator->getHardwareFund()->total, 2) }}</td>
                    </tr>
                @endif
                <tr>
                    <th colspan="3" class="text-right">Total</th>
                    <th>

                        £{{ number_format($handsetTotal, 2) }}
                    </th>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <th colspan="4" class="text-center">Unlock Fees</th>
                </tr>
                @if($dealCalculator->getUnlockFeeCards())
                    <tr>
                        <th class="col-xs-4">Qty</th>
                        <th class="col-xs-4">GP</th>
                        <th class="col-xs-4">Total GP</th>
                    </tr>
                    <tr>
                        <td>{{ $dealCalculator->getUnlockFeeCards()->units }}</td>
                        <td>£{{ $dealCalculator->getUnlockFeeCards()->value }}</td>
                        <td>£{{ $dealCalculator->getUnlockFeeCards()->total }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="4" class="text-center">No Unlock Fees</td>
                    </tr>
                @endif
            </table>

            <table class="table table-bordered">
                <tr>
                    <th colspan="4" class="text-center">Commission Breakdown</th>
                </tr>
                <tr>
                    <th class="col-xs-7">Total GP</th>
                    <td>£ {{ number_format($totalGp, 2) }}</td>
                </tr>
                <tr>
                    <th>Buyout</th>
                    <td>£{{ number_format($dealCalculator->getBuyout(), 2) }}</td>
                </tr>
                <tr>
                    <th>Deal Incentive</th>
                    <td>£{{ number_format($dealCalculator->getCashBack(), 2) }}</td>
                </tr>
                <tr>
                    <th>Handset Charge (ex vat)</th>
                    <td>£{{ number_format($dealCalculator->getCustomerContribution(), 2) }}</td>
                </tr>
                <tr>
                    <th>Total Net GP</th>
                    <td>£{{ number_format($dealCalculator->overview->totalProfit, 2) }}</td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <th class="col-xs-3">Closing Fee</th>
                    <td class="col-xs-3">£{{ number_format(($dealCalculator->overview->handlingFee / 2), 2) }}</td>
                    <th class="col-xs-3">OPS Fee</th>
                    <td class="col-xs-3">£{{ number_format(($dealCalculator->overview->handlingFee / 2), 2) }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

</body>
</html>

