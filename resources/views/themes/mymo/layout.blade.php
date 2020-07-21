<!DOCTYPE html>
<html lang="vi-VN">
<head>
    @php
    $icon = image_url(get_config('icon'));
    $logo = image_url(get_config('logo'));
    @endphp
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#234556">
    <link rel="shortcut icon" href="{{ $icon }}" type="image/x-icon"/>
    <title>{{ @$title }}</title>
    <meta name="description" content="{{ @$description }}"/>
    <meta name="robots" content="index, follow"/>
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
    <meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
    <link rel="canonical" href="{{ url()->current() }}"/>
    <meta property="og:locale" content="vi_VN"/>
    <meta property="og:title" content="{{ @$title }}"/>
    <meta property="og:description" content="{{ @$description }}"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:site_name" content=""/>
    <meta property="fb:app_id" content="2401456150086560"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="@XemPhimPlus"/>
    <meta name="csrf-token" content="{{ csrf_token()  }}">

    <link rel="stylesheet" href="{{ asset('styles/themes/mymo/css/main.css') }}"/>
    <script type="text/javascript">
        /* <![CDATA[ */
        var langs = {
            'apparently_there_are_no_posts_to_show': '@lang('app.apparently_there_are_no_posts_to_show')'
        };
        /* ]]> */
    </script>

    <script type='text/javascript'>
        /* <![CDATA[ */
        var halim = {
            "ajax_url":"http:\/\/xemphimplus.net\/wp-content\/themes\/halimmovies\/halim-ajax.php",
            "ajax_search_url": "{{ route('search') }}",
            "ajax_popular_movies_url": "{{ route('movies.popular') }}",
            "light_mode":"0",
            "light_mode_btn":"1",
            "ajax_live_search":"1",
            "sync":null,
            "db_redirect_url":"http:\/\/xemphimplus.net\/"
        };
        /* ]]> */
    </script>

    <script type='text/javascript'>
        /* <![CDATA[ */
        var ajax_auth_object = {
            "login_url": "{{ route('login.submit') }}",
            "register_url": "{{ route('register.submit') }}",
            "redirecturl":"{{ url()->current() }}",
            "loadingmessage":"Sending user info, please wait...",
            "sitekey":"",
            "languages":{
                "login":"@lang('app.login')",
                "register":"@lang('app.register')",
                "forgotpassword":"B\u1ea1n qu\u00ean m\u1eadt kh\u1ea9u?",
                "already_account":"Already have an account?",
                "create_account":"Create account",
                "reset_captcha":"Reset captcha",
                "username":"@lang('app.name')",
                "email":"@lang('app.email')",
                "username_email":"@lang('app.email')",
                "password":"@lang('app.password')",
                "reset_password":"Thi\u1ebft l\u1eadp l\u1ea1i m\u1eadt kh\u1ea9u",
                "login_with":"",
                "register_with":"",
                "or":"or"
            }
        };
        /* ]]> */
    </script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('styles/themes/mymo/js/main.js') }}"></script>

    <!-- Google Analytics -->

    <!-- End Google Analytics -->

    <style>
        .halim-post-title-box {
            position: unset !important;
            padding: 50px 0 0 !important;
            text-align: center !important;
            background: transparent !important;
        }

        .halim-post-title > h2 {
            color: #e6920e;
        }

        .halim-corner-rounded .halim_box .grid-item figure, .halim-corner-rounded .owl-carousel .grid-item figure {
            border-radius: 8.5px;
        }

        .halim-post-title.title-2-line h2 {
            -webkit-line-clamp: 2;
        }

        .grid-item .episode {
            right: 5px;
            bottom: 55px;
        }
    </style>

    <link rel="icon" href="{{ $icon }}" sizes="32x32"/>
    <link rel="icon" href="{{ $icon }}" sizes="192x192"/>
    <link rel="apple-touch-icon-precomposed" href="{{ $icon }}"/>
    <meta name="msapplication-TileImage" content="{{ $icon }}"/>

    <style>
        #header .site-title {
            background: url({{ image_url(get_config('logo')) }}) no-repeat top left;
            background-size: contain;
            text-indent: -9999px;
        }
    </style>
</head>
<body class="home blog wp-embed-responsive halimthemes halimmovies halim-corner-rounded" data-masonry="" data-nonce="9d27ce22e4">

@include('themes.mymo.header')
@include('themes.mymo.menu')
<!-- /header -->
@if(request()->is('/'))
@include('themes.mymo.slider')
@endif

<div class="container-fluid halim-full-player hidden halim-centered">
    <div id="halim-full-player" class="container col-md-offset-2s col-md-9"></div>
</div>

<div class="container">
    @yield('content')
</div><!--./End .container -->

<div class="clearfix"></div>


@include('themes.mymo.footer')

<!-- <div  class="hidemobile" style="position: fixed; top: 0px; left: 0px; z-index: 999999">
<a href="/link/floatleft.html" rel="nofollow" target="_blank">
    <img src="banner/lixi88.gif" alt="Quảng cáo" class="img-fluid" width="100px">
</a>
</div> -->
<script type="text/javascript">
    function hide_float_left() {
        var content = document.getElementById('float_content_left');
        var hide = document.getElementById('hide_float_left');
        if (content.style.display == "none") {
            content.style.display = "block";
            hide.innerHTML = '<a href="javascript:hide_float_left()">[X]</a>';
        } else {
            content.style.display = "none";
            hide.innerHTML = '';
        }
    }
</script>
<div class="float-ck hidemobile">
    <div id="hide_float_left">
        <a href="javascript:hide_float_left()">[X]</a></div>
    <div id="float_content_left">
        <!-- Start quang cao-->

        <!-- End quang cao -->
    </div>
</div>

</body>
</html>
