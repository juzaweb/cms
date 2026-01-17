/*
* Cubeportfolio wrapper
* @version: 2.0.0 (Mon, 25 Nov 2019)
* @requires: jQuery v3.0 or later, Cube Portfolio v4.4.0
* @author: HtmlStream
* @event-namespace: .HSCore.components.HSCubeportfolio
* @license: Htmlstream Libraries (https://htmlstream.com/licenses)
* Copyright 2020 Htmlstream
*/

;(function ($) {
	'use strict';

	$.HSCore.components.HSCubeportfolio = {
		defaults: {
			defaultFilter: '*',
			displayTypeSpeed: 100,
			sortToPreventGaps: true,
			lightboxGallery: true,
			singlePageInlineInFocus: true,
			singlePageDeeplinking: true,
			singlePageStickyNavigation: true,
			gridAdjustment: 'responsive',
			displayType: 'sequentially',
			singlePageInlinePosition: 'below',
			lightboxTitleSrc: 'data-title',
			lightboxDelegate: '.cbp-lightbox',
			singlePageInlineDelegate: '.cbp-singlePageInline',
			singlePageDelegate: '.cbp-singlePage',
			lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',
			appendItems: '<div class="logo cbp-item">my awesome content to append to plugin</div> <div class="logo cbp-item">my second awesome content to append to plugin</div>',
			singlePageCounter: '<div class="cbp-popup-singlePage-counter">{{current}} of {{total}}</div>',
			mediaQueries: [{
				width: 1500,
				cols: 3
			}, {
				width: 1100,
				cols: 3
			}, {
				width: 800,
				cols: 3
			}, {
				width: 480,
				cols: 2,
				options: {
					caption: '',
					gapHorizontal: 10,
					gapVertical: 10
				}
			}],
			caption: 'overlayBottomAlong'
		},

		init: function (el, options) {
			if (!el.length) return;

			var context = this,
				$el = $(el),
				defaults = Object.assign({}, context.defaults),
				dataSettings = $el.attr('data-hs-cbp-options') ? JSON.parse($el.attr('data-hs-cbp-options')) : {},
				settings = {
					singlePageInlineCallback: function (url) {
						var t = this;

						$.ajax({
							url: url,
							type: 'GET',
							dataType: 'html',
							timeout: 30000
						}).done(function (result) {
							t.updateSinglePageInline(result);
						}).fail(function () {
							t.updateSinglePageInline('AJAX Error! Please refresh the page!');
						});
					},
					singlePageCallback: function (url) {
						var t = this;

						$.ajax({
							url: url,
							type: 'GET',
							dataType: 'html',
							timeout: 10000
						}).done(function (result) {
							t.updateSinglePage(result);
						}).fail(function () {
							t.updateSinglePage('AJAX Error! Please refresh the page!');
						});
					}
				};
			settings = $.extend(defaults, settings, dataSettings, options);

			/* Start : Init */

			var newCubeportfolio = el.cubeportfolio(settings);

			/* End : Init */

			return newCubeportfolio;
		}

	};

})(jQuery);
