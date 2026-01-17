/*
* Validation wrapper
* @version: 2.0.0 (Mon, 25 Nov 2019)
* @requires: jQuery v3.0 or later, jQuery Validation v1.19.1
* @author: HtmlStream
* @event-namespace: .HSCore.components.HSValidation
* @license: Htmlstream Libraries (https://htmlstream.com/licenses)
* Copyright 2020 Htmlstream
*/

;(function ($) {
	'use strict';

	$.HSCore.components.HSValidation = {
		defaults: {
			errorElement: 'div',
			errorClass: 'invalid-feedback'
		},

		init: function (el, options) {
			if (!el.length) return;

			var context = this,
				defaults = Object.assign({}, context.defaults),
				dataSettings = el.attr('data-hs-validation-options') ? JSON.parse(el.attr('data-hs-validation-options')) : {},
				settings = {
					errorPlacement: context.errorPlacement,
					highlight: context.highlight,
					unhighlight: context.unHighlight,
					submitHandler: context.submitHandler,
					onkeyup: function (element) {
						$(element).valid();
					}
				};
			settings = $.extend(true, defaults, settings, dataSettings, options);

			/* Start : object preparation */

			if (el.hasClass('js-step-form')) {
				$.validator.setDefaults({
					ignore: ':hidden:not(.active select)'
				});
			} else {
				$.validator.setDefaults({
					ignore: ':hidden:not(select)'
				});
			}

			/* End : object preparation */

			/* Start : Init */

			var newValidate = el.validate(settings);

			/* End : Init */

			/* Start : custom functionality implementation */

			if (el.find('select').length) {
				el.find('select').change(function () {
					$(this).valid();
				});
			}

			/* End : custom functionality implementation */

			return newValidate;
		},

		rules: function (el) {
			var args = Array.prototype.slice.call(arguments, 1);

			$.fn.rules.apply(el, args);
		},

		errorPlacement: function (error, element) {
			var $this = $(element),
				errorMsgClasses = $this.data('error-msg-classes');

			error.addClass(errorMsgClasses);
			error.appendTo(element.parents('.js-form-message'));
		},

		highlight: function (element) {
			var $this = $(element),
				errorClass = $this.data('error-class') ? $this.data('error-class') : 'is-invalid',
				successClass = $this.data('success-class') ? $this.data('error-class') : 'is-valid';

			$this.removeClass(successClass).addClass(errorClass);
		},

		unHighlight: function (element) {
			var $this = $(element),
				errorClass = $this.data('error-class') ? $this.data('error-class') : 'is-invalid',
				successClass = $this.data('success-class') ? $this.data('error-class') : 'is-valid';

			$this.removeClass(errorClass).addClass(successClass);
		},

		submitHandler: function (form) {
			form.submit();
		}
	};

})(jQuery);
