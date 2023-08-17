<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('jw-styles/juzaweb/images/favicon.ico') }}"/>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,400i,700&display=swap"/>

    @include('cms::components.juzaweb_langs')

    @do_action('juzaweb_header')

    @viteReactRefresh

    @vite(
        ["resources/js/app.tsx", "resources/css/app.css", "resources/js/pages/{$page['component']}.tsx"],
        'jw-styles/juzaweb/build'
    )

    @php
        $__inertiaSsrDispatched = true;
        $__inertiaSsrResponse = null;
    @endphp

    @inertiaHead
</head>
<body class="juzaweb__menuLeft--dark juzaweb__menuLeft--unfixed juzaweb__menuLeft--shadow">
<div id="admin-overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>

<div class="juzaweb__layout juzaweb__layout--hasSider">

    <div class="juzaweb__menuLeft">
        <div class="juzaweb__menuLeft__mobileTrigger"><span></span></div>

        <div class="juzaweb__menuLeft__outer">
            <div class="juzaweb__menuLeft__logo__container">
                <a href="/{{ config('juzaweb.admin_prefix') }}">
                    <div class="juzaweb__menuLeft__logo">
                        <img src="{{ asset('jw-styles/juzaweb/images/logo.svg') }}" class="mr-1" alt="Juzaweb">
                        <div class="juzaweb__menuLeft__logo__name">JuzaWeb</div>
                        <div class="juzaweb__menuLeft__logo__descr">Cms</div>
                    </div>
                </a>
            </div>

            <div class="juzaweb__menuLeft__scroll jw__customScroll">
                @include('cms::backend.menu_left')
            </div>
        </div>
    </div>
    <div class="juzaweb__menuLeft__backdrop"></div>

    <div class="juzaweb__layout">
        <div class="juzaweb__layout__header">
            @include('cms::backend.menu_top')
        </div>

        <div class="juzaweb__layout__content">
            @if(!request()->is(config('juzaweb.admin_prefix')))
                {{
                    jw_breadcrumb(
                        'admin',
                         [
                            [
                                'title' => $page['props']['title'] ?? '',
                            ]
                        ]
                    )
                }}
            @else
                <div class="mb-3"></div>
            @endif

                @inertia


        </div>

        <div class="juzaweb__layout__footer">
            <div class="juzaweb__footer">
                <div class="juzaweb__footer__inner">
                    <a href="https://juzaweb.com" target="_blank" rel="noopener noreferrer"
                       class="juzaweb__footer__logo">
                        Juzaweb - Build website professional
                        <span></span>
                    </a>
                    <br/>
                    <p class="mb-0">
                        Copyright © 2020 {{ get_config('title') }} - Provided by Juzaweb
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('logout') }}" method="post" class="form-logout box-hidden">
    @csrf
</form>

@do_action('juzaweb_footer')

</body>
</html>
