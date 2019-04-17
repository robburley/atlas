<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="robots" content="noindex, nofollow"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link rel="shortcut icon" href="/favicon.ico"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
    <link rel="stylesheet" href="{{ asset('/assets/css/fonts/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/xenon-core.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/xenon-components.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/other/sweetalert.css') }}">

    <link rel="stylesheet" href="{{ asset('/assets/jquery-ui/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/js/jquery-ui/jquery-ui-timepicker-addon.css') }}">

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

{{--<link rel="stylesheet" href="{{ asset('/assets/css/fonts/linecons/css/linecons.css') }}">--}}
{{--<link rel="stylesheet" href="{{ asset('/assets/css/xenon-forms.css') }}">--}}
{{--<link rel="stylesheet" href="{{ asset('/assets/css/xenon-skins.css') }}">--}}

@yield('styles')

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="page-body">
<div class="div" id="app">
    <nav class="navbar horizontal-menu"><!-- set fixed position by adding class "navbar-fixed-top" -->

        <div class="navbar-inner">
            <div class="navbar-brand">
                <a href="/" class="logo {{ request()->is('/') ? 'active' : '' }}">
                    <i class="fa fa-fw fa-home"></i>
                    <span>Atlas</span>
                </a>

                <a href="#" data-toggle="settings-pane" data-animate="true">
                    <i class="linecons-cog"></i>
                </a>
            </div>

            <div class="nav navbar-mobile">
                <div class="mobile-menu-toggle">
                    <a href="#" data-toggle="settings-pane" data-animate="true">
                        <i class="linecons-cog"></i>
                    </a>
                    {{--<!-- data-toggle="mobile-menu-horizontal" will show horizontal menu links only -->--}}
                    {{--<!-- data-toggle="mobile-menu" will show sidebar menu links only -->--}}
                    {{--<!-- data-toggle="mobile-menu-both" will show sidebar and horizontal menu links -->--}}
                    <a href="#" data-toggle="mobile-menu-horizontal">
                        <i class="fa-bars"></i>
                    </a>
                </div>
            </div>

            <div class="navbar-mobile-clear"></div>

            @include('layout.nav')

            <ul class="nav nav-userinfo navbar-right">
                @include('interface.search')

                @include('interface.user')
            </ul>
        </div>
    </nav>

    <div class="page-container">

        <div class="main-content">
            <div class="content-wrap">
                @yield('content')
            </div>

            @include('layout.footer')
        </div>
    </div>

    <div class="page-loading-overlay">
        <div class="loader-2"></div>
    </div>
</div>

@include('interface.modals')
@include('interface.sticky-footer')

<script src="{{ mix('/js/manifest.js') }}"></script>
<script src="{{ mix('/js/vendor.js') }}"></script>
<script src="{{ mix('/js/app.js') }}"></script>

<script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/assets/js/TweenMax.min.js') }}"></script>
<script src="{{ asset('/assets/js/resizeable.js') }}"></script>
<script src="{{ asset('/assets/js/joinable.js') }}"></script>
<script src="{{ asset('/assets/js/xenon-api.js') }}"></script>
<script src="{{ asset('/assets/js/xenon-toggles.js') }}"></script>
<script src="{{ asset('/assets/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('/assets/js/xenon-custom.js') }}"></script>

<script src="{{ asset('/assets/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('/assets/js/jquery-ui/jquery-ui-timepicker-addon.js') }}"></script>

@include('sweet::alert')

{{--<script src="{{ asset('/assets/js/jquery-validate/jquery.validate.min.js') }}"></script>--}}
{{--<script src="{{ asset('/assets/js/toastr/toastr.min.js') }}"></script>--}}
{{--<script src="{{ asset('/assets/js/rwd-table/js/rwd-table.min.js') }}"></script>--}}

<script>

    $(document).ready(function () {
        $.datepicker.setDefaults({dateFormat: 'dd/mm/yy'})

        $('.datepicker').datetimepicker()

        $('.datetimepicker').datetimepicker({
            timeFormat: 'HH:mm:ss',
            showSecond: false,
            stepMinute: 5,
            hourMin: 5,
            hourMax: 22,
        })

        $('#sidebar-toggle').click(function () {
            $.get('/toggle-sidebar')
        })

        $('#events-open').click(function (e) {
            e.preventDefault()

            $('#events-window').removeClass('open')
        })

        $('#events-closed').click(function (e) {
            e.preventDefault()

            $('#events-window').addClass('open')
        })

        $('#notifications-open').click(function (e) {
            e.preventDefault()

            $('#notifications-window').removeClass('open')
        })

        $('#notifications-closed').click(function (e) {
            e.preventDefault()

            $('#notifications-window').addClass('open')
        })

        @if(!auth()->user()->sidebar)
        if (!isxs()) {
            $('.sidebar-menu').addClass('collapsed')
        }
        @endif

        @if(!auth()->user()->isAdmin())
        $('body').bind('cut copy', function (e) {
            e.preventDefault()
        })

        $('body').on('contextmenu', function (e) {
            return false
        })
        @endif

        $(window).keyup(function (e) {
            if (e.keyCode === 44) {
                $.post('/api/its-like-that', {
                    'user': "{{ auth()->user()->id }}",
                    'url': "{{ request()->fullUrl() }}",
                })
            }
        })
    })
</script>

@yield('scripts')

<script src="{{ asset('/assets/js/xenon-custom.js') }}"></script>
</body>
</html>
