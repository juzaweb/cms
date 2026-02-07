<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('core::components.theme-head')

    <title>@yield('title'){{ setting('sitename') ? ' - ' . setting('sitename') : '' }}</title>

    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css' rel='stylesheet' />
    <link href='{{ mix('css/google-fonts.min.css', 'themes/itech') }}' rel='stylesheet' />
    <link href='{{ mix('css/main.min.css', 'themes/itech') }}' rel='stylesheet' />

    <x-theme-js-var view-page="{{ $viewPage ?? '' }}" />

    <script type="text/javascript">
        const loadPostUrl = "{{ route('home.load-posts') }}"
    </script>

    @yield('head')
</head>

<body class="juzaweb-theme @yield('body-classes')">
    <!-- Theme Options -->
    <div class='theme-options' style='display:none'>
        <div class='sora-panel section' id='sora-panel' name='Theme Options'>
            <div class='widget LinkList' data-version='2' id='LinkList71'>

                <script type='text/javascript'>
                    //<![CDATA[
                    const fixedSidebar = true;
                    const postPerPage = 10;
                    const noThumbnail = "{{ asset('assets/images/no-thumbnail.png') }}";
                    //]]>
                </script>
            </div>
        </div>
    </div>
    <!-- Outer Wrapper -->
    <div id='outer-wrapper'>
        <div id='top-bar'>
            <div class='container row'>
                <div class='top-bar-nav section' id='top-bar-nav' name='Top Navigation'>
                    <div class='widget LinkList' data-version='2' id='LinkList72'>
                        <div class='widget-content'>
                            {{-- <ul>
                            <li><a href='/login'>{{ __('itech::translation.login') }}</a></li>
                            <li><a href='/register'>{{ __('itech::translation.register') }}</a></li>
                        </ul> --}}
                        </div>
                    </div>
                </div>

                @include('itech::components.language-selector')

                @php
                    $socials = config('itech.socials', []);
                @endphp
                <!-- Top Social -->
                <div class='top-bar-social social section' id='top-bar-social' name='Social Top'>
                    <div class='widget LinkList' data-version='2' id='LinkList73'>
                        <div class='widget-content'>
                            <ul>
                                @foreach ($socials as $social)
                                    @php $set = theme_setting("social_{$social}") @endphp

                                    @continue(!$set)

                                    <li class='{{ $social == 'x' ? 'x-twitter' : $social }}'>
                                        <a href='{{ $set }}' target='_blank'
                                            title='{{ ucfirst($social) }}'></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='clearfix'></div>
        <!-- Header Wrapper -->
        <div id='header-wrap'>
            <div class='mobile-menu-wrap'>
                <div class='mobile-menu'></div>
            </div>
            <div class='container row'>
                <div class='header-logo'>
                    <div class='main-logo section' id='main-logo' name='Header Logo'>
                        <div class='widget Header' data-version='2' id='Header1'>
                            <div class='header-widget'>
                                <a class='header-image-wrapper' href='{{ home_url() }}'>
                                    <img alt='{{ setting('description') }}' data-height='52' data-width='223'
                                        src='{{ logo_url() }}' />
                                </a>
                                <p>{{ setting('description') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='header-menu'>
                    @php
                        $menu = nav_location('main');
                    @endphp
                    <div class='main-menu section' id='main-menu' name='Main Menu'>
                        <div class='widget LinkList' data-version='2' id='LinkList74'>
                            <ul id='main-menu-nav' role='menubar'>
                                @foreach ($menu?->items ?? [] as $item)
                                    <li class="{{ $item->children->isNotEmpty() ? 'has-sub' : '' }}">
                                        <a href='{{ $item->getUrl() }}' role='menuitem'
                                            @if ($item->target == '_blank') target="_blank" @endif>{{ $item->label }}</a>
                                        @if ($item->children->isNotEmpty())
                                            <ul class="sub-menu m-sub">
                                                @foreach ($item->children as $child)
                                                    <li>
                                                        <a href="{{ $child->getUrl() }}" role="menuitem"
                                                            @if ($child->target == '_blank') target="_blank" @endif>{{ $child->label }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div id='nav-search'>
                    <form action='{{ home_url('search') }}' class='search-form' role='search'>
                        <input autocomplete='off' class='search-input' name='q'
                            placeholder='{{ __('itech::translation.search_this_blog') }}' type='search'
                            value='{{ request()->get('q') }}' />
                        <span class='hide-search'></span>
                    </form>
                </div>

                <span class='show-search'></span>
                <span class='mobile-menu-toggle'></span>
            </div>
        </div>
        <div class='clearfix'></div>
        <!-- Main Top Bar -->

        @yield('content')

        <!-- Footer Wrapper -->
        <div id='footer-wrapper'>
            <div class='primary-footer'>
                <div class='container row'>
                    <div class='footer-about-area section' id='footer-about-area' name='About & Logo Section'>
                        <div class='widget Image' data-version='2' id='Image150'>
                            <a class='footer-logo custom-image' href='{{ home_url() }}'>
                                <img alt='{{ setting('title') }}' id='Image150_img' class="lazy-yard"
                                    src='{{ theme_setting('footer_logo') ? upload_url(theme_setting('footer_logo')) : logo_url() }}' />
                            </a>
                            <p class='image-caption excerpt'>
                                {{ theme_setting('footer_description') ?? setting('description') }}</p>
                        </div>
                    </div>
                    <!-- Footer Social -->
                    <div class='foot-bar-social social social-color section' id='foot-bar-social'
                        name='Social Footer'>
                        <div class='widget LinkList' data-version='2' id='LinkList78'>
                            <div class='widget-content'>
                                <ul>
                                    @foreach ($socials as $social)
                                        @php $set = theme_setting("social_{$social}") @endphp

                                        @continue(!$set)

                                        <li class='{{ $social == 'x' ? 'x-twitter' : $social }}'>
                                            <a href='{{ $set }}' target='_blank'
                                                title='{{ ucfirst($social) }}'></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='clearfix'></div>
            <div class='container row' style='display: none;'>
                <div class='footer-widgets-wrap'>
                    <div class='footer common-widget no-items section' id='footer-sec1' name='Section (Left)'>
                    </div>
                    <div class='footer common-widget no-items section' id='footer-sec2' name='Section (Center)'>
                    </div>
                    <div class='footer common-widget no-items section' id='footer-sec3' name='Section (Right)'>
                    </div>
                    <div class='clearfix'></div>
                </div>
            </div>
            <div class='clearfix'></div>
            <div id='sub-footer-wrapper'>
                <div class='container row'>
                    <div class='menu-footer section' id='menu-footer' name='Footer Menu'>
                        <div class='widget LinkList' data-version='2' id='LinkList76'>
                            <div class='widget-title'>
                                <h3 class='title'>
                                    Footer Menu Widget
                                </h3>
                            </div>
                            @php
                                $menu = nav_location('footer');
                            @endphp

                            @if ($menu)
                                <div class='widget-content'>
                                    <ul>
                                        @foreach ($menu?->items ?? [] as $item)
                                            <li>
                                                <a href='{{ $item->getUrl() }}'
                                                    @if ($item->target == '_blank') target="_blank" @endif>{{ $item->label }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class='copyright-area'>
                        &copy; 2025 {{ setting('sitename') }} <i aria-hidden='true' class='fa fa-heart'
                            style='color: red;margin:0 2px;'></i>
                        All rights reserved. Provided by <a href='https://juzaweb.com' target='_blank'>Juzaweb</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-theme-init />
    <!-- Main Scripts -->
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js' type='text/javascript'></script>
    <script src='{{ mix('js/vendor.min.js', 'themes/itech') }}' type='text/javascript'></script>
    <script src='{{ mix('js/main.min.js', 'themes/itech') }}' type='text/javascript'></script>

    <!-- Overlay and Back To Top -->
    <div class='back-top' title='{{ __('itech::translation.back_to_top') }}'></div>
    <form action="{{ route('logout') }}" method="post" style="display: none" class="form-logout">
        @csrf
    </form>

    @yield('scripts')

    @if (setting('custom_footer_script'))
        {!! setting('custom_footer_script') !!}
    @endif

</body>

</html>
