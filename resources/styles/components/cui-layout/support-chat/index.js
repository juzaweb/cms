/////////////////////////////////////////////////////////////////////////////////////////
// "chat" module scripts

;$(document).on("turbolinks:load", function() {
  'use strict'
  $(function() {
    /////////////////////////////////////////////////////////////////////////////////////////
    // toggle
    $('.kit__chat__actionToggle').on('click', function() {
      $('body').toggleClass('kit__chat--open')
    })
  })
});