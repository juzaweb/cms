<!DOCTYPE html>
<html lang="en" data-kit-theme="default">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="icon" type="image/png" href="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Mukta:400,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('mymo/styles/css/backend.css') }}">

    @include('mymo_core::components.mymo_langs')
    <script src="{{ asset('mymo/styles/js/backend.js') }}"></script>
</head>
    <body class="cui__layout--cardsShadow cui__menuLeft--dark">
        <div class="cui__layout cui__layout--hasSider">
            <div class="cui__menuLeft__backdrop"></div>
            <div class="cui__layout">
                @yield('content')
            </div>
        </div>
    </body>
</html>