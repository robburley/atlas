<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bond Agreement</title>

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
            font-size: 16px;
        }

        body {
            font-size: 16px;
        }

        .terms-and-conditions {
            font-size: 10px;
        }

        .m-t-20 {
            margin-top: 20px;
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
            z-index: -1;
            max-height: 297mm;
        }
    </style>
</head>
<body>

<div class="pdf-container terms-and-conditions">
    <div class="row">
        <img src="{{ public_path('images/winwin-logo.png') }}" class="pull-right" style="width: 100px;" alt="Win Win">
    </div>
    <div class="row m-t-20">
        <div class="col-xs-12">
            <h2 class="text-dark">
                Bond Agreement
            </h2>
            <hr>

            <table class="m-b-25">
                <tr>
                    <th style="padding-right: 25px;">
                        <h4>
                            <strong>
                                Customer:
                            </strong>
                        </h4>
                    </th>
                    <td>
                        <h4>{{ $opportunity->salesInformation->business_name }} (“the company”)</h4>
                    </td>
                </tr>
                <tr>
                    <th  style="padding-right: 25px;">
                        <h4>
                            <strong>
                                Address:
                            </strong>
                        </h4>
                    </th>
                    <td>
                        <h4>{{ $opportunity->salesInformation->address }}</h4>
                    </td>
                </tr>
                <tr>
                    <th  style="padding-right: 25px;">
                        <h4>
                            <strong>
                                Date:
                            </strong>
                        </h4>
                    </th>
                    <td>
                        <h4>{{ \Carbon\Carbon::now()->format('jS F Y') }}</h4>
                    </td>
                </tr>
                <tr>
                    <th  style="padding-right: 25px;">
                        <h4>
                            <strong>
                                BG Ref.:
                            </strong>
                        </h4>
                    </th>
                    <td>
                        <h4>{{ $bgRef }}</h4>
                    </td>
                </tr>
            </table>

            <br>
            <br>

            <p>
                Further to your recent credit check in relation to your order for mobile telephony with the O2 network
                (“the network”), you have been accepted, however the network have requested a bond payment of £{{ number_format($amount, 2) }}.
                You will receive this as a credit to your bill in relation to your account with the network at month
                six, subject to six months’ payments on time and in full.
            </p>
            <p>
                Win Win Management will pay a figure of £{{ number_format($amount, 2) }} (“the funds”) to you for the sole purpose so that you
                may make a payment of the same value directly to the network in relation only to the bond.
            </p>
            <p>
                The funds will not be sent to you until Win Win Management have had the PAC code(s) from you and handsets will not sent to you until Win Win Management have the o2 ref/account number from you as proof of payment.
            </p>
            <p>
                This payment must be made by credit or debit card within two hours (“the timescale”) after receiving the
                funds. Please call 0845 602 0260 and select option 2 twice, quoting the reference number above.
            </p>
            <p>
                If the funds are not paid to the network within the timescale in relation to the bond, the funds will be
                due back to Win Win Management in full and debt recovery processes may be enforced.
            </p>
            <p>
                Declaration
            </p>
            <p>
                I, the undersigned, am authorised to sign on behalf of the company and hereby acknowledge my full
                understanding of the above terms and confirm that the funds will be paid to the network in relation to
                the bond within the timescale and will be sent to no other recipient for no other purpose.
            </p>
            <p>
                I also acknowledge that failure to pay the funds to the network within the timescale will result in the
                funds immediately being owed back to Win Win Management in full, and debt recovery processes may be
                enacted to recover the amount.
            </p>


            <table class="m-t-25">
                <tr>
                    <th style="padding-right: 25px;">
                        <h4>
                            <strong>
                                Full Name:
                            </strong>
                        </h4>
                    </th>
                    <td>
                        <h4>@{{*name_es_:text }}</h4>
                    </td>
                </tr>
                <tr>
                    <th  style="padding-right: 25px;">
                        <h4>
                            <strong>
                                Signature:
                            </strong>
                        </h4>
                    </th>
                    <td>
                        <h4>@{{*Sig_es_:signer1:signature}}</h4>
                    </td>
                </tr>
                <tr>
                    <th  style="padding-right: 25px;">
                        <h4>
                            <strong>
                                Date:
                            </strong>
                        </h4>
                    </th>
                    <td>
                        <h4>@{{Dte_es_:signer1:date}}</h4>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</body>
</html>

