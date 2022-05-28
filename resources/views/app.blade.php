<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    @include('cms::components.juzaweb_langs')

    <link rel="icon" href="{{ asset('jw-styles/juzaweb/images/favicon.ico') }}"/>
    <link href="https://fonts.googleapis.com/css?family=Mukta:400,700,800&display=swap" rel="stylesheet"/>

    <link href="{{ asset('jw-styles/juzaweb/css/app.css') }}" rel="stylesheet"/>

    <script src="{{ asset('jw-styles/juzaweb/js/app.js') }}" defer></script>

    @yield('header')

    @inertiaHead
</head>
<body class="juzaweb__menuLeft--dark juzaweb__topbar--fixed juzaweb__menuLeft--unfixed">

@inertia



<template id="form-images-template">
    @component('cms::components.image-item', [
        'name' => '{name}',
        'path' => '{path}',
        'url' => '{url}',
    ])

    @endcomponent
</template>

<div id="show-modal"></div>

<form action="{{ route('logout') }}" method="post" style="display: none" class="form-logout">
    @csrf
</form>

{{-- <script type="text/javascript">
    $.extend($.validator.messages, {
        required: "{{ trans('cms::app.this_field_is_required') }}",
    });

    $(".form-ajax").validate();

    $(".auth-logout").on('click', function () {
        $('.form-logout').submit();
    });
</script> --}}

@do_action('juzaweb_footer')

@yield('footer')

</body>
</html>
