<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ setting('favicon') ? upload_url(setting('favicon')) : '/favicon.ico' }}" />
    <!-- Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Open+Sans:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('css/main.min.css', 'themes/itube') }}">

    <title>@yield('title')</title>

    @include('core::components.theme-head')

    <x-theme-js-var view-page="{{ $viewPage ?? '' }}" />

    @yield('head')

</head>

<body class="juzaweb-theme @yield('body-classes')">
    @include('itube::layouts.components.header')

    <!-- ========== MAIN CONTENT ========== -->
    <main id="content">
        @yield('content')
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
    @include('itube::layouts.components.footer')

    <!-- ========== SECONDARY CONTENTS ========== -->
    @include('itube::layouts.components.login_modal')

    <!-- ========== END SECONDARY CONTENTS ========== -->

    <!-- Go to Top -->
    <a class="js-go-to go-to position-fixed" href="javascript:;" style="visibility: hidden;"
        data-hs-go-to-options='{
            "offsetTop": 700,
            "position": {
                "init": {
                    "right": 15
                },
                "show": {
                    "bottom": 15
                },
                "hide": {
                    "bottom": -15
                }
            }
        }'>
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- End Go to Top -->

    <script src="{{ mix('js/main.min.js', 'themes/itube') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.min.js"></script>
    <!-- JS Plugins Init. -->
    <script>
        // Set min hight content = .youtube-sidebar height + 300px
        function setMinHeightContent() {
            if ($('.youtube-sidebar').length === 0) {
                return;
            }

            let sidebarHeight = $('.youtube-sidebar').outerHeight();

            $('#content').css('min-height', (sidebarHeight + 300) + 'px');
        }

        setMinHeightContent();

        $(document).on('ready', function() {
            const lazy = lazyload();
            // initialization of header
            var header = new HSHeader($('#header')).init();

            // initialization of mega menu
            var megaMenu = new HSMegaMenu($('.js-mega-menu'), {
                desktop: {
                    position: 'left'
                }
            }).init();

            // initialization of fancybox
            $('.js-fancybox').each(function() {
                var fancybox = $.HSCore.components.HSFancyBox.init($(this));
            });

            // initialization of unfold
            var unfold = new HSUnfold('.js-hs-unfold-invoker').init();


            // initialization of slick carousel
            $('.js-slick-carousel').each(function() {
                var slickCarousel = $.HSCore.components.HSSlickCarousel.init($(this));
            });

            // initialization of form validation
            $('.js-validate').each(function() {
                $.HSCore.components.HSValidation.init($(this), {
                    rules: {
                        confirmPassword: {
                            equalTo: '#signupPassword'
                        }
                    }
                });
            });

            // initialization of show animations
            $('.js-animation-link').each(function() {
                var showAnimation = new HSShowAnimation($(this)).init();
            });

            // initialization of counter
            $('.js-counter').each(function() {
                var counter = new HSCounter($(this)).init();
            });

            // initialization of sticky block
            var cbpStickyFilter = new HSStickyBlock($('#cbpStickyFilter'));

            // initialization of cubeportfolio
            $('.cbp').each(function() {
                var cbp = $.HSCore.components.HSCubeportfolio.init($(this), {
                    layoutMode: 'grid',
                    filters: '#filterControls',
                    displayTypeSpeed: 0
                });
            });

            $('.cbp').on('initComplete.cbp', function() {
                // update sticky block
                cbpStickyFilter.update();

                // initialization of aos
                AOS.init({
                    duration: 650,
                    once: true
                });
            });

            $('.cbp').on('filterComplete.cbp', function() {
                // update sticky block
                cbpStickyFilter.update();

                // initialization of aos
                AOS.init({
                    duration: 650,
                    once: true
                });
            });

            $('.cbp').on('pluginResize.cbp', function() {
                // update sticky block
                cbpStickyFilter.update();
            });

            // animated scroll to cbp container
            $('#cbpStickyFilter').on('click', '.cbp-filter-item', function(e) {
                $('html, body').stop().animate({
                    scrollTop: $('#demoExamplesSection').offset().top
                }, 200);
            });

            // initialization of go to
            $('.js-go-to').each(function() {
                var goTo = new HSGoTo($(this)).init();
            });

            // initialization of select picker
            $('.js-custom-select').each(function() {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>
    <!-- IE Support -->

    <script>
        if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) {
            document.write('<script src="{{ asset('themes/itube/vendor/polifills.js') }}"><\/script>');
        }
    </script>

    <form action="{{ route('logout') }}" method="post" style="display: none" class="form-logout">
        @csrf
    </form>

    @yield('scripts')

    <x-theme-init />

    @if (setting('custom_footer_script'))
        {!! setting('custom_footer_script') !!}
    @endif

</body>

</html>
