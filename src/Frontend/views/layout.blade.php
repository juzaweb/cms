<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="robots" content="index, follow">
    <meta name="language" content="vi" />
    <meta name="turbolinks-cache-control" content="no-cache">
    <meta property="og:title" content="">
    <meta property="og:type" content="website">
    <meta property="og:site" content="">
    <meta property="og:url" content="">
    <meta property="og:description" content="">
    <meta name="twitter:card" content="summary">
    <meta property="twitter:title" content="">
    <meta property="twitter:description" content="">
    <title></title>

    @yield('header')
</head>
<body class="mobile_nav_class jl-has-sidebar">

    @include('header')

    @yield('content')

    @include('footer')

    @yield('footer')
</body>
</html>