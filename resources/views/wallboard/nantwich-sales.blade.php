<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="robots" content="noindex, nofollow"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="refresh" content="10" >

    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
    <link rel="stylesheet" href="{{ asset('/assets/css/fonts/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.css') }}">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="">

<table class="table table-bordered table-striped">
    <tr>
        <td></td>
        <th>
            <h1>Today</h1>
        </th>
        <th>
            <h1>This Week</h1>
        </th>
        <th>
            <h1>This Month</h1>
        </th>
    </tr>
    @foreach($data as $user)
        <tr>
            <th>
                <h1>{{ $user['name'] }}</h1>
            </th>
            <td>
                <h1>£{{ number_format($user['today'], 2) }}</h1>
            </td>
            <td>
                <h1>£{{ number_format($user['week'], 2) }}</h1>
            </td>
            <td>
                <h1>£{{ number_format($user['month'], 2) }}</h1>
            </td>
        </tr>
    @endforeach
</table>


</body>
</html>
