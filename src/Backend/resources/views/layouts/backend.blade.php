<!DOCTYPE html>
<html lang="en" data-kit-theme="default">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="turbolinks-cache-control" content="no-cache">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? '' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('mymo/styles/images/icon.png') }}" />
    <link href="https://fonts.googleapis.com/css?family=Mukta:400,700,800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('mymo/styles/css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('mymo/styles/css/backend.css') }}">

    @include('mymo_core::components.mymo_langs')

    <script src="{{ asset('mymo/styles/js/vendor.js') }}"></script>
    <script src="{{ asset('mymo/styles/js/backend.js') }}"></script>
    <script src="{{ asset('mymo/styles/ckeditor/ckeditor.js') }}"></script>

    @do_action('mymo_header')
    @yield('header')
</head>

<body class="mymo__menuLeft--dark mymo__topbar--fixed mymo__menuLeft--unfixed">
<div class="mymo__layout mymo__layout--hasSider">

    <div class="mymo__menuLeft">
        <div class="mymo__menuLeft__mobileTrigger"><span></span></div>

        <div class="mymo__menuLeft__outer">
            <div class="mymo__menuLeft__logo__container">
                <div class="mymo__menuLeft__logo">
                    <div class="mymo__menuLeft__logo__name">
                        <a href="/{{ config('mymo.admin_prefix') }}">
                            <img src="{{ asset('mymo/styles/images/logo.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>

            <div class="mymo__menuLeft__scroll kit__customScroll">
                @include('mymo_core::backend.menu_left')
            </div>
        </div>
    </div>
    <div class="mymo__menuLeft__backdrop"></div>

    <div class="mymo__layout">
        <div class="mymo__layout__header">
            @include('mymo_core::backend.menu_top')
        </div>

        <div class="mymo__layout__content">
            @if(!request()->is(config('mymo.admin_prefix') . '/dashboard'))
            {{ breadcrumb('admin', [
                    [
                        'title' => $title
                    ]
                ]) }}
            @else
                <div class="mb-3"></div>
            @endif

            <h4 class="font-weight-bold ml-3">{{ $title }}</h4>

            <div class="mymo__utils__content">
                @yield('content')
            </div>
        </div>
        <div class="mymo__layout__footer">
            <div class="mymo__footer">
                <div class="mymo__footer__inner">
                    <a href="https://github.com/mymocms/mymocms" target="_blank" rel="noopener noreferrer" class="mymo__footer__logo">
                        MYMO CMS - The Best Laravel CMS
                        <span></span>
                    </a>
                    <br />
                    <p class="mb-0">
                        Copyright © {{ date('Y') }} {{ get_config('sitename') }} - Provided by MYMO CMS
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

@do_action('mymo_footer')
@yield('footer')
</body>
</html>