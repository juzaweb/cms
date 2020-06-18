/////////////////////////////////////////////////////////////////////////////////////////
// "cui-topbar" module scripts

;(function($) {
  'use strict'
  $(function() {
    $('.cui__topbar__actionsDropdown .dropdown-menu').on('click', function() {
      $('.cui__topbar__actionsDropdown').on('hide.bs.dropdown', function(event) {
        event.preventDefault() // stop hiding dropdown on click

        $('.cui__topbar__actionsDropdown .nav-link').on('shown.bs.tab', function(e) {
          $('.cui__topbar__actionsDropdown .dropdown-toggle').dropdown('update')
        })
      })
    })

    $(document, '.cui__topbar__actionsDropdown .dropdown-toggle').mouseup(function(e) {
      var dropdown = $('.cui__topbar__actionsDropdown')
      var dropdownMenu = $('.cui__topbar__actionsDropdownMenu')

      if (
        !dropdownMenu.is(e.target) &&
        dropdownMenu.has(e.target).length === 0 &&
        dropdown.hasClass('show')
      ) {
        dropdown.removeClass('show')
        dropdownMenu.removeClass('show')
      }
    })

    ///////////////////////////////////////////////////////////
    // livesearch scripts

    var livesearch = $('.cui__topbar__livesearch')
    var close = $('.cui__topbar__livesearch__close')
    var visibleClass = 'cui__topbar__livesearch__visible'
    var input = $('#livesearch__input')
    var inputInner = $('#livesearch__input__inner')

    function setHidden() {
      livesearch.removeClass(visibleClass)
    }
    function handleKeyDown(e) {
      const key = event.keyCode.toString()
      if (key === '27') {
        setHidden()
      }
    }
    input.on('focus', function() {
      livesearch.addClass(visibleClass)
      setTimeout(function() {
        inputInner.focus()
      }, 200)
    })
    close.on('click', setHidden)
    document.addEventListener('keydown', handleKeyDown, false)
  })
})(jQuery)
