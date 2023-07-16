<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <link href="//fonts.googleapis.com" rel="dns-prefetch"/>
    <link href="//www.gstatic.com" rel="dns-prefetch"/>
    <link href="//www.googletagmanager.com" rel="dns-prefetch"/>

{{--    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" />--}}
    <script src="{{ asset('assets/js/app.js') }}" defer></script>

    @do_action('theme.header')

    @inertiaHead
</head>

<body class="{{ $bodyClass ?? '' }}">
@do_action('theme.after_body')

@include('theme::header')

@inertia

@include('theme::footer')

@do_action('theme.footer')

</body>
</html>
