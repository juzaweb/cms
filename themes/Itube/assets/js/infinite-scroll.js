(function($) {
    'use strict';

    let isLoading = false;
    let hasMoreVideos = true;
    let currentPage = 2; // Start from page 2 since page 1 is already loaded
    let excludeIds = '';
    let loadMoreUrl = '';

    function loadMoreVideos() {
        if (isLoading || !hasMoreVideos) {
            return;
        }

        isLoading = true;

        // Show loading indicator
        const $loadingIndicator = $('<div class="text-center py-4" id="loading-indicator"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');
        $('.home-videos-container').append($loadingIndicator);

        $.ajax({
            url: loadMoreUrl,
            type: 'GET',
            data: {
                page: currentPage,
                excludeIds: excludeIds
            },
            success: function(response) {
                if (response.success && response.html) {
                    // Remove loading indicator
                    $('#loading-indicator').remove();

                    // Append new videos to the container
                    $('.home-videos-container').append(response.html);

                    // Update state
                    hasMoreVideos = response.hasMore;
                    currentPage = response.nextPage;
                    isLoading = false;

                    // Reinitialize lazy loading for new images if needed
                    lazyload();
                } else {
                    $('#loading-indicator').remove();
                    hasMoreVideos = false;
                    isLoading = false;
                }
            },
            error: function() {
                $('#loading-indicator').remove();
                isLoading = false;
            }
        });
    }

    function checkScroll() {
        const scrollTop = $(window).scrollTop();
        const windowHeight = $(window).height();
        const documentHeight = $(document).height();

        // Load more when user is 500px from the bottom
        if (scrollTop + windowHeight >= documentHeight - 500) {
            loadMoreVideos();
        }
    }

    // Initialize infinite scroll on document ready
    $(document).ready(function() {
        const $container = $('.home-videos-container');

        if ($container.length > 0) {
            // Get configuration from data attributes
            excludeIds = $container.data('exclude-ids') || '';
            loadMoreUrl = $container.data('load-more-url') || '/load-more-videos';

            $(window).on('scroll', $.throttle(300, checkScroll));
        }
    });

    // Throttle function to limit scroll event firing
    $.throttle = function(delay, fn) {
        let last, deferTimer;
        return function(...args) {
            let context = this, now = Date.now();
            if (last && now < last + delay) {
                clearTimeout(deferTimer);
                deferTimer = setTimeout(function() {
                    last = now;
                    fn.apply(context, args);
                }, delay);
            } else {
                last = now;
                fn.apply(context, args);
            }
        };
    };

})(jQuery);
