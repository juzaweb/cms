@extends('itech::layouts.main')

@section('title', setting('title'))

@section('content')
    @php
        $page = \Juzaweb\Modules\Core\Models\Pages\Page::whereFrontend()
            ->with(['blocks' => fn ($q) => $q->withTranslation()->cacheFor(3600)])
            ->where('id', theme_setting('home_page'))
            ->first();
        $blocks = $page?->blocks->groupBy('container') ?? collect();
    @endphp

            <!-- Breaking Wrapper -->
    <div id="break-wrapper-outer">
        @foreach($blocks->get('breaking') ?? [] as $block)
            @php
                $pageBlock = PageBlock::get($block->block);
            @endphp

            @if($pageBlock === null)
                @continue
            @endif

            {{ $pageBlock->view($block) }}

        @endforeach
    </div>
    <div class='clearfix'></div>

    @if(function_exists('ads_position') && $ad = ads_position('home_top'))
        <div class='row ad-wrapper'>
            <div class='home-ad-top section' id='home-ad-top1' name='Home Ads Top'>
                {!! $ad !!}
            </div>
        </div>
        <div class='clearfix'></div>
    @endif

    <div class='row' id='hot-wrapper'>
        @foreach($blocks->get('hot-posts') ?? [] as $block)
            @php
                $pageBlock = PageBlock::get($block->block);
            @endphp

            @if($pageBlock === null)
                @continue
            @endif

            {{ $pageBlock->view($block) }}

        @endforeach
    </div>
    <div class='clearfix'></div>

    <div class='featured-grid1' id='grid-wrapper'>
        @foreach($blocks->get('featured-posts') ?? [] as $block)
            @php
                $pageBlock = PageBlock::get($block->block);
            @endphp

            @if($pageBlock === null)
                @continue
            @endif

            {{ $pageBlock->view($block) }}

        @endforeach
    </div>
    <div class='clearfix'></div>

    <!-- Content Wrapper -->
    <div class='row' id='content-wrapper'>
        <div class='container'>
            <!-- Main Wrapper -->
            <div id='main-wrapper'>
                <div class='main section' id='main' name='Main Posts'>
                    <div class='widget Blog' data-version='2' id='Blog1'>
                        <div class='home-posts-headline title-wrap Label'>
                            <h3 class='title'>{{ __('itech::translation.recent_posts') }}</h3>
                            <a class='view-all'
                               href='{{ home_url('search') }}'>{{ __('itech::translation.show_more') }}</a>
                        </div>

                        <div class='clearfix'></div>
                        <div class='blog-posts hfeed container index-post-wrap'>
                            <div class='grid-posts'>
                                @foreach ($recentPosts as $post)
                                    @component('itech::components.post-item', ['post' => $post])

                                    @endcomponent
                                @endforeach
                            </div>
                        </div>

                        <div class='blog-pager container' id='blog-pager'>
                            <a class='blog-pager-older-link load-more'
                               data-load='{{ $recentPosts->hasMorePages() ? route('home.load-more', ['page' => 2]) : '' }}'
                               href='javascript:void(0);' id='load-more-link'>
                                {{ __('itech::translation.load_more') }}
                            </a>
                            <span class='loading'><span class='loader'></span></span>
                            <span class='no-more load-more'>{{ __('itech::translation.that_is_all') }}</span>
                        </div>
                        <script type='text/javascript'>
                            var messages = {
                                showMore: "{{ __('itech::translation.show_more') }}",
                            }
                        </script>
                    </div>
                </div>
            </div>
            <!-- Sidebar Wrapper -->

            @include('itech::components.sidebar')

            <div class='clearfix'></div>
        </div>
    </div>
    <div class='clearfix'></div>
@endsection
