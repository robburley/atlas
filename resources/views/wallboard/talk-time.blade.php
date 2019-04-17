<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="robots" content="noindex, nofollow"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="refresh" content="60">

    <title>Talk Time | {{ $branch }}</title>

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
        .wrap {
            height: 100vh;
            background-color: hsl(302, 7%, 90%);
            display: flex;
            flex-flow: row wrap;
            justify-content: space-around;
            padding: 10px;
        }

        .agent-block {
            margin: 5px;
            flex-grow: 1;
            flex-basis: 19%;
        }

        .agent-content {
            height: 100%;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: auto;
        }

        .shadow {
            text-shadow: 1px 1px 2px rgba(150, 150, 150, 1);
        }

        h1, .h1, h2, .h2, h3, .h3 {
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>
</head>

<body class="">
<div class="wrap">
    @forelse($agents as $agent)
        <div class="background-{{ $agent->colour }} text-center agent-block">
            <div class="agent-content text-white">
                <h2 class="shadow">
                    {{ str_replace(["($branch)", '(' , strtolower($branch) . ')'], '', $agent->name) }}
                </h2>

                <h3 class="shadow p-t-8">
                    {{ $agent->call_duration_formatted  }}
                </h3>
            </div>
        </div>
    @empty
        <div class="text-center agent-block">
            <div class="agent-content text-purple">
                <h2 class="shadow">No Agent's have made calls today</h2>
            </div>
        </div>
    @endforelse
</div>

</body>
</html>
