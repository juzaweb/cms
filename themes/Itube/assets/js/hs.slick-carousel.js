/*
* Slick Carousel wrapper
* @version: 2.0.0 (Mon, 25 Nov 2019)
* @requires: jQuery v3.0 or later, Slick v1.8.0
* @author: HtmlStream
* @event-namespace: .HSCore.components.HSSlickCarousel
* @license: Htmlstream Libraries (https://htmlstream.com/licenses)
* Copyright 2020 Htmlstream
*/

;(function ($) {
	'use strict';

	$.HSCore.components.HSSlickCarousel = {
		defaults: {
			infinite: false,
			pauseOnHover: false,
			centerPadding: 0,
			lazyLoad: false,
			prevArrow: null,
			nextArrow: null,

			autoplaySpeed: 3000,
			speed: 300,
			initialDelay: 600,

			isThumbs: false,
			isThumbsProgressCircle: false,
			thumbsProgressContainer: null,
			thumbsProgressOptions: {
				color: '#000',
				width: 4
			},

			animationIn: null,
			animationOut: null,

			dotsWithIcon: null,
			dotsFromTitles: null,
			dotsAsProgressLine: false,
			hasDotsHelper: false,

			counterSelector: null,
			counterDivider: '/',
			counterClassMap: {
				current: 'slick-counter-current',
				total: 'slick-counter-total',
				divider: 'slick-counter-divider'
			}
		},

		init: function (el, options) {
			if (!el.length) return;

			var context = this,
				defaults = Object.assign({}, context.defaults),
				dataSettings = el.attr('data-hs-slick-carousel-options') ? JSON.parse(el.attr('data-hs-slick-carousel-options')) : {},
				settings = {
					id: el.attr('id')
				};
			settings = $.extend(defaults, settings, dataSettings);
			settings = $.extend(settings, {
				customPaging: function (slider, i) {
					var title = $(slider.$slides[i]).data('hs-slick-carousel-slide-title');

					if (title && settings.dotsWithIcon) {
						return '<span>' + title + '</span>' + settings.dotsWithIcon;
					} else if (settings.dotsWithIcon) {
						return '<span></span>' + settings.dotsWithIcon;
					} else if (title && settings.dotsFromTitles) {
						return '<span>' + title + '</span>';
					} else if (title && !settings.dotsFromTitles) {
						return '<span></span>' + '<strong class="dot-title">' + title + '</strong>';
					} else {
						return '<span></span>';
					}
				}
			}, options);

			/* Start : object preparation */

			if (el.find('[data-slide-type]').length) {
				context.videoSupport(el);
			}

			el.on('init', function (event, slick) {
				context.transformOff(el, settings, event, slick);
			});

			el.on('init', function (event, slick) {
				context.setCustomAnimation(event, slick);
			});

			if (settings.animationIn && settings.animationOut) {
				el.on('init', function (event, slick) {
					context.setSingleClass(event, slick);
				});
			}

			if (settings.dotsAsProgressLine) {
				el.on('init', function () {
					context.setCustomLineDots(el, settings);
				});
			}

			if (settings.hasDotsHelper) {
				el.on('init', function (el, event, slick) {
					context.setCustomDots(el, event, slick);
				});
			}

			if (settings.isThumbs) {
				if (settings.isThumbsProgressCircle) {
					el.on('init', function (event, slick) {
						context.setCustomProgressCircle(el, settings, event, slick);
					});
				}

				$('#' + settings.id).on('click', '.slick-slide', function (e) {
					e.stopPropagation();

					context.goToTargetSlide($(this), settings);
				});
			}

			el.on('init', function (event, slick) {
				context.setCustomCurrentClass(el, event, slick);
			});

			el.on('init', function (event, slick) {
				context.setInitialCustomAnimation(event, slick);
			});

			if (settings.counterSelector) {
				el.on('init', function (event, slick) {
					context.setCounter(settings, event, slick);
				});
			}

			/* End : object preparation */

			var newSlick = el.slick(settings);

			/* Start : custom functionality implementation */

			if ($(settings.asNavFor)[0] && $(settings.asNavFor)[0].dataset.hsSlickCarouselOptions ? JSON.parse($(settings.asNavFor)[0].dataset.hsSlickCarouselOptions).isThumbsProgress : false) {
				context.setInitialDelay(el, settings);
			}

			el.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
				context.setCustomClasses(el, event, slick, currentSlide, nextSlide);
			});

			if (settings.counterSelector) {
				el.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
					context.counting(settings, event, slick, currentSlide, nextSlide);
				});
			}

			el.on('afterChange', function (event, slick) {
				context.setCustomAnimation(event, slick);
			});

			if (settings.animationIn && settings.animationOut) {
				el.on('afterChange', function (event, slick, currentSlide, nextSlide) {
					context.animationIn(settings, event, slick, currentSlide, nextSlide);
				});

				el.on('beforeChange', function (event, slick, currentSlide) {
					context.animationOut(settings, event, slick, currentSlide);
				});

				el.on('setPosition', function (event, slick) {
					context.setPosition(settings, event, slick);
				});
			}

			/* End : custom functionality implementation */

			return newSlick;
		},

		// ----- Start : Preparation -----

		transformOff: function (el, params, event, slick) {
			var settings = params;

			$(slick.$slides).css('height', 'auto');

			if (settings.isThumbs && settings.slidesToShow >= $(slick.$slides).length) {
				el.addClass('slick-transform-off');
			}
		},

		setCustomAnimation: function (event, slick) {
			var slide = $(slick.$slides)[slick.currentSlide],
				animatedElements = $(slide).find('[data-hs-slick-carousel-animation]');

			$(animatedElements).each(function () {
				var animationIn = $(this).data('hs-slick-carousel-animation'),
					animationDelay = $(this).data('hs-slick-carousel-animation-delay'),
					animationDuration = $(this).data('hs-slick-carousel-animation-duration');

				$(this).css({
					'animation-delay': animationDelay + 'ms',
					'animation-duration': animationDuration + 'ms'
				});

				$(this).addClass('animated ' + animationIn).css({
					opacity: 1
				});
			});
		},

		setInitialCustomAnimation: function (event, slick) {
			var slide = $(slick.$slides)[0],
				animatedElements = $(slide).find('[data-hs-slick-carousel-animation]');

			$(animatedElements).each(function () {
				var animationIn = $(this).data('hs-slick-carousel-animation');

				$(this).addClass('animated ' + animationIn).css('opacity', 1);
			});
		},

		setSingleClass: function (event, slick) {
			$(slick.$slides).addClass('single-slide');
		},

		setCustomDots: function (el) {
			var $dots = el.find('.js-dots');

			if (!$dots.length) return;

			$dots.append('<span class="dots-helper"></span>');
		},

		setCustomLineDots: function (el, params) {
			var $dots = el.find('[class="' + params.dotsClass + '"]'),
				$dotsItems = $dots.find('li');

			if (!$dots.length) return;

			setTimeout(function () {
				el.addClass('slick-line-dots-ready');
			});

			$dotsItems.each(function () {
				$(this).append('<span class="dot-line"><span class="dot-line-helper" style="transition-duration: ' + (params.autoplaySpeed + params.speed) + 'ms;"></span></span>');
			});
		},

		setCustomProgressCircle: function (el, params, event, slick) {
			var settings = params,
				thumbProgressElLength = 0,
				style = '<style type="text/css"></style>',
				$style = $(style);

			$(slick.$slides).each(function (i) {
				var $el = $('<span class="slick-thumb-progress"><svg version="1.1" viewBox="0 0 160 160"><path class="slick-thumb-progress__path" d="M 79.98452083651917 4.000001576345426 A 76 76 0 1 1 79.89443752470656 4.0000733121155605 Z"></path></svg></span>'),
					$path = $el.find('svg path');
				thumbProgressElLength = parseInt($path[0].getTotalLength());

				$(slick.$slides[i]).children(settings.thumbsProgressContainer).append($el);
			});

			$style.text('.slick-thumb-progress .slick-thumb-progress__path {' +
				'opacity: 0;' +
				'fill: transparent;' +
				'stroke: '+ settings.thumbsProgressOptions.color +';' +
			  'stroke-width: ' + settings.thumbsProgressOptions.width + ';' +
				'stroke-dashoffset: ' + thumbProgressElLength + ';' +
				'stroke-dashoffset: 0px;' +
				'}' +
				'.slick-current .slick-thumb-progress .slick-thumb-progress__path {' +
				'opacity: 1;' +
				'-webkit-animation: ' + (slick.options.autoplaySpeed + slick.options.speed) + 'ms linear 0ms forwards dash;' +
				'-moz-animation: ' + (slick.options.autoplaySpeed + slick.options.speed) + 'ms linear 0ms forwards dash;' +
				'-o-animation: ' + (slick.options.autoplaySpeed + slick.options.speed) + 'ms linear 0ms forwards dash;' +
				'animation: ' + (slick.options.autoplaySpeed + slick.options.speed) + 'ms linear 0ms forwards dash;' +
				'}' +
				'@-webkit-keyframes dash {' +
				'from {stroke-dasharray: 0 ' + thumbProgressElLength + ';} ' +
				'to {stroke-dasharray: ' + thumbProgressElLength + ' ' + thumbProgressElLength + ';}' +
				'}' +
				'@-moz-keyframes dash {' +
				'from {stroke-dasharray: 0 ' + thumbProgressElLength + ';} ' +
				'to {stroke-dasharray: ' + thumbProgressElLength + ' ' + thumbProgressElLength + ';}' +
				'}' +
				'@-moz-keyframes dash {' +
				'from {stroke-dasharray: 0 ' + thumbProgressElLength + ';} ' +
				'to {stroke-dasharray: ' + thumbProgressElLength + ' ' + thumbProgressElLength + ';}' +
				'}' +
				'@keyframes dash {' +
				'from {stroke-dasharray: 0 ' + thumbProgressElLength + ';} ' +
				'to {stroke-dasharray: ' + thumbProgressElLength + ' ' + thumbProgressElLength + ';}' +
				'}'
			);

			$style.appendTo(el);
		},

		goToTargetSlide: function (el, params) {
			//Variables
			var settings = params,
				i = el.data('slick-index');

			if ($('#' + settings.id).slick('slickCurrentSlide') !== i) {
				$('#' + settings.id).slick('slickGoTo', i);
			}
		},

		setCustomCurrentClass: function (el) {
			var $dots = el.find('.js-dots');

			if (!$dots.length) return;

			$($dots[0].children[0]).addClass('slick-current');
		},

		setCounter: function (params, event, slick) {
			var settings = params;

			$(settings.counterSelector).html('<span class="' + settings.counterClassMap.current + '">1</span><span class="' + settings.counterClassMap.divider + '">' + settings.counterDivider + '</span><span class="' + settings.counterClassMap.total + '">' + slick.slideCount + '</span>');
		},

		// ----- End : Preparation -----

		// ----- Start : Custom functionality -----

		setInitialDelay: function (el, params) {
			var settings = params;

			el.slick('slickPause');

			setTimeout(function () {
				el.slick('slickPlay');
			}, settings.initialDelay);
		},

		setCustomClasses: function (el, event, slider, currentSlide, nextSlide) {
			var nxtSlide = $(slider.$slides)[nextSlide],
				slide = $(slider.$slides)[currentSlide],
				$dots = el.find('.js-dots'),
				animatedElements = $(nxtSlide).find('[data-hs-slick-carousel-animation]'),
				otherElements = $(slide).find('[data-hs-slick-carousel-animation]');

			$(otherElements).each(function () {
				var animationIn = $(this).data('hs-slick-carousel-animation');

				$(this).removeClass('animated ' + animationIn);
			});

			$(animatedElements).each(function () {
				$(this).css({
					opacity: 0
				});
			});

			if (!$dots.length) return;

			if (currentSlide > nextSlide) {
				$($dots[0].children).removeClass('slick-active-right');

				$($dots[0].children[nextSlide]).addClass('slick-active-right');
			} else {
				$($dots[0].children).removeClass('slick-active-right');
			}

			$($dots[0].children).removeClass('slick-current');

			setTimeout(function () {
				$($dots[0].children[nextSlide]).addClass('slick-current');
			}, .25);
		},

		animationIn: function (params, event, slick, currentSlide, nextSlide) {
			var settings = params;

			$(slick.$slides).removeClass('animated set-position ' + settings.animationIn + ' ' + settings.animationOut);
		},

		animationOut: function (params, event, slick, currentSlide) {
			var settings = params;

			$(slick.$slides[currentSlide]).addClass('animated ' + settings.animationOut);
		},

		setPosition: function (params, event, slick) {
			var settings = params;

			$(slick.$slides[slick.currentSlide]).addClass('animated set-position ' + settings.animationIn);
		},

		counting: function (params, event, slick, currentSlide, nextSlide) {
			var settings = params,
				i = (nextSlide ? nextSlide : 0) + 1;

			$(settings.counterSelector).html('<span class="' + settings.counterClassMap.current + '">' + i + '</span><span class="' + settings.counterClassMap.divider + '">' + settings.counterDivider + '</span><span class="' + settings.counterClassMap.total + '">' + slick.slideCount + '</span>');
		},

		videoSupport: function (carousel) {
			if (!carousel.length) return;

			carousel.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
				var slideType = $(slick.$slides[currentSlide]).data('slide-type'),
					player = $(slick.$slides[currentSlide]).find('iframe').get(0),
					command;

				if (slideType === 'vimeo') {
					command = {
						"method": "pause",
						"value": "true"
					}
				} else if (slideType === 'youtube') {
					command = {
						"event": "command",
						"func": "pauseVideo"
					}
				} else {
					return false;
				}

				if (player !== undefined) {
					player.contentWindow.postMessage(JSON.stringify(command), '*');
				}
			});
		},

		initTextAnimation: function (carousel, textAnimationSelector) {
			if (!window.TextFx || !window.anime || !carousel.length) return;

			var $text = carousel.find(textAnimationSelector);

			if (!$text.length) return;

			$text.each(function (i, el) {
				var $this = $(el);

				if (!$this.data('TextFx')) {
					$this.data('TextFx', new TextFx($this.get(0)));
				}
			});

			carousel.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
				var targets = slick.$slider
					.find('.slick-track')
					.children();

				var currentTarget = targets.eq(currentSlide),
					nextTarget = targets.eq(nextSlide);

				currentTarget = currentTarget.find(textAnimationSelector);
				nextTarget = nextTarget.find(textAnimationSelector);

				if (currentTarget.length) {
					currentTarget.data('TextFx').hide(currentTarget.data('effect') ? currentTarget.data('effect') : 'fx1');
				}

				if (nextTarget.length) {
					nextTarget.data('TextFx').show(nextTarget.data('effect') ? nextTarget.data('effect') : 'fx1');
				}
			});
		}

		// ----- End : Custom functionality -----
	};

})(jQuery);
