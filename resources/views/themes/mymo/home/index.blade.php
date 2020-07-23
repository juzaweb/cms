@extends('themes.mymo.layout')

@section('content')
    <div class="row container" id="wrapper">
        <div class="halim-panel-filter">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-8 hidden-xs">
                        {{ get_config('title') }}
                    </div>
                    <div class="col-xs-4 text-right">
                        <a href="javascript:;" id="expand-ajax-filter">@lang('app.filter') <i id="ajax-filter-icon" class="hl-angle-down"></i></a>
                    </div>
                    <div id="alphabet-filter" style="float: right;display: inline-block;margin-right: 25px;"></div>
                </div>
            </div>
            <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                <div class="ajax"></div>
            </div>
        </div><!-- end panel-default -->
        @php
            $home = theme_setting('home_page');
        @endphp

        @if(@$home->slider_movies->status == 1)
            @php
            $genre = genre_setting(@$home->slider_movies->genre);
            @endphp
        <div class="col-xs-12 carausel-sliderWidget">
            <div id="halim-carousel-widget-3xx" class="wrap-slider">
                <div class="section-bar clearfix">
                    <h3 class="section-title"><span>{{ @$genre->title }}</span></h3>
                </div>
                <div id="halim-carousel-widget-3" class="owl-carousel owl-theme">
                    @if(!$genre->items->isEmpty())
                        @foreach($genre->items as $item)
                        <article class="thumb grid-item post-{{ $item->id }}">
                            @include('themes.mymo.data.item')
                        </article>
                        @endforeach
                    @endif
                </div>
                <script>
                    jQuery(document).ready(function ($) {
                        var owl = $('#halim-carousel-widget-3');
                        owl.owlCarousel({
                            rtl: false,
                            loop: true,
                            margin: 4,
                            autoplay: true,
                            autoplayTimeout: 4000,
                            autoplayHoverPause: true,
                            nav: false,
                            navText: ['<i class="hl-down-open rotate-left"></i>', '<i class="hl-down-open rotate-right"></i>'],
                            responsiveClass: true,
                            responsive: {0: {items: 2}, 480: {items: 3}, 600: {items: 4}, 1000: {items: 6}}
                        })
                    });
                </script>
            </div>

            @if(@$home->genre1->status == 1)
                @php
                    $genre = genre_setting(@$home->genre1->genre);
                @endphp

            <section id="halim-advanced-widget-2">
                <h4 class="section-heading">
                    <a href="#" title="{{ $genre->title }}">
                        <span class="h-text">{{ $genre->title }}</span>
                    </a>
                    <ul class="heading-nav pull-right hidden-xs">
                        <li class="section-btn halim_ajax_get_post" data-catid="752" data-showpost="12" data-widgetid="halim-advanced-widget-2" data-layout="6col">
                            <span data-text="Hài Hước"></span>
                        </li>
                    </ul>
                </h4>

                <div id="halim-advanced-widget-2-ajax-box" class="halim_box">
                    @if(!$genre->items->isEmpty())
                        @foreach($genre->items as $item)
                        <article class="col-md-2 col-sm-4 col-xs-6 thumb grid-item post-{{ $item->id }}">
                            @include('themes.mymo.data.item')
                        </article>
                        @endforeach
                    @endif

                    <a href="#" class="see-more">View all post »</a>
                </div>
            </section>
            <div class="clearfix"></div>
            @endif

            @if(@$home->genre2->status == 1)
                @php
                    $genre = genre_setting(@$home->genre2->genre);
                @endphp
            <section id="halim-advanced-widget-4">
                <h4 class="section-heading">
                    <a href="#" title="{{ @$genre->title }}">
                        <span class="h-text">{{ @$genre->title }}</span>
                    </a>

                    <ul class="heading-nav pull-right hidden-xs">

                        <li class="section-btn halim_ajax_get_post" data-catid="766" data-showpost="12"
                            data-widgetid="halim-advanced-widget-4" data-layout="6col"><span data-text="Cổ Trang"></span>
                        </li>

                    </ul>
                </h4>
                <div id="halim-advanced-widget-4-ajax-box" class="halim_box">
                    @if(!$genre->items->isEmpty())
                        @foreach($genre->items as $item)
                            <article class="col-md-2 col-sm-4 col-xs-6 thumb grid-item post-{{ $item->id }}">
                                @include('themes.mymo.data.item')
                            </article>
                        @endforeach
                    @endif

                    <a href="#" class="see-more">View all post »</a>
                </div>
            </section>
            <div class="clearfix"></div>
            @endif

            @if(@$home->genre2->status == 1)
                @php
                    $genre = genre_setting(@$home->genre2->genre);
                @endphp
            <section id="halim-advanced-widget-3">
                <h4 class="section-heading">
                    <a href="#" title="{{ @$genre->title }}">
                        <span class="h-text">{{ @$genre->title }}</span>
                    </a>
                    <ul class="heading-nav pull-right hidden-xs">

                        <li class="section-btn halim_ajax_get_post" data-catid="768" data-showpost="12"
                            data-widgetid="halim-advanced-widget-3" data-layout="6col"><span
                                    data-text="Khoa Học"></span>
                        </li>

                    </ul>
                </h4>
                <div id="halim-advanced-widget-3-ajax-box" class="halim_box">

                    @if(!$genre->items->isEmpty())
                        @foreach($genre->items as $item)
                            <article class="col-md-2 col-sm-4 col-xs-6 thumb grid-item post-{{ $item->id }}">
                                @include('themes.mymo.data.item')
                            </article>
                        @endforeach
                    @endif

                    <div class="clearfix"></div>
                    <a href="#" class="see-more">View all post »</a>
                </div>
            </section>
            <div class="clearfix"></div>
            @endif
        </div>
        @endif
    </div>
@endsection
