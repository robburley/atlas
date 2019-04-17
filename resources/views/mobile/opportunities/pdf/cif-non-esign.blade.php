@php
    $info = $opportunity->salesInformation;
@endphp
        <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Purchase Order | {{ $dealCalculator->name  }}</title>

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

        .ticks ul {
            list-style: none;
        }

        .ticks li {
            margin-bottom: 5px;
        }

        .ticks li:before {
            font-family: 'FontAwesome';
            content: '\f00c';
            margin: 0 5px 0 -15px;
        }

        p {
            font-size: 12px;
        }

        body {
            font-size: 12px;
        }

        .terms-and-conditions {
            font-size: 10px;
        }

        .purple-box {
            float: left;
            width: 100%;
            height: 40px;
            border: 1px solid #93278f;
            margin-top: 5px;
            margin-bottom: 5px;
            padding: 5px;
            padding-top: 10px;
            overflow: hidden;
            text-align: center;
        }

        .terms-section {
            font-size: 10px;
        }

        .letterhead {
            position: absolute;
            top: 0;
            left: 0;
            z-index: -999;
            width-height: 100%;
        }

        .table-bordered-blue > thead > tr > th, .table-bordered-blue > tbody > tr > th, .table-bordered-blue > tfoot > tr > th, .table-bordered-blue > thead > tr > td, .table-bordered-blue > tbody > tr > td, .table-bordered-blue > tfoot > tr > td {
            border-color: #5467C8 !important;
        }

        .rotated-text {
            position:absolute; 
            top:   535px; 
            right: -55px;
            width: 150px;
            -webkit-transform: rotate(-90deg);
            -moz-transform: rotate(-90deg);
            -ms-transform: rotate(-90deg);
            -o-transform: rotate(-90deg);
            filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
        }
    </style>
</head>
<body>

<div class="pdf-container">
    <div class="row">
        <div class="col-xs-6">
            <img src="{{ public_path('images/o2-logo.png') }}" style="margin-top:20px; margin-left: 80px;">
            <h3><strong>Business Contract application</strong></h3>
        </div>
        <div class="col-xs-6">
            <strong style="margin-left: 20px; color: #44DDED;">DISE</strong> O<sub style="font-size:0.8em;">2</sub> Contract No. <strong style="font-size: 1.3em;">BA1</strong>

            <table class="table table-bordered table-bordered-blue">
                <tr>
                    <td class="col-xs-6">
                        Retailer <strong>Win Win</strong>
                    </td>
                    <td class="col-xs-6">
                        Salesperson
                    </td>
                </tr>

                <tr>
                    <td>
                        SOS code
                    </td>
                    <td>
                        Telephone No. <strong>01270 440140 </strong>
                    </td>
                </tr>

                <tr>
                    <td>
                        Sales Manager
                    </td>
                    <td>
                        Signature
                    </td>
                </tr>
            </table>

            <table style=" font-size: 0.8em;">
                <tr>
                    <td class="col-xs-4" style="vertical-align: top;">
                        <strong>WHITE original</strong>
                    </td>
                    <td class="col-xs-8" style="vertical-align: top;">
                        Telefónica UK Limited, New Business Dept. Preston Brook, Runcorn, Cheshire WA7 3QA
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-4" style="vertical-align: top;">
                        <strong>PINK copy</strong>
                    </td>
                    <td class="col-xs-8" style="vertical-align: top;">
                        Customer
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-4" style="vertical-align: top;">
                        <strong>BLUE copy</strong>
                    </td>
                    <td class="col-xs-8" style="vertical-align: top;">
                        Retailer
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h4 style="color: #44DDED;">
                <strong>
                    About you and your company
                </strong>
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12" style="border: 1px solid #5467C8; background-color: #f2fdff; padding: 0 0 10px 0;">
            <div class="col-xs-6" style="margin-top: 10px; padding: 0;">
                <div class="col-xs-12">
                    <strong>1. Company details</strong> 
                </div>

                <div class="col-xs-12" style="margin-top:10px;">
                    <div class="col-xs-4">
                        Company name
                    </div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;" value="{{ $info->business_name }}">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4" style="">
                        Address
                    </div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                               value="{{ $info->address_1_line_1 }}, {{ $info->address_1_line_2 }}">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4" style="">
                    </div>
                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                               value="{{ $info->address_1_line_3 }}, {{ $info->address_1_line_4 }}">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4">

                    </div>
                    <div class="col-xs-3" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                    <div class="col-xs-2">
                        Postcode
                    </div>

                    <div class="col-xs-3" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                               value="{{ $info->address_1_postcode }}">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4">
                        Telephone
                    </div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;" value="{{ $info->landline_number }}">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4">
                        Email address
                    </div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;" value="{{ $info->email }}">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4">
                        <strong>Registered office</strong>
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4">
                        Address
                    </div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                               value="{{ $info->address_2_line_1 }}, {{ $info->address_2_line_2 }}">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4"></div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                               value="{{ $info->address_2_line_3 }}, {{ $info->address_2_line_4 }}">
                    </div>
                </div>


                <div class="col-xs-12">
                    <div class="col-xs-4">

                    </div>
                    <div class="col-xs-3" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                    <div class="col-xs-2">
                        Postcode
                    </div>

                    <div class="col-xs-3" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                               value="{{ $info->address_2_postcode }}">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4">
                        Co. reg. no.
                    </div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;" value="{{ $info->company_number }}">
                    </div>
                </div>

                <div class="col-xs-12">
                    <strong>2. Invoice address</strong>
                </div>

                <div class="col-xs-12" style="margin-top:10px;">
                    <div class="col-xs-4" style=""></div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4" style=""></div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4" style=""></div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4">

                    </div>
                    <div class="col-xs-3" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                    <div class="col-xs-2">
                        Postcode
                    </div>

                    <div class="col-xs-3" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4" style="">
                        Telephone
                    </div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

            </div>


            <div class="col-xs-6" style="margin-top: 10px; padding: 0;">
                <div class="col-xs-12">
                    <strong>3. Director details</strong>
                </div>

                <div class="col-xs-12" style="margin-top:10px;">
                    <div class="col-xs-4" style="padding-right: 0;">
                        Title
                    </div>

                    <div class="col-xs-8" style="padding: 0;">
                        <small>
                        Mr <input type="checkbox" @if(strtolower($info->account_holder_title) == 'mr') checked @endif>
                        Mrs <input type="checkbox" @if(strtolower($info->account_holder_title) == 'mrs') checked @endif>
                        Miss <input type="checkbox" @if(strtolower($info->account_holder_title) == 'miss') checked @endif>
                        Ms <input type="checkbox" @if(strtolower($info->account_holder_title) == 'ms') checked @endif>
                        other (please specify) <input type="text" style="width:12%; margin-bottom: 5px;"
                               value="{{ collect(['mr','mrs','miss','ms'])->contains(strtolower($info->account_holder_title)) ? '' : $info->account_holder_title  }}">
                        </small>
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4" style="padding-right: 0;">
                        Forenames
                    </div>

                    <div class="col-xs-3" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;" value="{{ $info->account_holder}}">
                    </div>

                    <div class="col-xs-2" style="padding-right: 0;">
                        Surname
                    </div>

                    <div class="col-xs-3" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                               value="{{ $info->account_holder_last_name}}">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4" style="">
                        Address
                    </div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                                value="{{ $info->address_2_line_1 }}, {{ $info->address_2_line_2 }}"
                        >
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4" style="">
                    </div>
                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                                value="{{ $info->address_2_line_3 }}, {{ $info->address_2_line_4 }}"
                        >
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4">

                    </div>
                    <div class="col-xs-3" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                    <div class="col-xs-2">
                        Postcode
                    </div>

                    <div class="col-xs-3" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                                value="{{ $info->address_2_postcode }}"
                        >
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4" style="padding-right: 0;">
                        Date of birth
                    </div>

                    <div class="col-xs-3" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                               value="{{ $info->date_of_birth ? $info->date_of_birth->format('d/m/Y') :  '' }}">
                    </div>

                    <div class="col-xs-3" style="padding-right: 0;">
                        <span style="font-size:0.8em;">Time at this address</span>
                    </div>

                    <div class="col-xs-2" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                                value="{{ $info->address_2_time_at_address > 3 ? $info->address_2_time_at_address : 3 }} {{ str_plural('Years', $info->address_2_time_at_address > 3 ? $info->address_2_time_at_address : 3) }}"
                        >
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4" style="padding-right: 0;">
                        Home tel no.
                    </div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-12">
                        Previous address (If less than 3 years)
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4" style="padding-right: 0;">
                        Address
                    </div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4" style="padding-right: 0;">

                    </div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>


                <div class="col-xs-12">
                    <div class="col-xs-4">

                    </div>
                    <div class="col-xs-3" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                    <div class="col-xs-2">
                        Postcode
                    </div>

                    <div class="col-xs-3" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-12">
                        <strong>4. Delivery address</strong>
                    </div>
                </div>

                <div class="col-xs-12" style="margin-top:10px;">
                    <div class="col-xs-4" style="padding-right: 0;">
                        Title
                    </div>

                    <div class="col-xs-8" style="padding: 0;">
                        <small>
                        Mr <input type="checkbox">
                        Mrs <input type="checkbox">
                        Miss <input type="checkbox">
                        Ms <input type="checkbox">
                        other (please specify) <input type="text" style="width:12%; margin-bottom: 5px;">
                        </small>
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4" style="padding-right: 0;">
                        Forenames
                    </div>

                    <div class="col-xs-3" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>

                    <div class="col-xs-2" style="padding-right: 0;">
                        Surname
                    </div>

                    <div class="col-xs-3" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4" style="padding-right: 0;">
                        Job title
                    </div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4" style="padding-right: 0;">
                        Address
                    </div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="col-xs-4" style="padding-right: 0;">
                    </div>

                    <div class="col-xs-8" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>


                <div class="col-xs-12">
                    <div class="col-xs-4">

                    </div>
                    <div class="col-xs-3" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                    <div class="col-xs-2">
                        Postcode
                    </div>

                    <div class="col-xs-3" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h4 style="color: #44DDED;">
                <strong>
                    About your new mobiles and services
                </strong>
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12" style="border: 1px solid #5467C8; background-color: #f7f7ff; padding: 0 0 10px 0;">
            <div class="col-xs-6" style="margin-top: 10px; padding: 0;">
                <div class="row" style="padding: 0 15px;">
                    <div class="col-xs-4">
                        <strong>5. Make/model</strong>
                    </div>

                    <div class="col-xs-4" style="padding: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>

                    <div class="col-xs-4" style="padding-right: 0;">
                        <span style="font-size: 0.7em">Please tick if upgrading</span> <input type="checkbox">
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-4" style="padding-right: 0;">
                        Mobile no.
                    </div>

                    <div class="col-xs-8" style="padding: 0; margin-left: -12px; margin-right: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-4" style="padding-right: 0;">
                        SIM card no.
                    </div>

                    <div class="col-xs-8" style="padding: 0; margin-left: -12px; margin-right: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-4" style="padding-right: 0;">
                        IMEI no.
                    </div>

                    <div class="col-xs-8" style="padding: 0; margin-left: -12px; margin-right: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="row" style="padding: 0 15px;">
                    <div class="col-xs-12">
                        Credit reference number
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-4" style="padding-right: 0;">
                    </div>

                    <div class="col-xs-8" style="padding: 0; margin-left: -12px; margin-right: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="row" style="padding: 0 15px;">
                    <div class="col-xs-12">
                        Existing O<sub style="font-size:0.8em;">2</sub> account no.
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-4" style="padding-right: 0;">
                    </div>

                    <div class="col-xs-8" style="padding: 0; margin-left: -12px; margin-right: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="row" style="padding: 0 15px;">
                    <div class="col-xs-12">
                        PAC code if porting
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-4" style="padding-right: 0;">
                    </div>

                    <div class="col-xs-8" style="padding: 0; margin-left: -12px; margin-right: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="row" style="padding: 0 15px;">
                    <div class="col-xs-12">
                        <strong>6. Is the Customer Requirements Form (CRF) attached?</strong>
                        <div style="float: right;">
                            YES <input type="checkbox">&nbsp;
                            NO <input type="checkbox" checked="checked">
                        </div>
                        <p>
                            <small>(applies to Best for Business only)</small>
                        </p>
                    </div>
                </div>

                <div class="row" style="padding: 5px 15px;">
                    <div class="col-xs-12">
                        <strong>
                            7. Service information Minimum Period 
                            <input type="text" style="width: 30px;" value="{{ $dealCalculator->getTerm() }}">
                            months
                        </strong>
                    </div>
                </div>

                <div class="row" style="padding: 5px 15px;">
                    <div class="col-xs-12">
                        <strong>8. Call bars removed?</strong>
                        <div class="col-xs-12">
                            <strong>Full international calls</strong> YES <input type="checkbox" checked="checked">
                            <strong>International roaming</strong> YES <input type="checkbox" checked="checked">
                        </div>
                    </div>
                </div>

                <div class="row" style="padding: 5px 15px;">
                    <div class="col-xs-12">
                        <strong>9. VAT exempt customer status (if applicable)</strong>
                        <div class="col-xs-12" style="padding-left: 75px;">
                            Customers claiming VAT exempt customer status should tick the appropriate box to confirm
                            their status: <br>
                            1. An Individual resident outside the European Union <input type="checkbox"
                                                                                        style="float: right;"> <br>
                            2. A business outside the European Union <input type="checkbox" style="float: right;"> <br>
                            3. A business in a European Union memer state other than the UK Customers should complete
                            form BT1972. Until this form is received VAT will be charged at the prevailing UK rate
                            <input type="checkbox" style="float: right;"> <br>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding: 5px 15px;">
                    <div class="col-xs-12">
                        International Traveller Service is included. <br>
                        For additional mobiles please add a continuation sheet.
                    </div>
                </div>
            </div>


            <div class="col-xs-6" style="margin-top: 10px; padding: 0;">
                <div class="row" style="padding: 5px 15px;">
                    <div class="col-xs-8">
                        <strong>
                            10. Monthly charges
                        </strong>
                    </div>
                    <div class="col-xs-4 text-right">
                        £ (ex VAT)
                    </div>
                </div>

                <div class="row" style="padding: 0 15px 0 35px;">
                    <div class="col-xs-12">
                        Business Call Plan <span style="font-size: 0.85em">Minimum period applies as stated in section 7.</span>
                    </div>

                    <div class="col-xs-8">

                        <input type="text" style="width:100%; margin-bottom: 5px;"
                               value="{{ $dealCalculator->getLead() && $dealCalculator->getLead()->tariff ? $dealCalculator->getLead()->tariff->type->name . ' ' . $dealCalculator->getLead()->tariff->tariff_code : '' }}">
                    </div>


                    @php($prices = explode('.', $dealCalculator->getLead() ? number_format($dealCalculator->getLead()->connections * $dealCalculator->getLead()->cost, 2) : 0.00))

                    <div class="col-xs-2" style="padding-right: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                        value="{{ $prices[0] }}">
                    </div>

                    <div class="col-xs-2">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                        value="{{ isset($prices[1]) ? $prices[1] : '' }}">
                    </div>
                </div>

                <div class="row" style="padding: 0 15px 0 35px;">
                    <div class="" style="float: left; width: 30%; padding: 0 0 0 15px; margin-bottom: 2px;">
                        Business Data Tariff 
                    </div>

                    <div class="" style="float: left; width: 70%; padding: 0 0 0 15px; margin-bottom: 2px;">
                        <span style="font-size: 0.85em">Minimum period applies. As stated in section 7 if taken without a Voice Tariff. Minimum of 12 months or term of voice contract</span>
                    </div>
                </div>

                <div class="row" style="padding: 0 15px 0 35px;">

                    <div class="col-xs-8">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>

                    <div class="col-xs-2" style="padding-right: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>

                    <div class="col-xs-2">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="row" style="padding: 0 15px 0 15px;">
                    <div class="col-xs-12">
                        <strong>
                            11. Optional extras
                        </strong>
                    </div>
                </div>

                <div class="row" style="padding: 0 15px 0 35px;">
                    <div class="col-xs-12">
                        Add up to 10 optional extras including shared minute Bolt Ons, shared messaging Bolt Ons or
                        unlimited messaging Bolt On.
                    </div>
                </div>

                <div class="row" style="padding: 0 15px 0 35px;">
                    <div class="col-xs-12">
                        <strong>Description</strong>
                    </div>
                </div>

                @foreach($dealCalculator->getSecondaries() as $secondary)
                    <div class="row" style="padding: 0 15px 0 35px;">
                        <div class="col-xs-8">
                            <input type="text" style="width:100%; margin-bottom: 5px;"
                                   value="{{ $secondary->connections . ' x ' . ($secondary->tariff ? $secondary->tariff->type->name . ' ' . $secondary->tariff->tariff_code : $secondary->tariff_name) }}">
                        </div>

                        @php($prices = explode('.', number_format($secondary->connections * $secondary->cost, 2)))

                        <div class="col-xs-2" style="padding-right: 0;">
                            <input type="text" style="width:100%; margin-bottom: 5px;"
                            value="{{ $prices[0] }}">
                        </div>

                        <div class="col-xs-2">
                            <input type="text" style="width:100%; margin-bottom: 5px;"
                            value="{{ isset($prices[1]) ? $prices[1] : '' }}">
                        </div>
                    </div>
                @endforeach

                @foreach($dealCalculator->secondaryConnections as $secondary)
                    <div class="row" style="padding: 0 15px 0 35px;">
                        <div class="col-xs-8">
                            <input type="text" style="width:100%; margin-bottom: 5px;"
                                   value="{{ $secondary->connections . ' x ' . ($secondary->tariff ? $secondary->tariff->type->name . ' ' . $secondary->tariff->tariff_code : $secondary->tariff_name) }}">
                        </div>

                        @php($prices = explode('.', number_format($secondary->connections * $secondary->cost, 2)))

                        <div class="col-xs-2" style="padding-right: 0;">
                            <input type="text" style="width:100%; margin-bottom: 5px;"
                            value="{{ $prices[0] }}">
                        </div>

                        <div class="col-xs-2">
                            <input type="text" style="width:100%; margin-bottom: 5px;"
                            value="{{ isset($prices[1]) ? $prices[1] : '' }}">
                        </div>
                    </div>
                @endforeach

                @for($i = (count($dealCalculator->getSecondaries()) + $dealCalculator->secondaryConnections->count()); $i < 10; $i++)
                    <div class="row" style="padding: 0 15px 0 35px;">
                        <div class="col-xs-8">
                            <input type="text" style="width:100%; margin-bottom: 5px;">
                        </div>

                        <div class="col-xs-2" style="padding-right: 0;">
                            <input type="text" style="width:100%; margin-bottom: 5px;">
                        </div>

                        <div class="col-xs-2">
                            <input type="text" style="width:100%; margin-bottom: 5px;">
                        </div>
                    </div>
                @endfor

                <div class="row" style="padding: 0 15px 0 35px;">
                    <div class="col-xs-12">
                        Shared minutes and messaging Bolt Ons 6 month minimum term applies
                    </div>
                </div>

                <div class="row" style="padding: 0 15px 0 15px;">
                    <div class="col-xs-8">
                        <strong>
                            12. TOTAL
                        </strong>
                    </div>
                        
                    @php($price = explode('.', number_format($dealCalculator->overview->lineRental, 2 )))

                    <div class="col-xs-2" style="padding-right: 0; padding-left: 21px;">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                        value="{{ $price[0] }}">
                    </div>

                    <div class="col-xs-2 padding-right:0">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                        value="{{ isset($price[1]) ? $price[1] : 0 }}">
                    </div>
                </div>

                <div class="row" style="padding: 5px 15px 5px 15px;">
                    <div class="col-xs-8">
                        <strong>
                            13. One-off payments
                        </strong>
                    </div>

                    <div class="col-xs-4 text-right">
                        £ (ex VAT)
                    </div>
                </div>

                <div class="row" style="padding: 0 15px 0 35px;">
                    <div class="col-xs-8">
                        Connection
                    </div>

                    <div class="col-xs-2" style="padding-right: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>

                    <div class="col-xs-2">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>

                <div class="row" style="padding: 0 15px 0 35px;">
                    <div class="col-xs-8">
                        Roaming deposit
                    </div>

                    <div class="col-xs-2" style="padding-right: 0;">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>

                    <div class="col-xs-2">
                        <input type="text" style="width:100%; margin-bottom: 5px;">
                    </div>
                </div>



                <div class="row" style="padding: 0 15px 0 15px;">
                    <div class="col-xs-8">
                        <strong>
                            14. GRAND TOTAL
                        </strong>
                    </div>
                        
                    @php($prices = explode('.', number_format($dealCalculator->overview->lineRental, 2)))
                    
                    <div class="col-xs-2" style="padding-right: 0; padding-left: 21px;">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                        value="{{ $price[0] }}">
                    </div>

                    <div class="col-xs-2 padding-right:0">
                        <input type="text" style="width:100%; margin-bottom: 5px;"
                        value="{{ isset($price[1]) ? $price[1] : '' }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="page-break-after: always; margin-top:2px;"></div>

<div class="pdf-container">
    <div class="row">
        <div class="col-xs-12">
            <h4 style="color: #44DDED;">
                <strong>
                    About payment
                </strong>
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12" style="border: 1px solid #5467C8; background-color: #f7f7ff; padding: 0 0 10px 0;">
            <div class="row" style="padding: 10px 15px;">
                <div class="col-xs-4">
                    <strong>15. Special instructions/promotions</strong>
                </div>
            </div>

            <div class="row" style="padding: 0 15px;">
                <div class="col-xs-12">
                    <div class="col-xs-12">
                        <textarea class="text-left" style="width: 100%; padding: 20px !important;" rows="10"> @if($dealCalculator->overview->monthsFree)BCAD for six months free to be applied to lead and sharers only (total value £{{ number_format($dealCalculator->overview->bcad, 2) }})@endif</textarea>
                    </div>
                </div>
            </div>


            <div class="row" style="padding: 10px 0">
                <div class="col-xs-6">
                    <div class="row" style="padding: 0 15px;">
                        <div class="col-xs-12">
                            <strong>16. Preferred payment option</strong>
                        </div>
                    </div>

                    <div class="row" style="padding: 0 15px;">
                        <div class="col-xs-12">
                            <div class="col-xs-12">
                                Direct Debit <input type="checkbox" checked="checked">
                                Credit card <input type="checkbox">
                                Cheque <input type="checkbox">
                                BACS <input type="checkbox">
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding: 0 15px;">
                        <div class="col-xs-12">
                            <strong>17. Credit card details</strong>
                        </div>
                    </div>

                    <div class="row" style="padding: 0 15px;">
                        <div class="col-xs-12">
                            <div class="col-xs-12">
                                <p>I authorise Telefónica UK Limited to debit my credit card for the outstanding balance
                                    on my account.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding: 0 15px;">
                        <div class="col-xs-12">
                            <div class="col-xs-12">
                                Type of card:
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding: 0 15px;">
                        <div class="col-xs-12">
                            <div class="col-xs-12">
                                Visa <input type="checkbox">
                                Mastercard <input type="checkbox">
                                Delta <input type="checkbox">
                                Eurocard <input type="checkbox">
                                American Express <input type="checkbox">
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding: 5px 15px 0 15px;">
                        <div class="col-xs-12">
                            <div class="col-xs-4" style="padding-right: 0;">
                                Name on card
                            </div>

                            <div class="col-xs-8" style="padding: 0;">
                                <input type="text" style="width:100%; margin-bottom: 5px;">
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding: 0 15px;">
                        <div class="col-xs-12">
                            <div class="col-xs-4" style="padding-right: 0;">
                                Card number
                            </div>

                            <div class="col-xs-8" style="padding: 0;">
                                <input type="text" style="width:100%; margin-bottom: 5px;">
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding: 0 15px;">
                        <div class="col-xs-12">
                            <div class="col-xs-4" style="padding-right: 0;">
                                Expiry date
                            </div>

                            <div class="col-xs-1" style="padding: 0;">
                                <input type="text" style="width:100%; margin-bottom: 5px;">
                            </div>

                            <div class="col-xs-1"></div>

                            <div class="col-xs-1" style="padding: 0;">
                                <input type="text" style="width:100%; margin-bottom: 5px;">
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding: 0 15px;">
                        <div class="col-xs-12">
                            <div class="col-xs-4" style="padding-right: 0; padding-top: 5px;">
                                Signature
                            </div>

                            <div class="col-xs-8" style="padding: 0;">
                                <input type="text" style="width:100%; margin-bottom: 5px; height: 30px;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="row" style="padding: 0 15px;">
                        <div class="col-xs-12">
                            <strong>18. Declaration</strong>
                        </div>
                    </div>

                    <div class="row" style="padding: 0 15px;">
                        <div class="col-xs-12">
                            <div class="col-xs-12">
                                <p>
                                    "I confirm that I am 18 years or over, that all information provided is true or
                                    correct and that I am duly authorised to sign on behalf of the organisation named above. I
                                    understand that a minimum 12 month contract applies and agree to be bound by the
                                    current version of O2's business terms and conditions, a full copy of which I have
                                    received".
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding: 0 15px;">
                        <div class="col-xs-12">
                            <div class="col-xs-4" style="padding-right: 0; padding-top: 5px;">
                                Signature
                            </div>

                            <div class="col-xs-8" style="padding: 0;">
                                <input type="text" style="width:100%; margin-bottom: 5px; height: 30px;">
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding: 0 15px;">
                        <div class="col-xs-12">
                            <div class="col-xs-4" style="padding-right: 0;">
                                Date
                            </div>

                            <div class="col-xs-3" style="padding: 0;">
                                <input type="text" style="width:100%; margin-bottom: 5px;">
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding: 0 15px;">
                        <div class="col-xs-12">
                            <div class="col-xs-12">
                                <p>
                                    <span style="font-size: 1.2em">
                                        Data Protection <i class="fa fa-unlock-alt fa-flip-horizontal"></i>
                                    </span>
                                    O2 operates in accordance with the Data Protection Act 1998, as updated or amended
                                    from time to time. By signing this form, you agree to the use of your information as
                                    set out in O2's business terms and conditions. Details on this form may be used for
                                    marketing purposes such as, to offer you products and services that may be of interest
                                    to you. These may be offered by Telefónica UK Limited, its associates or other
                                    carefully selected third parties. If you do not wish your information to be used in
                                    this way, please tick this box. <input type="checkbox">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="rotated-text">
            <p><small>O2CN1349N ICE 04/11</small></p>
        </div>

        <div class="text-right">
            Telefónica UK Limited, Registered Office 260 Bath Road, Slough, SL1 4DX. Registered in England No. 1743099
            VAT Reg. No. GB 245 7193 48
        </div>
    </div>

    <div class="row" style="border-bottom: 1px solid #eee;">
        <div class="col-xs-12">
            <h4 style="color: #44DDED;">
                <strong>
                    About your bank
                </strong>
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <img src="{{ public_path('images/o2-logo.png') }}"
                 style="height: 75px; margin-top: 25px; margin-left: 50px;">
            <img src="{{ public_path('images/direct-debit.png') }}"
                 style="height: 100px; margin-top: 10px; float:right;">
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h4>
                <strong>Instruction to your Bank or Building Society to pay by Direct Debit</strong>
                <small class="pull-right">
                    Originator's Identification Number: &nbsp;&nbsp;
                    <strong>
                        9 &nbsp;&nbsp;&nbsp;
                        4 &nbsp;&nbsp;&nbsp;
                        8 &nbsp;&nbsp;&nbsp;
                        0 &nbsp;&nbsp;&nbsp;
                        1 &nbsp;&nbsp;&nbsp;
                        2 
                    </strong>
                </small>
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <p>
                <strong>
                    Please fill in the whole form and send it to:
                </strong>
                <br>
                <small>Telefónica UK Limited, Chester Road, Preston Brook, Runcorn, Cheshire WA7 3QA</small>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <p><strong>1.</strong> Name and full postal address of your Bank or Building Society</p>

            <table class="table table-bordered">
                <tr>
                    <td>
                        To: The Manager
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-right" style="font-size: 0.9em;">Bank or Building Society</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        Address
                    </td>
                </tr>
                <tr>
                    <td style="padding-left: 250px;">
                        Postcode
                    </td>
                </tr>
            </table>

            <div class="row" style="padding:0; margin: 0;">
                <div class="col-xs-5" style="padding:0; margin: 0;">
                    <p><strong>2.</strong> Name(s) of Account Holder(s)</p>
                </div>
                <div class="col-xs-7" style="padding:0; margin: 0;">
                    <input type="text" style="width: 100%; padding: 7px;">
                </div>
            </div>

            <div class="row" style="padding:0; margin: 0;">
                <div class="col-xs-8" style="padding:0; margin: 0;">
                    <p style="">
                        <strong>3.</strong> Branch sort code <br>
                        <small style="font-size: 0.8em; padding-left: 10px;">
                            (from the top right hand corner of your cheque)
                        </small>
                    </p>
                </div>
                <div class="col-xs-4" style="padding:0; margin: 0;">
                    <input type="text" style="width: 100%; padding: 7px;">
                </div>
            </div>
        </div>

        <div class="col-xs-6">
            <div class="row" style="padding:0; margin: 0;">
                <div class="col-xs-7" style="padding:0; margin: 0;">
                    <p><strong>4.</strong> Bank or Building Society account number</p>
                </div>

                <div class="col-xs-5" style="padding:0; margin: 0;">
                    <input type="text" style="width: 100%; padding: 7px;">
                </div>
            </div>

            <div class="row" style="padding:0; margin: 0;">
                <div class="col-xs-7" style="padding:0; margin: 0;">
                    <p><strong>5.</strong> Reference Number</p>
                </div>

                <div class="col-xs-5" style="padding:0; margin: 0;">
                    <input type="text" style="width: 100%;">
                </div>
            </div>

            <div class="row" style="padding:0; margin: 0;">
                <div class="col-xs-12" style="padding:0; margin: 0;">
                    <p>
                        <strong>6.</strong> Instruction to your Bank or Building Society <br>
                        Please pay Telefónica UK Limited Direct Debits from the account detailed in this instruction
                        subject to the safeguards assured by the Direct Debit Guarantee. I understand that this
                        instruction may remain with Telefónica UK Limited and, if so, details will be passed electronically
                        to my Bank or Building Society.
                    </p>


                    <table class="table table-bordered">
                        <tr>
                            <td>
                                Signature(s)
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Date
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 text-center">
            <strong>Bank and Building Societies may not accept Direct Debit instructions for some types of accounts</strong>
        </div>
    </div>
</div>
</body>
</html>

