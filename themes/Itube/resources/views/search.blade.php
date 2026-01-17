@extends('itube::layouts.main')

@section('title', __('itube::translation.search_results') . (request('q') ? ' - ' . request('q') : ''))

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-lg-auto d-none d-xl-block">
                @include('itube::components.sidebar', ['active' => 'search'])
            </div>
            <div class="col-lg">
                <div class="max-w-md-1160 ml-auto my-6 mb-lg-8 pb-lg-1">
                    <!-- Search Header -->
                    <div class="mb-4">
                        <h4 class="font-weight-medium text-gray-700">
                            @if(request('q'))
                                {{ __('itube::translation.search_results_for') }}: "{{ request('q') }}"
                            @else
                                {{ __('itube::translation.search_videos') }}
                            @endif
                        </h4>
                        @if(isset($videos) && $videos->total() > 0)
                            <p class="text-muted">{{ $videos->total() }} {{ __('itube::translation.results_found') }}</p>
                        @endif
                    </div>

                    @if(isset($videos) && $videos->count() > 0)
                        <!-- Search Results -->
                        <section>
                            <div class="row mx-n2 mb-md-4 pb-md-1 search-videos-container"
                                 data-load-more-url="{{ route('search.load_more') }}"
                                 data-search-query="{{ request('q') }}"
                                 data-has-more="{{ $videos->hasMorePages() ? '1' : '0' }}">
                                @foreach($videos as $video)
                                    @component('itube::components.video-item', ['video' => $video])
                                    @endcomponent
                                @endforeach
                            </div>
                        </section>
                    @else
                        <!-- No Results -->
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-search fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-gray-700 mb-3">
                                @if(request('q'))
                                    {{ __('itube::translation.no_videos_found') }}
                                @else
                                    {{ __('itube::translation.enter_a_search_term_to_find_videos') }}
                                @endif
                            </h5>
                            @if(request('q'))
                                <p class="text-muted">
                                    {{ __('itube::translation.try_different_keywords_or_check_your_spelling') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
(function($) {
    'use strict';

    let isLoading = false;
    let hasMoreVideos = true;
    let currentPage = 2; // Start from page 2 since page 1 is already loaded
    let searchQuery = '';
    let loadMoreUrl = '';

    function loadMoreVideos() {
        if (isLoading || !hasMoreVideos) {
            return;
        }

        isLoading = true;

        // Show loading indicator
        const $loadingIndicator = $('<div class="text-center py-4" id="search-loading-indicator"><div class="spinner-border text-primary" role="status"><span class="sr-only">{{ __('itube::translation.loading') }}</span></div></div>');
        $('.search-videos-container').append($loadingIndicator);

        $.ajax({
            url: loadMoreUrl,
            type: 'GET',
            data: {
                page: currentPage,
                q: searchQuery
            },
            success: function(response) {
                if (response.success && response.html) {
                    // Remove loading indicator
                    $('#search-loading-indicator').remove();

                    // Append new videos to the container
                    $('.search-videos-container').append(response.html);

                    // Update state
                    hasMoreVideos = response.hasMore;
                    currentPage = response.nextPage;
                    isLoading = false;

                    // Reinitialize lazy loading for new images if needed
                    if (typeof lazyload !== 'undefined') {
                        lazyload();
                    }
                } else {
                    $('#search-loading-indicator').remove();
                    hasMoreVideos = false;
                    isLoading = false;
                }
            },
            error: function() {
                $('#search-loading-indicator').remove();
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
        const $container = $('.search-videos-container');

        if ($container.length > 0) {
            // Get configuration from data attributes
            searchQuery = $container.data('search-query') || '';
            loadMoreUrl = $container.data('load-more-url') || '/search/load-more';
            hasMoreVideos = $container.data('has-more') == '1';

            // Only attach scroll event if there are more videos to load
            if (hasMoreVideos) {
                $(window).on('scroll', $.throttle(300, checkScroll));
            }
        }
    });

    // Throttle function to limit scroll event firing
    $.throttle = $.throttle || function(delay, fn) {
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
</script>
@endsection