<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="robots" content="noindex, nofollow"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="refresh" content="15">

    <title>Sunderland Appointments</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
    <link rel="stylesheet" href="{{ asset('/assets/css/fonts/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
            border: 1px solid #666;
        }

        .min-height-145 {
            min-height: 145px !important;
        }
        .table {
            min-height: 100vh;
            margin-bottom: 0;
        }
    </style>
</head>

<body class="">

<table class="table table-bordered">
    <tr>
        <th>
        </th>
        @foreach($data->first() as $current)
            <th class="text-center v-mid">
                {{ $current['slot'] }}
            </th>
        @endforeach
    </tr>
    @foreach($data as $user => $slots)
        <tr>
            <th class="v-mid">
                <h3>{{ str_replace('(Sales Rep)', '', $user) }}</h3>
            </th>

            @foreach($slots as $index => $currentSlot)
                @if($loop->first || !$currentSlot['appointment'] || ($currentSlot['appointment'] && $currentSlot['appointment'] != $slots[$index - 1]['appointment']))
                    <td
                            @if(!$loop->last && $currentSlot['appointment'] && $currentSlot['appointment'] == $slots[$index + 1]['appointment'])
                                class="text-center v-mid background-success min-height-145" colspan="2"
                            @elseif($currentSlot['appointment'])
                                class="text-center v-mid background-success min-height-145"
                            @else
                                class="active min-height-145"
                            @endif
                    >
                        @if($currentSlot['appointment'])
                            <h1>{!! str_replace(' ', '<br>', strtoupper($currentSlot['appointment']->site->postcode ?? 'No PC')) !!}</h1>
                            <p>
                                <small>
                                    {{ str_replace(['(Sunderland)', '(Manchester)'], '', $currentSlot['appointment']->appointable->creator->name) }}
                                </small>
                            </p>
                        @endif
                    </td>
                @endif
            @endforeach
        </tr>
    @endforeach
</table>


</body>
</html>
