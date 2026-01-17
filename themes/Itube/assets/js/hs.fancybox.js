/*
* Fancybox wrapper
* @version: 2.0.0 (Mon, 25 Nov 2019)
* @requires: jQuery v3.0 or later, fancybox v3.5.7
* @author: HtmlStream
* @event-namespace: .HSCore.components.HSFancyBox
* @license: Htmlstream Libraries (https://htmlstream.com/licenses)
* Copyright 2020 Htmlstream
*/

;(function ($) {
	'use strict';

	$.HSCore.components.HSFancyBox = {
		defaults: {
			parentEl: 'html',
			baseClass: 'fancybox-theme',
			slideClass: 'fancybox-slide',
			speed: 2000,
			animationEffect: 'fade',
			slideSpeedCoefficient: 1,
			infobar: false,
			slideShow: {
				autoStart: false,
				speed: 2000
			},
			transitionEffect: 'slide',
			baseTpl: '<div class="fancybox-container" role="dialog" tabindex="-1">' +
				'<div class="fancybox-bg"></div>' +
				'  <div class="fancybox-inner">' +
				'    <div class="fancybox-infobar">' +
				'      <span data-fancybox-index></span>&nbsp;/&nbsp;<span data-fancybox-count></span>' +
				'    </div>' +
				'    <div class="fancybox-toolbar">{{buttons}}</div>' +
				'    <div class="fancybox-navigation">{{arrows}}</div>' +
				'    <div class="fancybox-slider-wrap">' +
				'      <div class="fancybox-stage"></div>' +
				'    </div>' +
				'    <div class="fancybox-caption-wrap">' +
				'      <div class="fancybox-caption">' +
				'        <div class="fancybox-caption__body"></div>' +
				'      </div>' +
				'    </div>' +
				'  </div>' +
				'</div>'
		},

		init: function (el, options) {
			if (!el.length) return;

			var context = this,
				$el = $(el),
				defaults = Object.assign({}, context.defaults),
				dataSettings = $el.attr('data-hs-fancybox-options') ? JSON.parse($el.attr('data-hs-fancybox-options')) : {},
				settings = {
					beforeShow: function (instance) {
						var $fancyOverlay = $(instance.$refs.bg[0]),
							$fancySlide = $(instance.current.$slide),
							dataSettings = instance.current.opts.$orig[0].dataset.hsFancyboxOptions ? JSON.parse(instance.current.opts.$orig[0].dataset.hsFancyboxOptions) : {},
							transitionEffectCustom = dataSettings.transitionEffectCustom ? dataSettings.transitionEffectCustom : false,
							overlayBG = dataSettings.overlayBg,
							overlayBlurBG = dataSettings.overlayBlurBg;

						if (transitionEffectCustom) {
							$fancySlide.css('visibility', 'hidden');
						}

						if (overlayBG) {
							$fancyOverlay.css({
								backgroundColor: overlayBG
							});
						}

						if (overlayBlurBG) {
							$('body').addClass('blur-30');
						}
					},
					afterShow: function (instance) {
						var $fancySlide = $(instance.current.$slide),
							$fancyPrevSlide = $(instance.group[instance.prevPos].$slide) ? $(instance.group[instance.prevPos].$slide) : null,
							dataSettings = instance.current.opts.$orig[0].dataset.hsFancyboxOptions ? JSON.parse(instance.current.opts.$orig[0].dataset.hsFancyboxOptions) : {},
							transitionEffectCustom = dataSettings.transitionEffectCustom ? dataSettings.transitionEffectCustom : false;

						if (transitionEffectCustom) {
							$fancySlide.css('visibility', 'visible');

							if (!$fancySlide.hasClass('animated')) {
								$fancySlide.addClass('animated');
							}

							if ($fancyPrevSlide && !$fancyPrevSlide.hasClass('animated')) {
								$fancyPrevSlide.addClass('animated');
							}

							if (!$('body').hasClass('fancybox-opened')) {
								$fancySlide.addClass(transitionEffectCustom.onShow);

								$fancySlide.on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function (e) {
									$fancySlide.removeClass(transitionEffectCustom.onShow);

									$('body').addClass('fancybox-opened');
								});
							} else {
								$fancySlide.addClass(transitionEffectCustom.onShow);

								$fancySlide.on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function (e) {
									$fancySlide.removeClass(transitionEffectCustom.onShow);
								});

								if($fancyPrevSlide) {
									$fancyPrevSlide.addClass(transitionEffectCustom.onHide);

									$fancyPrevSlide.on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function (e) {
										$fancyPrevSlide.removeClass(transitionEffectCustom.onHide);
									});
								}
							}
						}
					},
					beforeClose: function (instance) {
						var $fancySlide = $(instance.current.$slide),
							dataSettings = instance.current.opts.$orig[0].dataset.hsFancyboxOptions ? JSON.parse(instance.current.opts.$orig[0].dataset.hsFancyboxOptions) : {},
							transitionEffectCustom = dataSettings.transitionEffectCustom ? dataSettings.transitionEffectCustom : false,
							overlayBlurBG = dataSettings.overlayBlurBg;

						if (transitionEffectCustom) {
							$fancySlide.removeClass(transitionEffectCustom.onShow).addClass(transitionEffectCustom.onHide);

							$('body').removeClass('fancybox-opened');
						}

						if (overlayBlurBG) {
							$('body').removeClass('blur-30');
						}
					}
				};
			settings = $.extend(true, defaults, settings, dataSettings, options);

			/* Start : Init */

			var newFancybox = el.fancybox(settings);

			/* End : Init */

			return newFancybox;
		}

	};

})(jQuery);
