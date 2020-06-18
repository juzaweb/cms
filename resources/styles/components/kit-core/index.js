/////////////////////////////////////////////////////////////////////////////////////////
// "core" module scripts

;(function($) {
  'use strict'
  $(function() {
    /////////////////////////////////////////////////////////////////////////////////////////
    // custom scroll

    if ($('.kit__customScroll').length) {
      if (!/Mobi/.test(navigator.userAgent) && jQuery().perfectScrollbar) {
        $('.kit__customScroll').perfectScrollbar({
          theme: 'kit',
        })
      }
    }

    /////////////////////////////////////////////////////////////////////////////////////////
    // tooltips & popovers
    $('[data-toggle=tooltip]').tooltip()
    $('[data-toggle=popover]').popover()
  })
})(jQuery)
