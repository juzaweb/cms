<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description ?? '' }}">
    <meta name="turbolinks-cache-control" content="no-cache">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ $description ?? '' }}">
    <meta name="twitter:card" content="summary">
    <meta property="twitter:title" content="{{ $title }}">
    <meta property="twitter:description" content="{{ $description ?? '' }}">

    @if($icon = get_icon())
        <link rel="icon" href="{{ $icon }}" />
    @endif

    <title>{{ $title }}</title>

    @do_action('theme.header')

    @yield('header')

</head>
<body class="{{ isset($post) ? 'single-post': '' }} {{ body_class() }}">
    @do_action('theme.after_body')


    @include('theme::header')

    @yield('content')

    @include('theme::footer')

    @yield('footer')

    @do_action('theme.footer')

</body>
</html>