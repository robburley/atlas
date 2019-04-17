<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Proposal | {{ $customer->company_name }}</title>

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

        .big-purple-panel {
            background-color: #93278f;
            color: #fff;
            margin-left: 50px;
            margin-right: 50px;
            margin-top: 150px;
            padding: 50px;
        }

        .underline-purple {
            padding-bottom: 5px;
            border-bottom: 1px solid #93278f;
            margin-bottom: 20px;
        }

        .underline-blue {
            padding-bottom: 5px;
            border-bottom: 1px solid #00adef;
            margin-bottom: 20px;
        }

        .ticks ul {
            list-style: none;
        }

        .ticks li {
            list-style: none;
            margin-bottom: 7px;
        }

        .ticks li:before {
            font-family: 'FontAwesome';
            content: '\f00c';
            margin: 0 5px 0 -15px;
        }

        .purple {
            color: #93278f;
        }

        .sub-li {
            list-style: none;
        }

        p {
            font-size: 13px;
        }

        body {
            font-size: 13px;
        }

        h3 {
            font-size: 16px;
        }

        .table {
            font-size: 13px !important;
        }

        .text-purple {
            color: #93278f;
        }

        .text-blue {
            color: #00adef;
        }

        .table > thead > tr > td, .table > tbody > tr > td, .table > tfood > tr > td, .table > thead > tr > th, .table > tbody > tr > th, .table > tfood > tr > th {
            padding: 1.5px 10px;
        }

        .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
            border-color: #93278f;
        }

        .table-bordered {
            border-color: #93278f;
        }
    </style>
</head>
<body>

<div class="pdf-container">
    @{{ #bankname=*bank_es_:text }}
    @{{ #account=*account_es_:text }}
    @{{ #sortCode=*sortCode_es_:text }}
    <div class="row" style="padding-top: 25px;">
        <div class="col-xs-6">
            <img src="{{ public_path('images/winwin-logo.png') }}" style="width: 150px;" alt="Win Win">
        </div>
        <div class="col-xs-6 text-right">
            <h4 class="text-purple">Customer Order Form</h4>
            <h4 class="text-blue">01270 440 140</h4>
        </div>
        <h4 class="underline-blue">Customer Details</h4>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th class="col-xs-6">Company Name</th>
                    <td>{{ $opportunity->customerInformation->company }}</td>
                </tr>
                <tr>
                    <th colspan="2" class="text-center">Registered Address</th>
                </tr>
                <tr>
                    <th class="col-xs-6">Building Name/No</th>
                    <td>{{ $opportunity->customerInformation->address_1 }}</td>
                </tr>
                <tr>
                    <th class="col-xs-6">Street</th>
                    <td>{{ $opportunity->customerInformation->address_2 }}</td>
                </tr>
                <tr>
                    <th class="col-xs-6">Town</th>
                    <td>{{ $opportunity->customerInformation->address_3 }}</td>
                </tr>
                <tr>
                    <th class="col-xs-6">County</th>
                    <td>{{ $opportunity->customerInformation->address_4 }}</td>
                </tr>
                <tr>
                    <th class="col-xs-6">Postcode</th>
                    <td>{{ $opportunity->customerInformation->postcode }}</td>
                </tr>
                <tr>
                    <th class="col-xs-6">Registered Number</th>
                    <td>{{ $opportunity->customerInformation->registed_number }}</td>
                </tr>
                <tr>
                    <th class="col-xs-6">Install Address</th>
                    <td>{{ $opportunity->customerInformation->install_address }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xs-6">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th class="col-xs-6">Customer Name</th>
                    <td>{{ $opportunity->customerinformation->customer_name }}</td>
                </tr>
                <tr>
                    <th class="col-xs-6">Position</th>
                    <td>{{ $opportunity->customerInformation->position }}</td>
                </tr>
                <tr>
                    <th class="col-xs-6">Email</th>
                    <td>{{ $opportunity->customerInformation->email }}</td>
                </tr>
                <tr>
                    <th class="col-xs-6">Billing Email</th>
                    <td>{{ $opportunity->customerInformation->billing_email }}</td>
                </tr>
                <tr>
                    <th class="col-xs-6">Office Number</th>
                    <td>{{ $opportunity->customerInformation->office_number }}</td>
                </tr>
                <tr>
                    <th class="col-xs-6">Mobile Number</th>
                    <td>{{ $opportunity->customerInformation->mobile_number }}</td>
                </tr>
                </tbody>
            </table>
            <table class="table table-bordered" style="max-width: 100%;">
                <tbody>
                <tr>
                    <th class="col-xs-4">Email or Paper Billing</th>
                    <th class="col-xs-4">DD or BACS</th>
                    <th class="col-xs-4">Term</th>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>DD</td>
                    <td>{{ $opportunity->commercials->term }}</td>
                </tr>

                <tr>
                    <th>Bank name</th>
                    <th>Account Number</th>
                    <th>Sort Code</th>
                </tr>
                <tr>
                    <td>@{{$bankname}}</td>
                    <td>@{{$account}}</td>
                    <td>@{{$sortCode}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <h4 class="underline-blue">Package Details</h4>

        <div class="col-xs-12">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th class="v-mid text-center">Type</th>
                    <th class="v-mid text-center">Telephone <br> Number</th>
                    <th class="v-mid text-center col-xs-1">Monthly <br> Line Rental</th>
                    <th class="v-mid text-center">Installation <br> Postcode</th>
                    <th class="v-mid text-center col-xs-1">1571</th>
                    <th class="v-mid text-center col-xs-1">Call <br> Divert</th>
                    <th class="v-mid text-center col-xs-1">Call <br> Waiting</th>
                    <th class="v-mid text-center col-xs-1">Caller <br> Display</th>
                    <th class="v-mid text-center">Broadband <br> on this number</th>
                </tr>
                @foreach($opportunity->commercials->lines as $line)
                    <tr>
                        <td class="text-center">
                            @if($line->type == 1)
                                New Line
                            @else
                                Transfer
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $line->telephone_number }}
                        </td>
                        <td class="text-center">
                            £{{ number_format($line->monthly_line_rental, 2, '.', ',') }}
                        </td>
                        <td class="text-center">
                            {{ $line->installation_postcode }}
                        </td>
                        <td class="text-center">
                            @if($line->has1571 == 1)
                                <i class="fa fa-fw fa-check"></i>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($line->call_divert == 1)
                                <i class="fa fa-fw fa-check"></i>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($line->call_waiting == 1)
                                <i class="fa fa-fw fa-check"></i>
                            @endif

                        </td>
                        <td class="text-center">
                            @if($line->caller_display == 1)
                                <i class="fa fa-fw fa-check"></i>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($line->broadband == 0)
                                None
                            @elseif($line->broadband == 1)
                                Fibre
                            @elseif($line->broadband == 2)
                                ASDL
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <h4 class="underline-blue">Call Bundles</h4>

    </div>
    <div class="row">
        <div class="col-xs-4 text-center">
            <p class="text-purple">Tariff</p>
            <p class="">
                @if($opportunity->commercials->tariff == 1)
                    Standard
                @elseif($opportunity->commercials->tariff == 2)
                    Saver (£5)
                @else
                    Custom
                @endif
            </p>
        </div>

        @if($opportunity->commercials->call_bundle_local_national > 0)
            <div class="col-xs-4 text-center">
                <p class="text-purple">1000 mins Local & National</p>
                <p class="">
                    £{{ number_format($opportunity->commercials->call_bundle_local_national, 2, '.', ',') }}
                </p>
            </div>
        @endif

        @if($opportunity->commercials->call_bundle_mobile)
            <div class="col-xs-4 text-center">
                <p class="text-purple">500 mins UK Std Mobile</p>
                <p class="">
                    £{{ number_format($opportunity->commercials->call_bundle_mobile, 2, '.', ',') }}
                </p>
            </div>
        @endif
    </div>

    <div class="row">
        @if($opportunity->commercials->tariff == 3)
            <h4 class="underline-blue">Custom Tariff Prices</h4>

            <div class="col-xs-2 text-center">
                <p class="text-purple">Local</p>
                <p class="">
                    {{ number_format($opportunity->commercials->custom_local, 2, '.', ',') }} PPM
                </p>
            </div>
            <div class="col-xs-2 text-center">
                <p class="text-purple">National</p>
                <p class="">
                    {{ number_format($opportunity->commercials->custom_national, 2, '.', ',') }} PPM
                </p>
            </div>
            <div class="col-xs-2 text-center">
                <p class="text-purple">Vodafone</p>
                <p class="">
                    {{ number_format($opportunity->commercials->custom_vodafone, 2, '.', ',') }} PPM
                </p>
            </div>
            <div class="col-xs-2 text-center">
                <p class="text-purple">O2</p>
                <p class="">
                    {{ number_format($opportunity->commercials->custom_o2, 2, '.', ',') }} PPM
                </p>
            </div>
            <div class="col-xs-2 text-center">
                <p class="text-purple">EE</p>
                <p class="">
                    {{ number_format($opportunity->commercials->custom_ee, 2, '.', ',') }} PPM
                </p>
            </div>
            <div class="col-xs-2 text-center">
                <p class="text-purple">3</p>
                <p class="">
                    {{ number_format($opportunity->commercials->custom_three, 2, '.', ',') }} PPM
                </p>
            </div>
        @endif
    </div>


    <div class="row">
        <h4 class="underline-blue">Total Costs</h4>

        <div class="col-xs-3 text-center">
            <p class="text-blue">
                Monthly <br> Line Rental
            </p>

            <p class="">
                £{{ number_format($opportunity->commercials->monthly_line_rental, 2, '.', ',') }} per month
            </p>
        </div>
        <div class="col-xs-3 text-center">
            <p class="text-blue">
                Monthly <br> Features Rental
            </p>

            <p class="">
                £{{ number_format($opportunity->commercials->monthly_features_rental, 2, '.', ',') }} per month
            </p>
        </div>
        <div class="col-xs-3 text-center">
            <p class="text-blue">
                Total Monthly <br> Recurring Charges
            </p>

            <p class="">
                £{{ number_format($opportunity->commercials->total_monthly_recurring_charges, 2, '.', ',') }} per month
            </p>
        </div>
        <div class="col-xs-3 text-center">
            <p class="text-blue">
                Total <br> Setup Charge
            </p>

            <p class="">
                £{{ number_format($opportunity->commercials->total_setup_install_charges, 2, '.', ',') }}
            </p>
        </div>
    </div>

    <div class="row">
        <h4 class="underline-blue">Notes</h4>

        <div class="col-xs-12">
            {{ $opportunity->commercials->note }}
        </div>
    </div>

    <div class="row">
        <h4 class="underline-blue">Customer Acceptance and Declaration</h4>

        <div class="col-xs-12">
            <p>
                By signing this Order Form you confirm that you are authorised to do so. You have read and agree to be
                bound
                by the Terms and Conditions available at www.winwincr.co.uk and authorise the transfer of the Services
                detailed within the Package to Win Win Management (UK) Ltd. This offer is subject to survey and
                acceptance
                by Win Win Management (UK) Ltd. The contract term begins on the Commencement date of the Services.
            </p>

            <br>

            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th class="col-xs-2 v-mid" style="height:30px">Customer Name</th>
                    <td class="v-mid" style="height:30px">@{{*name_es_:text }}</td>
                    <th class="col-xs-2 v-mid" style="height:30px">Position</th>
                    <td class="v-mid" style="height:30px">@{{*posotion_es_:text }}</td>
                </tr>
                <tr>
                    <th class="col-xs-2 v-mid" style="height:30px">Signature</th>
                    <td class="v-mid" style="height:30px">@{{*Sig_es_:signer1:signature}}</td>
                    <th class="col-xs-2 v-mid" style="height:30px">Date</th>
                    <td class="v-mid" style="height:30px">@{{Dte_es_:signer1:date}}</td>
                </tr>
                </tbody>
            </table>

            <br>

            <p class="text-center">Powered by Gteq Solutions Ltd</p>

        </div>
    </div>
</div>

<div style="page-break-after: always; margin-top:2px;"></div>

<div class="pdf-container">
    <div class="row" style="padding-top: 25px;">
        <div class="col-xs-3">
            <img src="{{ public_path('images/winwin-logo.png') }}" style="width: 150px;" alt="Win Win">
        </div>
        <div class="col-xs-6 text-center">
            <h2>
                Instruction to your Bank of Building Society to pay by Direct Debit
            </h2>
        </div>
        <div class="col-xs-3 text-right">
            <img src="{{ public_path('images/direct-debit.png') }}" style="width: 150px;" alt="Win Win">
        </div>
    </div>
    <div class="row" style="padding-top: 25px;">
        <div class="col-xs-6">
            <h4>Please fill in the whole form and send it to:</h4>
            <div style="border:1px solid; padding: 20px">
                <p>
                    Win Win Management (UK) Limited <br>
                    Oak Bank Business Centre, <br>
                    Mickley Hall Lane, <br>
                    Broomhall, <br>
                    Nantwich, <br>
                    Cheshire <br>
                    CW5 8AH
                </p>
            </div>
        </div>
        <div class="col-xs-6">
            <h4>Service User Number</h4>

            <h4 style="margin-top:15px;">
                <span style="padding: 5px; border:1px solid;">2</span>
                <span style="padding: 5px; border:1px solid;">5</span>
                <span style="padding: 5px; border:1px solid;">8</span>
                <span style="padding: 5px; border:1px solid;">9</span>
                <span style="padding: 5px; border:1px solid;">2</span>
                <span style="padding: 5px; border:1px solid;">3</span>
            </h4>
        </div>
    </div>

    <div class="row" style="padding-top: 25px;">
        <div class="col-xs-6">
            <h4>Name(s) of Account Holder(s)</h4>
            <input type="text" class="form-control" value="@{{*accountname1_es_:text}}"> <br>
            <input type="text" class="form-control" value="@{{accountname2_es_:text}}">
        </div>

        <div class="col-xs-6">
            <h4>Reference</h4>
            <input type="text" class="form-control" value="@{{*reference_es_:text}}">
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <h4>Bank/Building Society account number</h4>
            <input type="text" class="form-control" value="@{{*bankaccount2_es_:text}}">
            <h4>Branch Sort Code</h4>
            <input type="text" class="form-control" value="@{{*sortcode2_es_:text}}">
        </div>

        <div class="col-xs-6">
            <h4>Instruction to your <strong>Bank or Building Society</strong></h4>
            <h4>Please pay L&Z Re <strong>Win Win Management.</strong> Direct Debits from the account detailed in this
                Instruction subject to safeguards assured by the Direct Debit Guarantee. I understand that this
                Instruction may remain with L&Z Re <strong>Win Win Management</strong> and, if so, details will be
                passed electronically to my Bank/Building Society.</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h4>Name and full postal address of your Bank or Building Society</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <p>Bank/Building Society</p>
            <input type="text" class="form-control" value="@{{*bankname_es_:text}}">
        </div>
        <div class="col-xs-6">
            <p>Signature(s)</p>
            <input type="text" class="form-control" value="@{{*Sig2_es_:signer1:signature}}">
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <h4>Address</h4>
            <input type="text" class="form-control" value="@{{*verylongaddressfieldwithmeaninglesswords_es_:text}}">

            <h4>Postcode</h4>
            <input type="text" class="form-control" value="@{{*postcode2_es_:text}}">
        </div>
        <div class="col-xs-6">
            <h4>Date</h4>
            <input type="text" class="form-control" value="@{{Dte2_es_:signer1:date}}">
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-center">
            <h4>Banks and Building Societies may not accept Direct Debit Instructions for some types of account.</h4>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-xs-12 text-center">
            <h4>
                This guarantee should be detached and retained by the Payer
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h4 class="text-center">
                <strong>
                    The Direct Debit Guarantee
                </strong>
            </h4>
            <ul>
                <li>
                    <h4>
                        This Guarantee is offered by all banks and building societies that accept instructions to pay
                        Direct Debits
                    </h4>
                </li>
                <li>
                    <h4>
                        If there are any changes to the amount, date or frequency of your Direct Debit L&Z re Win Win
                        Management will notify you 3 working days in advance of your account being debited or as
                        otherwise agreed. If you request L&Z re Win Win Management to collect a payment, confirmation of
                        the amount and date will be given to you at the time of the request
                    </h4>
                </li>
                <li>
                    <h4>
                        If an error is made in the payment of your Direct Debit, by L&Z re Win Win Management or your
                        bank or building society you are entitled to a full and immediate refund of the amount paid from
                        your bank or building society <br>
                        If you receive a refund you are not entitled to, you must pay it back when L&Z re Win Win
                        Management asks you to.

                    </h4>
                </li>
                <li>
                    <h4>
                        You can cancel a Direct Debit at any time by simply contacting your bank or building society.
                        Written confirmation may be required. Please also notify us.
                    </h4>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 text-center">
            <img src="{{ public_path('images/direct-debit.png') }}" style="width: 150px;" alt="Win Win">
        </div>
    </div>


</div>

</body>
</html>

