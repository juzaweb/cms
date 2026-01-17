$(document).on('ready', function () {
    // initialization of header
    var header = new HSHeader($('#header')).init();

    // initialization of mega menu
    var megaMenu = new HSMegaMenu($('.js-mega-menu'), {
        desktop: {
            position: 'left'
        }
    }).init();

    // initialization of fancybox
    $('.js-fancybox').each(function () {
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
    $('.js-animation-link').each(function () {
        var showAnimation = new HSShowAnimation($(this)).init();
    });

    // initialization of counter
    $('.js-counter').each(function() {
        var counter = new HSCounter($(this)).init();
    });

    // initialization of sticky block
    var cbpStickyFilter = new HSStickyBlock($('#cbpStickyFilter'));

    // initialization of cubeportfolio
    $('.cbp').each(function () {
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
    $('#cbpStickyFilter').on('click', '.cbp-filter-item', function (e) {
        $('html, body').stop().animate({
            scrollTop: $('#demoExamplesSection').offset().top
        }, 200);
    });

    // initialization of go to
    $('.js-go-to').each(function () {
        var goTo = new HSGoTo($(this)).init();
    });

    // initialization of select picker
    $('.js-custom-select').each(function () {
        var select2 = $.HSCore.components.HSSelect2.init($(this));
    });
});