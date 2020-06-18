/////////////////////////////////////////////////////////////////////////////////////////
// "cui-menu-right" module scripts
; (function ($) {
  'use strict'
  $(function () {
    /////////////////////////////////////////////////////////////////////////////////////////
    // hide non top menu related settings
    if ($('.cui__menuTop').length) {
      $('.hideIfMenuTop').css({
        pointerEvents: 'none',
        opacity: 0.4,
      })
    }

    /////////////////////////////////////////////////////////////////////////////////////////
    // toggle
    $('.cui__sidebar__actionToggle').on('click', function () {
      $('body').toggleClass('cui__sidebar--toggled')
    })

    /////////////////////////////////////////////////////////////////////////////////////////
    // toggle theme
    $('.cui__sidebar__actionToggleTheme').on('click', function () {
      var theme = document.querySelector('html').getAttribute('data-kit-theme')
      if (theme === 'dark') {
        document.querySelector('html').setAttribute('data-kit-theme', 'default')
        $('body').removeClass(
          'kit__dark cui__menuLeft--gray cui__menuTop--gray cui__menuLeft--dark cui__menuTop--dark',
        )
      }
      if (theme === 'default') {
        document.querySelector('html').setAttribute('data-kit-theme', 'dark')
        $('body').removeClass(
          'cui__menuLeft--gray cui__menuTop--gray cui__menuLeft--dark cui__menuTop--dark',
        )
        $('body').addClass('cui__menuLeft--dark cui__menuTop--dark')
      }
    })

    /////////////////////////////////////////////////////////////////////////////////////////
    // app name
    function updateName(name) {
      window.localStorage.setItem('appName', name)
      var el = $('.cui__menuLeft').length
        ? $('.cui__menuLeft__logo__name')
        : $('.cui__menuTop__logo__name')
      var descr = $('.cui__menuLeft').length
        ? $('.cui__menuLeft__logo__descr')
        : $('.cui__menuTop__logo__descr')
      el.html(name)
      if (name !== 'Clean UI Pro') {
        descr.hide()
      } else {
        descr.show()
      }
    }
    $('#appName').on('keyup', function (e) {
      var value = e.target.value
      updateName(value)
    })
    var appName = window.localStorage.getItem('appName')
    if (appName) {
      updateName(appName)
      $('#appName').val(appName)
    }

    /////////////////////////////////////////////////////////////////////////////////////////
    // set primary color
    function setPrimaryColor(color) {
      function setColor(_color) {
        window.localStorage.setItem('kit.primary', _color)
        var tag = '<style />'
        var css = `:root { --kit-color-primary: ${_color};}`
        $(tag)
          .attr('id', 'primaryColor')
          .text(css)
          .prependTo('body')
      }
      var style = $('#primaryColor')
      style ? (style.remove(), setColor(color)) : setColor(color)
    }
    var color = window.localStorage.getItem('kit.primary')
    if (color) {
      $('#colorPicker').val(color)
      setPrimaryColor(color)
      $('#resetColor')
        .parent()
        .removeClass('reset')
    }
    $('#colorPicker').on('change', function () {
      var value = $(this).val()
      setPrimaryColor(value)
      $('#resetColor')
        .parent()
        .removeClass('reset')
    })
    $('#resetColor').on('click', function () {
      window.localStorage.removeItem('kit.primary')
      $('#primaryColor').remove()
      $('#resetColor')
        .parent()
        .addClass('reset')
    })

    /////////////////////////////////////////////////////////////////////////////////////////
    // switch
    $('.cui__sidebar__switch input').on('change', function () {
      var el = $(this)
      var checked = el.is(':checked')
      var to = el.attr('to')
      var setting = el.attr('setting')
      if (checked) {
        $(to).addClass(setting)
      } else {
        $(to).removeClass(setting)
      }
    })

    $('.cui__sidebar__switch input').each(function () {
      var el = $(this)
      var to = el.attr('to')
      var setting = el.attr('setting')
      if ($(to).hasClass(setting)) {
        el.attr('checked', true)
      }
    })

    /////////////////////////////////////////////////////////////////////////////////////////
    // colors
    $('.cui__sidebar__select__item').on('click', function () {
      var el = $(this)
      var parent = el.parent()
      var to = parent.attr('to')
      var setting = el.attr('setting')
      var items = parent.find('> div')
      var classList = ''
      items.each(function () {
        var setting = $(this).attr('setting')
        if (setting) {
          classList = classList + ' ' + setting
        }
      })
      items.removeClass('cui__sidebar__select__item--active')
      el.addClass('cui__sidebar__select__item--active')
      $(to).removeClass(classList)
      $(to).addClass(setting)
    })

    $('.cui__sidebar__select__item').each(function () {
      var el = $(this)
      var parent = el.parent()
      var to = parent.attr('to')
      var setting = el.attr('setting')
      var items = parent.find('> div')
      if ($(to).hasClass(setting)) {
        items.removeClass('cui__sidebar__select__item--active')
        el.addClass('cui__sidebar__select__item--active')
      }
    })

    /////////////////////////////////////////////////////////////////////////////////////////
    // type
    $('.cui__sidebar__type__items input').on('change', function () {
      var el = $(this)
      var checked = el.is(':checked')
      var to = el.attr('to')
      var setting = el.attr('setting')
      $('body').removeClass('cui__menu--compact cui__menu--flyout cui__menu--nomenu')
      if (checked) {
        $(to).addClass(setting)
      } else {
        $(to).removeClass(setting)
      }
    })

    $('.cui__sidebar__type__items input').each(function () {
      var el = $(this)
      var to = el.attr('to')
      var setting = el.attr('setting')
      if ($(to).hasClass(setting)) {
        el.attr('checked', true)
      }
    })
  })
})(jQuery)
