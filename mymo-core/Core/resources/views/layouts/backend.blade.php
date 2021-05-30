<!DOCTYPE html>
<html lang="en" data-kit-theme="default">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="turbolinks-cache-control" content="no-cache">

    <title>{{ $title ?? '' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}" />
    <link href="https://fonts.googleapis.com/css?family=Mukta:400,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('styles/css/backend.css') }}">
    @include('mymo_core::components.mymo_langs')

    <script src="{{ asset('styles/js/backend.js') }}"></script>
    <script src="{{ asset('styles/ckeditor/ckeditor.js') }}"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>

</head>

<body class="cui__menuLeft--dark cui__topbar--fixed cui__menuLeft--unfixed">
<div class="cui__layout cui__layout--hasSider">

    <div class="cui__menuLeft">
        <div class="cui__menuLeft__mobileTrigger"><span></span></div>

        <div class="cui__menuLeft__outer">
            <div class="cui__menuLeft__logo__container">
                <div class="cui__menuLeft__logo">
                    <img src="{{ asset('styles/images/logo.png') }}" class="mr-2" alt="Mymo Logo" />
                </div>
            </div>

            <div class="cui__menuLeft__scroll kit__customScroll">
                @include('mymo_core::backend.menu_left')
            </div>
        </div>
    </div>
    <div class="cui__menuLeft__backdrop"></div>

    <div class="cui__layout">
        <div class="cui__layout__header">
            @include('mymo_core::backend.menu_top')
        </div>

        <div class="cui__layout__content">
            {{ breadcrumb('admin', [
                    [
                        'title' => $title
                    ]
                ]) }}

            <h4 class="font-weight-bold ml-3">{{ $title }}</h4>

            <div class="cui__utils__content">
                @yield('content')
            </div>
        </div>
        <div class="cui__layout__footer">
            <div class="cui__footer">
                <div class="cui__footer__inner">
                    <a href="https://mymo.juzaweb.com" target="_blank" rel="noopener noreferrer" class="cui__footer__logo">
                        MYMO - Free Laravel CMS
                        <span></span>
                    </a>
                    <br />
                    <p class="mb-0">
                        Copyright © 2020 MyMo Team
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $.extend( $.validator.messages, {
        required: "{{ trans('mymo_core::app.this_field_is_required') }}",
    });

    $(".form-ajax").validate();
</script>
</body>
</html>