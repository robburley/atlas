<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />

    <title>Atlas &middot; Login</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
    <link rel="stylesheet" href="{{ asset('assets/css/fonts/linecons/css/linecons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fonts/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/xenon-core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/xenon-forms.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/xenon-components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/xenon-skins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    <script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="page-body login-page login-light">
    <div class="login-container">
        <div class="row">
            <div class="col-sm-6">
                <div class="errors-container">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>

                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                {!! Form::open(['url' => '/login', 'role' => 'form', 'id' => 'login', 'class' => 'login-form border-top-info']) !!}
                    <div class="login-header">
                        <a href="/" class="logo">
                            <img src="{{ asset('assets/images/logo-winwin.jpg') }}" alt="WinWin" width="130" height="35" />
                        </a>
                    </div>

                    <div class="form-group">
                        {!! Form::label('username', 'Username', ['class' => 'control-label']) !!}

                        {!! Form::text('username', null, ['class' => 'form-control', 'required', 'autofocus', 'autocomplete' => 'off']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}

                        {!! Form::password('password', ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block text-left">
                            <i class="fa fa-fw fa-lock"></i> Log In
                        </button>
                    </div>

                    <div class="login-footer">
                        <div class="info-links">
                            <p><small>Access to this application is restricted. This request has been logged from {{ $_SERVER['REMOTE_ADDR'] }}</small></p>

                            <p>&copy; Copyright Win Win Management (UK) Ltd 2014-{{ date('Y') }}. All rights reserved.</p>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/TweenMax.min.js') }}"></script>
    <script src="{{ asset('assets/js/resizeable.js') }}"></script>
    <script src="{{ asset('assets/js/joinable.js') }}"></script>
    <script src="{{ asset('assets/js/xenon-api.js') }}"></script>
    <script src="{{ asset('assets/js/xenon-toggles.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('assets/js/xenon-custom.js') }}"></script>
</body>
</html>
