@php
    $showPrice = $dealCalculator->getCustomerContribution() > 0;
@endphp
        <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Proposal | {{ $dealCalculator->name  }}</title>

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

        <h3 class="underline-blue">Tariff Details</h3>

        <div class="ticks">
            <ul>
                @foreach($dealCalculator->connections as $connection)
                    @if($connection->tariff->getFeatures() )
                        <li>
                            {!! $connection->tariff->getFeaturesWithTags() !!}
                        </li>
                    @endif
                @endforeach

                <li>
                    Unlimited O2 to O2 minutes
                </li>

                <li>
                    Unlimited minutes to 10 nominated UK landline numbers (01, 02, or 03) of your choice
                </li>

                <li>
                    <strong>Free</strong> International Traveler – when roaming anywhere in Europe, it's free to use
                    minutes, texts and data (network terms and conditions apply)
                </li>

                <li>
                    <strong>Free</strong> voicemail retrieval
                </li>

                <li>
                    <strong>Free</strong> itemised billing and online billing manager
                </li>

                <li>
                    {{ $dealCalculator->connections->first()->term }} month contract – <strong>12 month account
                        review</strong> will be carried out by Win Win (once again, research is carried out throughout
                    the market to potentially obtain further savings and benefits)
                </li>

                <li>
                    Mid-term contract extension – at the <strong>12</strong> month stage, Win Win will negotiate with
                    the network <strong>additional funds</strong> to be put towards hardware & package amendments.
                </li>

                @if($dealCalculator->getBuyout() > 0)
                    <li>
                        Buyout cost of up to £{{ number_format($dealCalculator->getBuyout(), 2, '.', ',') }} will be
                        covered – free of charge
                    </li>
                @endif
            </ul>
        </div>

        @if($dealCalculator->handsets->count() > 0 || $dealCalculator->credits()->where('name', 'Hardware Fund')->first()->total > 0)
            <h3 class="underline-blue">Hardware</h3>

            <ul>
                @if($dealCalculator->credits()->where('name', 'Hardware Fund')->first()->total > 0)
                    <li>
                        Upfront hardware fund to be applied and available with immediate effect
                        <span class="pull-right">£{{ number_format($dealCalculator->credits()->where('name', 'Hardware Fund')->first()->total, 2, '.', ',') }}</span>
                    </li>
                @endif

                @foreach($dealCalculator->handsets as $handset)
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
            </ul>
        @endif

        @php
        $filteredAccessories = $dealCalculator->accessories->filter(function($accessory) { 
            return !collect(['O2 SIM Card', 'Delivery', 'Unlock Fee'])->contains($accessory->name);
        })
        @endphp

        @if($filteredAccessories->count() > 0)
            <h3 class="underline-blue">Accessories</h3>

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

        <h3 class="underline-blue">Monthly Cost</h3>

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
                Total Monthly Cost Before Discounts	

                <span class="pull-right">£ {{ number_format($dealCalculator->overview->lineRental, 2, '.', ',') }}</span>
            </li>
 

            @if(($bcad = $dealCalculator->overview->bcad) > 0)
                <li>
                    O2 BCAD 

                    <span class="pull-right">£ {{ number_format($bcad, 2, '.', ',') }}</span>
                </li>
            @endif

            @if(($cb = $dealCalculator->overview->cashBack) > 0)
                <li>
                    Deal Incentive 

                    <span class="pull-right">£ {{ number_format($cb, 2, '.', ',') }}</span>
                </li>
            @endif
        </ul>
        <h4>
            <strong>
                <span style="padding: 5px;">
                    Final monthly cost (after discounts)
                </span>

                <span class="pull-right" style="background-color: yellow; padding: 5px;">
                    £{{ number_format($dealCalculator->overview->discountedMonthlyCost, 2) }} + VAT
                </span>
            </strong>
        </h4>
        <p>(Up until 12 month review stage)</p>
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

