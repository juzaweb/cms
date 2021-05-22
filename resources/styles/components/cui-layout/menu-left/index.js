/////////////////////////////////////////////////////////////////////////////////////////
// "cui-menu-right" module scripts

; $(document).on("turbolinks:load", function() {
    'use strict'
    $(function () {
        if ($('body').find('.cui__menuLeft').length < 1) {
            return
        }

        /////////////////////////////////////////////////////////////////////////////////////////
        // set active menu item on load

        var url = window.location.href;
        //var page = url.substr(url.lastIndexOf('/') + 1)
        var page = url;

        var index = 1;

        while (index <= 10) {
            var currentItem = $('.cui__menuLeft').find('a[href="' + page + '"]');

            if (currentItem.length > 0) {
                currentItem
                    .addClass('cui__menuLeft__item--active')
                    .closest('.cui__menuLeft__submenu')
                    .addClass('cui__menuLeft__submenu--toggled')
                    .find('> .cui__menuLeft__navigation')
                    .show();

                break;
            }

            var arrSplit = page.split("/");
            page = page.replace('/' + arrSplit[arrSplit.length - 1], '');

            if (!page) {
                break;
            }

            index++;
        }



        /////////////////////////////////////////////////////////////////////////////////////////
        // toggle on resize
        ; (function () {
            var isTabletView = false
            function toggleMenu() {
                if (!isTabletView) {
                    $('body').addClass('cui__menuLeft--toggled')
                }
            }
            if ($(window).innerWidth() <= 992) {
                toggleMenu()
                isTabletView = true
            }
            $(window).on('resize', function () {
                if ($(window).innerWidth() <= 992) {
                    toggleMenu()
                    isTabletView = true
                } else {
                    isTabletView = false
                }
            })
        })()

        /////////////////////////////////////////////////////////////////////////////////////////
        // toggle

        $('.cui__menuLeft__trigger').on('click', function () {
            $('body').toggleClass('cui__menuLeft--toggled')
        })

        /////////////////////////////////////////////////////////////////////////////////////////
        // mobile toggle

        $('.cui__menuLeft__backdrop, .cui__menuLeft__mobileTrigger').on('click', function () {
            $('body').toggleClass('cui__menuLeft--mobileToggled')
        })

        /////////////////////////////////////////////////////////////////////////////////////////
        // mobile toggle slide

        var touchStartPrev = 0
        var touchStartLocked = false

        const unify = e => {
            return e.changedTouches ? e.changedTouches[0] : e
        }
        document.addEventListener(
            'touchstart',
            e => {
                const x = unify(e).clientX
                touchStartPrev = x
                touchStartLocked = x > 70
            },
            { passive: false },
        )
        document.addEventListener(
            'touchmove',
            e => {
                const x = unify(e).clientX
                const prev = touchStartPrev
                if (x - prev > 50 && !touchStartLocked) {
                    $('body').toggleClass('cui__menuLeft--mobileToggled')
                    touchStartLocked = true
                }
            },
            { passive: false },
        )

        /////////////////////////////////////////////////////////////////////////////////////////
        // submenu

        /*$('.cui__menuLeft__submenu > .cui__menuLeft__item__link').on('click', function () {
            var el = $(this).closest('.cui__menuLeft__submenu'),
                opened = $('.cui__menuLeft__submenu--toggled')

            if (
                !el.hasClass('cui__menuLeft__submenu--toggled') &&
                !el.parent().closest('.cui__menuLeft__submenu').length
            )
                opened
                    .removeClass('cui__menuLeft__submenu--toggled')
                    .find('> .cui__menuLeft__navigation')
                    .slideUp(200)

            el.toggleClass('cui__menuLeft__submenu--toggled')
            var item = el.find('> .cui__menuLeft__navigation')
            if (item.is(':visible')) {
                item.slideUp(200)
            } else {
                item.slideDown(200)
            }
        })*/
    })
});
