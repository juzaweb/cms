<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description }}">
    <meta name="turbolinks-cache-control" content="no-cache">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ $description }}">
    <meta name="twitter:card" content="summary">
    <meta property="twitter:title" content="{{ $title }}">
    <meta property="twitter:description" content="{{ $description }}">

    <link href="//fonts.googleapis.com" rel="dns-prefetch"/>
    <link href="//www.gstatic.com" rel="dns-prefetch"/>
    <link href="//www.googletagmanager.com" rel="dns-prefetch"/>

    @php $sitename = get_config('sitename') @endphp
    @php $icon = get_config('icon') @endphp
    @php $fbAppId = get_config('fb_app_id') @endphp

    @if($image ?? null)
    <meta property="og:image" content="{{ upload_url($image) }}" />
    @endif

    @if($sitename)
    <meta property="og:site_name" content="{{ $sitename }}"/>
    @endif

    @if($fbAppId)
    <meta property="fb:app_id" content="{{ $fbAppId }}"/>
    @endif

    <link rel="canonical" href="{{ url()->current() }}" />

    @if(get_config('jw_enable_post_feed', 1))
    <link rel="alternate" type="application/atom+xml" title="{{ get_config('title') }} &raquo; Feed" href="{{ url('feed') }}">
    @endif

    @if($taxonomy ?? null && get_config('jw_enable_taxonomy_feed', 1))
    <link rel="alternate" type="application/atom+xml" title="{{ $name }} &raquo; Feed" href="{{ url('taxonomy/'. $taxonomy->slug .'/feed') }}">
    @endif

    @if($icon)
    <link rel="icon" href="{{ upload_url($icon) }}" />
    @endif

    <title>{{ apply_filters('frontend.head.title', $title) }}@if($sitename) | {{ $sitename }}@endif</title>

    @do_action('theme.header')

    @yield('header')
</head>

<body class="{{ body_class($post ? 'single-post single-post-'. $post->type : '') }} {{ $bodyClass ?? '' }}">
    @do_action('theme.after_body')

    @include('theme::header')

    @yield('content')

    @include('theme::footer')

    @do_action('theme.footer')

    @yield('footer')

    @if($auth)
    <form action="{{ url('logout') }}"
          method="post"
          style="display: none"
          class="form-logout"
    >
        {{ csrf_field() }}
    </form>
    @endif
</body>
</html>
