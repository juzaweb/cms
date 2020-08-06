<!DOCTYPE html>
<html lang="vi-VN">
<head>
    @php
        $icon = image_url(get_config('icon'));
        $logo = image_url(get_config('logo'));
        $home_tile = get_config('title');
        $header = theme_setting('header');
        $body_class = isset($body_class) ? $body_class : 'home blog wp-embed-responsive mymothemes mymomovies mymo-corner-rounded';
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
    <meta property="og:locale" content="en_US"/>
    <meta property="og:title" content="{{ @$title }}"/>
    <meta property="og:description" content="{{ @$description }}"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:site_name" content="{{ $home_tile }}"/>
    @php
    $fb_app_id = get_config('fb_app_id');
    @endphp
    @if($fb_app_id)
    <meta property="fb:app_id" content="{{ $fb_app_id }}"/>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ $icon }}" sizes="32x32"/>
    <link rel="icon" href="{{ $icon }}" sizes="192x192"/>
    <link rel="apple-touch-icon-precomposed" href="{{ $icon }}"/>
    <meta name="msapplication-TileImage" content="{{ $icon }}"/>
    <link rel="stylesheet" href="{{ asset('styles/themes/mymo/css/main.css') }}"/>

    <script type='text/javascript'>
        /* <![CDATA[ */
        var mymo = {
            "ajax_search_url": "{{ route('search') }}",
            "ajax_notification_url": "{{ route('account.notifications') }}",
            "ajax_remove_all_notification_url": "{{ route('account.notifications.read_all') }}",
            "ajax_popular_movies_url": "{{ route('movies.popular') }}",
            "ajax_get_movies_by_genre_url": "{{ route('movies.genre') }}",
            "ajax_filter_form_url": "{{ route('search.form') }}",
            "light_mode":"0",
            "light_mode_btn":"1",
            "ajax_live_search":"1",
            "sync":null,
            "db_redirect_url":"{{ url()->current() }}",
            "languages": {
                'notification': '@lang('app.notification')',
                'nothing_found': '@lang('app.nothing_found')',
                'remove_all': '@lang('app.remove_all')',
                'bookmark': '@lang('app.bookmark')',
            }
        };
        /* ]]> */
    </script>

    <script type='text/javascript'>
        /* <![CDATA[ */
        var ajax_auth_object = {
            "login_url": "{{ route('login.submit') }}",
            "register_url": "{{ route('register.submit') }}",
            "forgot_password_url": "{{ route('register.submit') }}",
            "redirecturl":"{{ url()->current() }}",
            "loadingmessage":"@lang('app.sending_user_info_please_wait')",
            "recaptcha":"{{ get_config('google_recaptcha') }}",
            "sitekey":"{{ get_config('google_recaptcha_key') }}",
            "languages":{
                "login":"@lang('app.login')",
                "register":"@lang('app.register')",
                "forgotpassword":"@lang('app.forgot_password')?",
                "already_account":"@lang('app.already_have_an_account')",
                "create_account":"@lang('app.create_account')",
                "reset_captcha":"@lang('app.reset_captcha')",
                "username":"@lang('app.name')",
                "email":"@lang('app.email')",
                "username_email":"@lang('app.email')",
                "password":"@lang('app.password')",
                "reset_password":"@lang('app.reset_password')",
                "login_with":"@lang('app.login_with')",
                "register_with":"@lang('app.register_with')",
                "or":"@lang('app.or')",
                "apparently_there_are_no_posts_to_show": "@lang('app.apparently_there_are_no_posts_to_show')"
            }
        };
        /* ]]> */
    </script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('styles/themes/mymo/js/main.js') }}"></script>

    <!-- Google Analytics -->

    <!-- End Google Analytics -->

    <style type="text/css">
        #header .site-title {
            background: url({{ image_url(get_config('logo')) }}) no-repeat top left;
            text-indent: -9999px;
        }
    </style>
</head>
<body class="{{ $body_class }}" data-masonry="" data-nonce="9d27ce22e4">
@if($fb_app_id)
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&autoLogAppEvents=1&version=v8.0&appId={{ $fb_app_id }}" nonce="ozkqznFT"></script>
@endif

@include('themes.mymo.header')
@include('themes.mymo.menu')
<!-- /header -->
@if(request()->is('/'))
    @include('themes.mymo.slider')
@endif

<div class="container-fluid mymo-full-player hidden mymo-centered">
    <div id="mymo-full-player" class="container col-md-offset-2s col-md-9"></div>
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
        <a href="javascript:hide_float_left()">[X]</a>
    </div>

    <div id="float_content_left">
        <!-- Start quang cao-->

        <!-- End quang cao -->
    </div>
</div>

</body>
</html>
