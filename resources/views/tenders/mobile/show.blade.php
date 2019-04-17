<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="robots" content="noindex, nofollow"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
    <link rel="stylesheet" href="{{ asset('/assets/css/fonts/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/xenon-core.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/xenon-components.css') }}">

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        .page-body {
            background-color: hsl(302, 7%, 90%);
        }

        footer.main-footer {
            background-color: hsl(302, 7%, 90%);
        }
    </style>
</head>

<body class="page-body">

<div class="page-container" id="app">

    <div class="main-content">
        <div class="content-wrap">
            <mobile-tender :invitation="{{ $invitation }}" :handset_list="{{ $handsets }}"></mobile-tender>
        </div>

        @include('layout.footer')
    </div>
</div>

<div class="page-loading-overlay">
    <div class="loader-2"></div>
</div>

<script src="{{ mix('/js/manifest.js') }}"></script>
<script src="{{ mix('/js/vendor.js') }}"></script>
<script src="{{ mix('/js/app.js') }}"></script>

<script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
{{--<script src="{{ asset('/assets/js/TweenMax.min.js') }}"></script>--}}
<script src="{{ asset('/assets/js/resizeable.js') }}"></script>
<script src="{{ asset('/assets/js/joinable.js') }}"></script>
<script src="{{ asset('/assets/js/xenon-api.js') }}"></script>
<script src="{{ asset('/assets/js/xenon-toggles.js') }}"></script>
<script src="{{ asset('/assets/js/xenon-custom.js') }}"></script>

</body>
</html>
