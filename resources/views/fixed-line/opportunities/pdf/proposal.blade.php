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

        body {
            font-size: 18px;
        }

        p {
            font-size: 18px;
        }

        h2 {
            font-size: 32px;
        }

        h4 {
            font-size: 24px;
        }
    </style>
</head>
<body>

<div class="pdf-container">
    <div class="row" style="padding-top: 200px; text-align: center;">
        <img src="{{ public_path('images/winwin-logo.png') }}" style="width: 400px;" alt="Win Win">

        <p style="margin-top:10px; margin-left: 150px; font-size: 18px;">
            winning business, winning trust
        </p>
    </div>

    <div class="big-purple-panel">
        <h2>Proposal</h2>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

        <h4 style="margin-bottom:0;">Prepared for</h4>

        <h2 style="margin-top:0;">{{ $customer->company_name }}</h2>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

        <h4>{{ \Carbon\Carbon::now()->format('jS F Y') }}</h4>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

        <p class="text-center">PROVIDED IN COMMERCIAL CONFIDENCE</p>
    </div>
</div>

<div style="page-break-after: always; margin-top:2px;"></div>

<div class="pdf-container">
    <div class="row text-right" style="padding-top: 50px;">
        <img src="{{ public_path('images/winwin-logo.png') }}" style="width: 150px;" alt="Win Win">
    </div>

    <div class="row">
        <h2 class="underline-purple"><strong>Proposal</strong></h2>

        <h3 class="underline-blue">Package Details</h3>

        <ul>
            <li>
                {{ $opportunity->commercials->term }} month contract
            </li>

            @foreach($opportunity->commercials->lines as $line)
                <li>
                    @if($line->type == 1)
                        New Line
                    @else
                        Transfer of {{ $line->telephone_number }}
                    @endif
                    to be installed at {{ $line->installation_postcode }}


                    <span class="pull-right">
                        £{{ number_format($line->monthly_line_rental, 2, '.', ',') }} per month
                    </span>
                </li>
                <li class="sub-li">
                    <ul class="ticks">
                        @if($line->broadband > 0)
                            <li>
                                @if($line->broadband == 1)
                                    ADSL broadband
                                    <span class="pull-right">
                                    £{{ $opportunity->commercials->adsl_broad_band_price }} per month
                            </span>
                                @elseif($line->broadband == 2)
                                    Fibre broadband
                                    <span class="pull-right">
                                    £{{ $opportunity->commercials->fibre_broad_band_price }} per month
                            </span>
                                @endif
                            </li>
                        @endif


                        @if($line->has1571 == 1)
                            <li>
                                1571
                                <span class="pull-right">
                                    £1 per month
                                </span>
                            </li>
                        @endif

                        @if($line->call_divert == 1)
                            <li>
                                Call Divert
                                <span class="pull-right">
                                    £1 per month
                                </span>
                            </li>
                        @endif

                        @if($line->call_waiting == 1)
                            <li>
                                Call Waiting
                                <span class="pull-right">
                                    £1 per month
                                </span>
                            </li>
                        @endif

                        @if($line->caller_display == 1)
                            <li>
                                Caller Display
                                <span class="pull-right">
                                    £1 per month
                                </span>
                            </li>
                        @endif
                    </ul>
                </li>
            @endforeach
        </ul>

        <h3 class="underline-blue">Call Bundles</h3>

        <ul>
            <li>
                Tariff
                <span class="pull-right">
                    @if($opportunity->commercials->tariff == 1)
                        Standard
                    @elseif($opportunity->commercials->tariff == 2)
                        Saver (£5)
                    @else
                        Custom
                    @endif
                </span>
            </li>

            @if($opportunity->commercials->call_bundle_local_national > 0)
            <li>
                1000 mins Local & National
                <span class="pull-right">
                    £{{  number_format($opportunity->commercials->call_bundle_local_national, 2, '.', ',') }}
                </span>
            </li>
            @endif

            @if($opportunity->commercials->call_bundle_mobile > 0)
            <li>
                500 mins UK Std Mobile
                <span class="pull-right">
                    £{{  number_format($opportunity->commercials->call_bundle_mobile, 2, '.', ',') }}
                </span>
            </li>
            @endif
        </ul>
        @if($opportunity->commercials->tariff == 3)
            <h3 class="underline-blue">Custom Tariff Prices</h3>

            <ul>
                <li>
                    Local
                    <span class="pull-right">
                    {{  number_format($opportunity->commercials->custom_local, 2, '.', ',') }} PPM
                </span>
                </li>
                <li>
                    National
                    <span class="pull-right">
                    {{  number_format($opportunity->commercials->custom_national, 2, '.', ',') }} PPM
                </span>
                </li>
                <li>
                    Vodafone
                    <span class="pull-right">
                    {{  number_format($opportunity->commercials->custom_vodafone, 2, '.', ',') }} PPM
                </span>
                </li>
                <li>
                    O2
                    <span class="pull-right">
                    {{  number_format($opportunity->commercials->custom_o2, 2, '.', ',') }} PPM
                </span>
                </li>
                <li>
                    EE
                    <span class="pull-right">
                    {{  number_format($opportunity->commercials->custom_ee, 2, '.', ',') }} PPM
                </span>
                </li>
                <li>
                    3
                    <span class="pull-right">
                    {{  number_format($opportunity->commercials->custom_3, 2, '.', ',') }} PPM
                </span>
                </li>
            </ul>
        @endif

        <h3 class="underline-blue">Total Costs</h3>

        <ul>
            <li class="">
                Monthly Line Rental
                <span class="pull-right">
                    £{{  number_format($opportunity->commercials->monthly_line_rental, 2, '.', ',') }} per month
                </span>
            </li>

            <li class="">
                Monthly Features Rental
                <span class="pull-right">
                    £{{  number_format($opportunity->commercials->monthly_features_rental, 2, '.', ',') }} per month
                </span>

            </li>

            <li class="">
                Total Monthly Recurring Charges
                <span class="pull-right">
                    £{{  number_format($opportunity->commercials->total_monthly_recurring_charges, 2, '.', ',') }} per month
                </span>

            </li>

            <li class="">
                Total Setup Charge
                <span class="pull-right">
                    £{{ number_format($opportunity->commercials->total_setup_install_charges, 2, '.', ',') }}
                </span>

            </li>
        </ul>

        <h3 class="underline-blue">Notes</h3>

        {{ $opportunity->commercials->note }}

    </div>
</div>

<div style="page-break-after: always; margin-top:2px;"></div>

<div class="pdf-container">
    <div class="row text-right" style="padding-top: 50px;">
        <img src="{{ public_path('images/winwin-logo.png') }}" style="width: 150px;" alt="Win Win">
    </div>

    <div class="row">
        <h2 class="underline-purple">Testimonials</h2>
    </div>

    <div class="row">
        <br>

        <p class="purple">Tan Ali: “The difference I see is Win Win is a complete solution”</p>

        <p>“Our previous supplier was a blue chip company and we were treated as just a number, whereas with Win Win, we
            are treated with the professionalism and dedication that makes us important to them in every aspect. From
            billing to mobile phones, from data bolt ons to international roaming, this is all managed through Win Win
            whereas before I would personally be wasting hours of valuable time being placed on hold to customer
            services and the end result was poor. Today no time at all is being wasted as all of our requirements are
            managed seamlessly.”</p>

        <br>

        <p class="purple">Lesley Jellyman: “Win Win is our preferred supplier for all our mobile phone needs”</p>

        <p>“We feel that Win Win has embraced our business partnership and relationship, and has always performed to a
            high standard throughout. Recently, we have changed our mobile phone provider successfully, porting over 120
            numbers from Orange to O2 without any disruption to the daily running of our business. We will look forward
            to carrying on our successful relationship, and we would have no hesitation in recommending Win Win to
            others.”</p>

        <br>

        <p class="purple">Nigel Billson: “Win Win provided a solution to the predicament we were in”</p>

        <p>“We were left in a very precarious position by a “rogue” communications company. Win Win stepped in and gave
            extremely helpful advice and guidance, not only on minimising the impact on our business caused by the
            previous supplier, but by offering a complete solution and turnaround. To summarise, Win Win have provided a
            friendly and professional service, and they have lived up to the promises that were made on first contact
            and in return, I would not hesitate to recommend.”</p>

        <br>

        <p class="purple">David Short: “Thank you for your total commitment and professionalism”</p>

        <p>“I write to inform you that we have been extremely happy with the service that you have provided for us. I
            would also like to thank you for your professionalism in helping my company buy out our existing contract
            with our previous supplier. It was most satisfying that Win Win covered the additional costs incurred by the
            termination, and paid all monies upfront to allow the buyout to be concluded to our company’s satisfaction.
            Feel free to use this letter as a recommendation, and I would be happy to discuss your capabilities with
            anyone who would like to contact me.”</p>

        <br>

        <p class="purple">Barry Sharp: “I look forward to dealing with Win Win for many years to come”</p>

        <p>“After being promised the earth from previous mobile suppliers, I can honestly say that dealing with Win Win
            has been a breath of fresh air. Communication is a critical part of our business, so it’s very important
            that we can trust someone if anything goes wrong, and that any day of the week it can be sorted.”</p>

        <br>

        <p class="purple">Terry Musson: “Since coming on board, you have honoured everything as you agreed”</p>

        <p>“I would just like to take the time to express the fact that as a business, we have constantly been impressed
            with the level of service we have received since we came on board in August 2010. You have honoured
            everything that was agreed, and resolved issues in the quickest timescales.”</p>

    </div>
</div>
</body>
</html>

