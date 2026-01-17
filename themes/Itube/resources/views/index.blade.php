@extends('itube::layouts.main')

@section('title', __('itube::translation.home'))

@section('head')

@endsection

@section('content')
    <div class="container mt-5 mb-5">
        @if($ad = ads_position('home_banner'))
            <div class="row mb-4">
                <div class="col-12 text-center">
                    {!! $ad !!}
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-auto d-none d-xl-block">
                @include('itube::components.sidebar', ['active' => 'home'])
            </div>
            <div class="col-lg">
                <div class="max-w-md-1160 ml-auto my-6 mb-lg-8 pb-lg-1">
                    @php
                        $blocks = page_blocks(theme_setting('home_page'));
                    @endphp

                    @foreach($blocks->get('content') ?? [] as $block)
                        @php
                            $pageBlock = PageBlock::get($block->block);
                        @endphp

                        @if($pageBlock === null)
                            @continue
                        @endif

                        {{ $pageBlock->view($block) }}

                    @endforeach

                    <section>
                        <div class="home-section mb-3 pb-1">
                            <header class="d-md-flex align-items-center justify-content-between mb-3 mb-lg-1 pb-2 w-100 border-bottom">
                                <h6 class="d-block position-relative font-size-24 font-weight-medium overflow-md-hidden m-0 text-gray-700">@lang('Videos')</h6>
                            </header>
                        </div>
                        <div class="row mx-n2 mb-md-4 pb-md-1 home-videos-container" 
                             data-exclude-ids="{{ $trendingVideos->pluck('id')->implode(',') }}"
                             data-load-more-url="{{ route('home.load_more') }}">
                            @foreach($videos as $video)
                                @component('itube::components.video-item', ['video' => $video])
                                @endcomponent
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
