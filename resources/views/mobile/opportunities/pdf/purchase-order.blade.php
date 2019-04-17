@php
    $showPrice = $dealCalculator->getCustomerContribution() > 0;
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
            max-width: 100%;
        }

        .table-bordered-blue > thead > tr > th, .table-bordered-blue > tbody > tr > th, .table-bordered-blue > tfoot > tr > th, .table-bordered-blue > thead > tr > td, .table-bordered-blue > tbody > tr > td, .table-bordered-blue > tfoot > tr > td {
            border-color: #5467C8 !important;
        }

        .rotated-text {
            position: absolute;
            top: 535px;
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

<div class="pdf-container terms-and-conditions">
    <div class="row">
        <img src="{{ public_path('images/winwin-logo.png') }}" class="pull-right" style="width: 100px;" alt="Win Win">
    </div>
    <div class="row m-t-20">
        <p>
            <strong>You should read these Terms and Conditions carefully.</strong> By signing this document, you
            acknowledge that you have fully understood this document in its entirety.
        </p>
        <p>
            By signing these Terms and Conditions, you are also agreeing to our full Terms and Conditions which are
            available at www.winwincr.co.uk/terms and if any provisions of the full Terms and Conditions conflict
            with
            any provisions of these Terms and Conditions then the full Terms and Conditions shall prevail.
        </p>
    </div>
    <div class="row m-t-20">
        <div style="width:33%; text-align: justify; float:left;">
            <strong>Definitions</strong><br>
            “We” or “us” means Win Win Management (UK) Ltd, a company registered in England with registered number
            09162798.
            “Mobile Phone Equipment” means any cellular telephone supplied under this agreement.
            “Item” means any Mobile Phone Equipment, accessory, promotional items, and other goods supplied under
            this
            contract.
            <br>

            <strong>Mobile Phone Equipment Offer</strong><br>
            All offers made by us for Mobile Phone Equipment are limited period offers, subject to availability, and
            subject to status. We will carry out a credit check prior to acceptance of your order. Should the agreed
            handsets be unavailable or out of stock, Win Win Management (UK) Ltd reserves the right to offer Mobile
            Phone Equipment of comparative value.
            <br>

            <strong>Airtime Contract</strong><br>
            All Mobile Phone Equipment is supplied subject to a minimum term airtime contract through the relevant
            Network. The Network Terms and Conditions of Supply of Cellular Telephone Services that apply to the
            supply
            of airtime under this contract are already with you (at signature stage).
            <br>

            <strong>Connection to the Network</strong><br>
            Your contract with the Network for connection to the network is subject to status and acceptance by the
            Network.
            <br>

            <strong>Ownership</strong><br>
            Ownership of the Item will not pass to you until such time as we have received payment of the purchase
            price
            in full. In the case of Mobile Phone Equipment offers, ownership shall not pass until you have fulfilled
            the
            minimum term of the airtime contract. If you terminate the airtime contract before the minimum term has
            been
            satisfied, you will be responsible for paying us the original SIM free retail price of the Mobile Phone
            Equipment at the date of your original connection.
            <br>

            <strong>Free Gifts / Promotional Items</strong><br>
            Free gifts, excluding accessories that are given away in conjunction with a Mobile Phone Equipment
            purchase
            may be dispatched under separate cover, approximately 28 days after the Mobile Phone Equipment has been
            delivered. However, if the contract is terminated in this period we will withdraw the offer of a gift.
            <br>

            <strong>Delivery</strong><br>
            Delivery of Mobile Phone Equipment and other items will be made to an address in mainland UK only. We
            shall
            endeavour to deliver the Items within 5 working days of your order. This delivery period is an estimate
            only
            and we cannot accept responsibility for late delivery due to insufficient or wrong information provided,
            or
            delays in the connection process. This includes mandatory proofs requested by the Network and completion
            of
            the Network contract. Goods received damaged or with Items missing must be reported to us within 24
            hours of
            delivery.
            <br>

            <strong>Prices</strong><br>
            Unless indicated otherwise, all prices stated exclude VAT and delivery. Bespoke agreements must be
            agreed
            and signed by a Line Manager of Win Win Management (UK) Ltd.
            <br>

            <strong>Payment</strong><br>
            If you do not pay any sums due to us within 14 days of the date of your invoice, we reserve the right to
            charge interest and administration fees and recover all items provided under the contract. We will not
            exercise this right where you have notified us of a valid reason for non-payment.
            <br>

            <strong>Our Responsibility To You – Please Note</strong><br>
            - We will perform the contract with reasonable skill and care<br>
            - We shall not be liable for airtime charges during any period<br>
            - In no circumstances shall we be liable for any loss or damage arising out of or relating to the
            services
            that we provide which is for any loss of profits, loss of sales, loss of turnover, loss of bargain, loss
            of
            opportunity, damage to goodwill or reputation, loss of any apparatus, software or data loss or time on
            the
            management of staff or any indirect or consequential loss or damage however so arising, for death or
            personal injury. In the event that you use any Item for a commercial purpose then we shall not be liable
            to
            you for any loss of Income, Business or profits or any other economic loss arising out of your use or
            inability to use any item at any time, however this loss may be caused and whether or not it is a result
            of
            your own negligence.
        </div>

        <div style="width:33%; text-align: justify; float:left; padding-left: 5px;">

            <strong>Your Statutory Rights</strong><br>
            Your rights and obligations under these terms and conditions are personal to you and may not be assigned
            by
            you to anyone else. We may transfer our rights and/or obligations under these terms and conditions or
            any
            part thereof.
            <br>

            <strong>Tariff Changes</strong><br>
            All new connections may be subject to additional charges should the customer change to a lower monthly
            tariff within the first 6 months of a new airtime contract. The additional costs will be based on the
            difference between the original handset price charges and the cost of the handset with lower monthly
            tariff.
            Please note that we reserve the right to recover the cost in full of the original SIM free retail price
            of
            the Mobile Phone Equipment at the date of your original connection should you choose to lower your
            tariff.
            Please ensure that you choose the correct tariff to avoid these penalties that are imposed on us by the
            Network providers. Changing to a higher monthly tariff, however, will incur no additional charges.
            Additional charges will always be avoided where possible. Please call us if you require more
            information.

            <br>
            <strong>Mobile Phone Number Porting</strong><br>

            We can offer to port your existing Mobile Phone Number if you are connecting to a different Network and
            can
            provide us with an active PAC code from your existing Network. We cannot be held liable for any
            consequential loss resulting from a Mobile Phone Number port failure. You must notify us of any problems
            within 3 days of your connection.

            <br>
            <strong>Band / Upgrade Classification</strong><br>
            You understand fully that should your Upgrade/Band Classification alter with the Network, then any
            proposal
            made by us will become obsolete.

            <br>
            <strong>Your Obligations</strong><br>
            Unless otherwise stated, you will make available to us all Mobile Phone Equipment and handsets from your
            previous mobile phone contract. Failure to return the handsets will result in a bill in accordance with
            applicable handset banding.

            <br>
            <strong>Upgrades</strong><br>
            Please note that by upgrading your handset you are committed to a new minimum term airtime contract with
            your mobile Network. Ownership and airtime conditions apply (see above).

            <br>
            <strong>Line Rental Subsidy/Termination</strong><br>
            We operate a self-billing process for any deal incentives/termination cost/line rental subsidy. You are
            required to complete and sign a self-bill agreement as confirmation of your agreement. We reserve the
            right
            to withhold payment if: the phone is disconnected; the tariff is changed; you have failed to pay the
            Network
            or us; the phone is showing no or minimal usage; we have not been paid the commission; the deal overlaps
            two
            calendar months; the deal takes more than 28 days to Connect; the Customer delays for any reason, and
            fails
            to sign the initial proposal within 14 days; the Network change any financial rewards offered to us;
            and,
            your Upgrade/Band Classification alters with the Network. If the minimum term of the contract has not
            been
            satisfied we retain the right to clawback any line rental subsidy, termination costs or cashback that
            has
            been paid, and also the original cost of any hardware supplied by Win Win Management (UK) Ltd direct.
            You
            understand fully that by sending a Purchase Order to us, a binding contract exists between both parties
            and
            failure to honour the contract may result in financial penalties. Win Win Management (UK) Ltd reserves
            the
            right to Terminate the contract at any time. You understand that terminating the agreement at any time
            after
            signing these terms and conditions will result in you becoming liable for any costs incurred by us. You
            will
            also become liable for consultation fees should you choose to cancel or be declined as a result of a
            credit
            check. Should you cancel at any time, you will be liable for cancellation fees for each individual
            connection.

            <br>
            <strong>Disclaimer of Tariff Analysis</strong><br>
            These results are based on the records you supply of your historical call profile and are intended as an
            indication only, assuming your profile remains consistent. The analysis may not represent all aspects of
            international calls/roaming/data/SMS, calls that could affect the result and therefore the recommended
            call
            plan. Whilst Win Win Management (UK) Ltd have used reasonable actions to ensure the accuracy and
            consistency
            of the results, you should not rely on it and we accept no liability for errors or omissions or any
            direct,
            indirect or consequential damages arriving as a result of the use of this tariff.

        </div>

        <div style="width:33%; text-align: justify; float:left; padding-left: 5px;">
            <strong>Charges</strong><br>
            You shall be liable for all Charges incurred for each Service from the Commencement Date, whether the
            Services are used by your employees or by any other person with or without your permission or knowledge
            and
            notwithstanding that they may have arisen from unauthorised, fraudulent, or illegal use and whether or
            not
            they derive from installation and access which have been authorised by us.
            <br>

            <strong>Security</strong><br>
            In order to access the Services, we may provide you with a set of passwords. You are responsible for the
            security and proper use of all passwords relating to the Services and must keep them confidential and
            must
            not disclose them to any third party. You must inform us immediately if you suspect that any password in
            relation to the Services has become known to someone who is not authorised to use it. If we suspect that
            there is likely to be a breach of security or a misuse of the Services we may change your password
            (without
            notice) and notify you accordingly.
            <br>

            <strong>Data Protection</strong><br>
            All information held by us is processed and recorded in accordance with the Data Protection Act 1998.
            <br>

            <strong>Force Majeure</strong><br>
            Neither party shall be liable for any delay or failure to meet its obligations under this Contract due
            to
            any cause outside its reasonable control including (without limitation), inclement weather, Acts of God,
            war, riot, malicious acts of damage, civil commotion, strike, lockout, industrial dispute, refusal of
            licence, power failure or fire. If performance of the Service is prevented then the client shall be
            entitled
            to an appropriate reduction in the support fee and to terminate the agreement by serving one months’
            notice
            in writing to the company.
            <br>

            <strong>Severability</strong><br>
            If any part, term, or provision of this Agreement not being of a fundamental nature should be held
            illegal
            or unenforceable the validity or enforceability of the remainder of this Agreement shall not be
            affected.
            <br>

            <strong>Contract</strong><br>
            This contract supersedes all prior writings, negotiations or understandings with respect hereto. Any
            amendment to any part of any agreement must be authorised by a Director of Win Win Management (UK) Ltd.
            <br>

            <strong>Waiver</strong><br>
            Save as expressly provided herein, failure by either Party at any time to enforce any of the provisions
            of
            this Agreement shall neither be construed as a waiver of any rights or remedies hereunder nor in any way
            affect the validity of this Agreement or any part of it. No waiver shall be effective unless given in
            writing and no waiver of a breach of this Agreement shall constitute a waiver of any antecedent or
            subsequent breach.
            <br>

            <strong>General Conditions</strong><br>
            Your Rights and obligations under these terms and conditions are personal to you/your company and may
            not be
            assigned by you to any third party. We may transfer our rights and/or obligations under these terms and
            conditions or any part thereof.

            <br>
            <br>
            <strong>
                This Contract shall be governed by and construed in accordance with English law, and the Parties
                hereby
                submit to the non-exclusive jurisdiction of the English Courts.
            </strong>

            <div class="bank-details m-t-20">
                <p>
                    <strong>Bank Details</strong>
                    <br>

                    For credit checking purposes only
                </p>

                <p>
                    <strong>Business Name</strong>
                    <span class="purple-box">
                        @{{*company_es_:text:align(center) }}
                    </span>
                </p>

                <p>
                    <strong>Sort Code</strong>
                    <span class="purple-box">
                        @{{*sortCode_es_:text:align(center) }}
                    </span>
                </p>

                <p>
                    <strong>Account Number</strong>
                    <span class="purple-box">
                        @{{*account_es_:text:align(center) }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<div style="page-break-after: always; margin-top:2px;"></div>

<div class="pdf-container">
    <img src="{{ storage_path('app/' . $opportunity->letterhead()->first()->location) }}" class="letterhead">

    <div class="row" style="margin-top: 35%; padding-top: 25px; background-color: #ffffff; z-index: 1;">
        <p>
            <strong>

                Purchase Order for Win Win Management (UK) Ltd to supply the following:
            </strong>
        </p>

        <p>
            Network: O2
            <span class="pull-right">Order No: {{ $opportunity->customer_id }}-{{ $opportunity->id }}</span>
        </p>

        <p>
            <strong>
                (1) Tariff Details & Costs
            </strong>
        </p>
        <ul>
            @foreach($dealCalculator->connections as $connection)
                <li>
                    {{ $connection->connections }} x
                    {{  $connection->tariff->type->name or '' }}
                    {{  $connection->tariff->tariff_code or '' }}

                    @if($connection->connections > 1)
                        @ £{{  number_format($connection->cost, 2, '.', ',') }}
                    @endif

                    <span class="pull-right">£{{ number_format($connection->total, 2, '.', ',') }}</span>
                </li>
            @endforeach

            <li>
                Total Monthly Line Rental
                <span class="pull-right">£{{ number_format($dealCalculator->overview->lineRental, 2, '.', ',') }}</span>
            </li>

        </ul>

        <p>
            <strong>
                (2) Total Credits, Discounts, Incentives & Buyout Cover
            </strong>
        </p>
        @php
            $primary = $dealCalculator->primaryConnections->first();
            $term = $primary
            ? $primary->term
            : $dealCalculator->secondaryConnections->first()->term;
        @endphp

        <ul>
            @if($dealCalculator->getBcadDiff() > 0)
                <li>
                    BCAD for total funding of £{{ number_format($dealCalculator->getBcadDiff(), 2, '.', ',') }}
                    per month for {{ $term }} months to be applied
                    <span class="pull-right">£{{ number_format($dealCalculator->getBcadDiffTotal(), 2, '.', ',') }}</span>
                    <br><strong>– full terms and conditions apply</strong>
                </li>
            @endif

            @if($dealCalculator->overview->monthsFree  > 0)
                <li>
                    BCAD for {{ $dealCalculator->overview->monthsFree }} months free of charge line rental to be applied
                    direct from O2 to be applied
                    <span class="pull-right">£{{ number_format($dealCalculator->overview->bcad, 2, '.', ',') }}</span>
                    <br><strong>– full terms and conditions apply</strong>
                </li>
            @endif

            @if($dealCalculator->overview->cashBack > 0)
                <li>
                    Deal Incentive to be applied
                    <span class="pull-right">£{{ number_format($dealCalculator->overview->cashBack, 2, '.', ',') }}</span>
                </li>
            @endif

            @if($dealCalculator->getBuyout() > 0)
                <li>
                    Buyout to be covered up to
                    <span class="pull-right">£{{ number_format($dealCalculator->getBuyout(), 2, '.', ',') }}</span>
                </li>
            @endif
            <li>
                Consultancy fee of £250.00 per number
                <span class="pull-right">£{{ number_format($dealCalculator->getConsultancyFee(), 2, '.', ',') }}</span>
                <br> <strong>– will be waived free of charge (terms and conditions apply)</strong>
            </li>

        </ul>

        <p>
            <strong>
                (3) Contract Duration
            </strong>
        </p>

        <ul>
            <li>
                {{ $term }} Month Contract
                <br>– 12 month review (renegotiation of package, costs & hardware funds)
            </li>
        </ul>

        <p>
            <strong>
                (4) Hardware & Kit Fund Details
            </strong>
        </p>

        <ul>
            @if($dealCalculator->handsets->count() > 0 || $dealCalculator->credits()->where('name', 'Hardware Fund')->first()->total > 0)
                @if($dealCalculator->credits()->where('name', 'Hardware Fund')->first()->total > 0)
                    <li>
                        Upfront hardware fund to be applied and available with immediate effect
                        <span class="pull-right">£{{ number_format($dealCalculator->credits()->where('name', 'Hardware Fund')->first()->total, 2, '.', ',') }}</span>
                    </li>
                @endif

                @foreach($dealCalculator->handsetsWithoutAdditionalSim() as $handset)
                    <li>
                        {{ $handset->units}} x

                        @if($handset->handset)
                            {{ $handset->handset->name }}
                        @else
                            {{ $handset->name }}
                        @endif

                        @if($showPrice)
                            @if($handset->units > 1)
                                @ £{{ number_format($handset->value, 2, '.', ',') }}
                            @endif

                            <span class="pull-right">
                                £{{ number_format($handset->total, 2, '.', ',') }}
                            </span>
                        @endif
                    </li>
                @endforeach
            @endif

            @if(($remainingSims = $dealCalculator->getRemainingSims()) > 0)
                <li>{{ $remainingSims }} x Additional Sim Card</li>
            @endif
        </ul>


        @php
            $filteredAccessories = $dealCalculator->accessories->filter(function($accessory) { 
                return !collect(['O2 SIM Card', 'Delivery', 'Unlock Fee'])->contains($accessory->name);
            })
        @endphp

        @if($filteredAccessories->count() > 0)
            <p>
                <strong>
                    (5) Accessories
                </strong>
            </p>

            <ul>
                @foreach($filteredAccessories as $accessory)
                    <li>
                        {{ $accessory->units }} x
                        {{ $accessory->name }}

                        @if($showPrice)
                            <span class="pull-right">£{{ number_format($accessory->total, 2, '.', ',') }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        <p>
            <strong>
                Summary
            </strong>
        </p>

        <p>
            The Total Credits stated in section (2) will be applied to discount the
            Total Monthly Line Rental to £{{ $dealCalculator->overview->monthlyLineRental }} until the review point of
            the contract which is stated in section (3).
        </p>


        <p>I the undersigned confirm that I am an authorised signatory for the company detailed below. By signing this
            purchase order I agree to the order as detailed above and further agree to be bound by Win Win Management
            (UK) Ltd of terms* detailed within this document.</p>

        <p>Full Name: @{{*name_es_:text }}</p>

        <p>Position: @{{*position_es_:text }}</p>

        <p>For and on behalf of (Company): @{{*behalf_es_:text }}</p>

        <p>Signature: @{{*Sig_es_:signer1:signature}}</p>

        <p>Date: @{{Dte_es_:signer1:date}}</p>

        <hr>
        <span class="terms-section">
All prices and charges shown are exclusive of vat / All incentives, buyouts & hardware/kit funds to be paid are inclusive of vat
Win Win Management (UK) Ltd Full Terms & Conditions available at www.winwincr.co.uk/terms  (“the Terms”).
Please read through these Terms carefully before signing.  Short-form terms and conditions are enclosed.
If any provisions of  the Terms conflict with any provisions of the short-form Terms and Conditions, the Terms shall prevail

<span style="margin-top:5px;">
*V1.2 of Win Win Management (UK) Ltd  Terms and Conditions apply to this order.
</span>
</span>
    </div>
</div>

<div style="page-break-after: always; margin-top:2px;"></div>

<div class="pdf-container">
    <div class="row">
        <div class="col-xs-6">
            <img src="{{ public_path('images/o2-logo.png') }}" style="margin-top:20px; margin-left: 80px;">
            <h3><strong>Business Contract application</strong></h3>
        </div>
        <div class="col-xs-6">
            <strong style="margin-left: 20px; color: #44DDED;">DISE</strong> O<sub style="font-size:0.8em;">2</sub>
            Contract No. <strong style="font-size: 1.3em;">BA1</strong>

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
                            Mr <input type="checkbox"
                                      @if(strtolower($info->account_holder_title) == 'mr') checked @endif>
                            Mrs <input type="checkbox"
                                       @if(strtolower($info->account_holder_title) == 'mrs') checked @endif>
                            Miss <input type="checkbox"
                                        @if(strtolower($info->account_holder_title) == 'miss') checked @endif>
                            Ms <input type="checkbox"
                                      @if(strtolower($info->account_holder_title) == 'ms') checked @endif>
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
                        <textarea class="text-left" style="width: 100%; padding: 20px !important;" rows="10"> @if($dealCalculator->overview->monthsFree)
                                BCAD for six months free to be applied to lead and sharers only (total value
                                £{{ number_format($dealCalculator->overview->bcad, 2) }})@endif</textarea>
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
                                    correct and that I am duly authorised to sign on behalf of the organisation named
                                    above. I
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
                                <input type="text" style="width:100%; margin-bottom: 5px; height: 30px;"
                                       value=" @{{*Sig_es_:signer1:signature}}">
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding: 0 15px;">
                        <div class="col-xs-12">
                            <div class="col-xs-4" style="padding-right: 0;">
                                Date
                            </div>

                            <div class="col-xs-3" style="padding: 0;">
                                <input type="text" style="width:100%; margin-bottom: 5px;"
                                       value="@{{Dte_es_:signer1:date}}">
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
                                    marketing purposes such as, to offer you products and services that may be of
                                    interest
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
            <p>
                <small>O2CN1349N ICE 04/11</small>
            </p>
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
                        @{{*bankName_es_:text:align(center) }} <span class="pull-right" style="font-size: 0.9em;">Bank or Building Society</span>
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
                    <input type="text" style="width: 100%; padding: 7px;" value="@{{*accountHolders_es_:text}}">
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
                    <input type="text" style="width: 100%; padding: 7px;" value="@{{*sortCode_es_:text }}">
                </div>
            </div>
        </div>

        <div class="col-xs-6">
            <div class="row" style="padding:0; margin: 0;">
                <div class="col-xs-7" style="padding:0; margin: 0;">
                    <p><strong>4.</strong> Bank or Building Society account number</p>
                </div>

                <div class="col-xs-5" style="padding:0; margin: 0;">
                    <input type="text" style="width: 100%; padding: 7px;" value="@{{*account_es_:text }}">
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
                        instruction may remain with Telefónica UK Limited and, if so, details will be passed
                        electronically
                        to my Bank or Building Society.
                    </p>


                    <table class="table table-bordered">
                        <tr>
                            <td>
                                Signature(s) @{{*Sig_es_:signer1:signature}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Date @{{Dte_es_:signer1:date}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 text-center">
            <strong>Bank and Building Societies may not accept Direct Debit instructions for some types of
                accounts</strong>
        </div>
    </div>
</div>
</body>
</html>

