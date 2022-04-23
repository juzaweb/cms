<!DOCTYPE html>
<html lang="en" data-kit-theme="default">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="icon" type="image/png" href="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('jw-styles/juzaweb/images/favicon.ico') }}" />
    <link href="https://fonts.googleapis.com/css?family=Mukta:400,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('jw-styles/juzaweb/css/vendor.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('jw-styles/juzaweb/css/backend.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('jw-styles/juzaweb/css/custom.min.css') }}">

    @include('cms::components.juzaweb_langs')

    <script src="{{ asset('jw-styles/juzaweb/js/vendor.min.js') }}"></script>
    <script src="{{ asset('jw-styles/juzaweb/js/backend.min.js') }}"></script>
    <script src="{{ asset('jw-styles/juzaweb/js/custom.min.js') }}"></script>

    @yield('header')

</head>
    <body class="juzaweb__layout--cardsShadow juzaweb__menuLeft--dark">
        <div class="juzaweb__layout juzaweb__layout--hasSider">
            <div class="juzaweb__menuLeft__backdrop"></div>
            <div class="juzaweb__layout">
                @yield('content')
            </div>
        </div>
    </body>
</html>