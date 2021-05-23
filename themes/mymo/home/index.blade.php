@extends('themes.mymo.layout')

@section('content')
    <div class="row container" id="wrapper">
        <div class="mymo-panel-filter">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-8 hidden-xs">
                        {{ get_config('title') }}
                    </div>
                    <div class="col-xs-4 text-right">
                        <a href="javascript:;" id="expand-ajax-filter">@lang('app.filter_movies') <i id="ajax-filter-icon" class="hl-angle-down"></i></a>
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

        @php
            $ads = get_ads('home_header');
        @endphp
        @if($ads)
            <div class="col-xs-12">
                <!-- Ads -->
                {!! $ads !!}
            </div>
        @endif


        <div class="col-xs-12 carausel-sliderWidget">
            @if(@$home->slider_movies->status == 1)
                @php
                    $genre = genre_setting(@$home->slider_movies->genre);
                @endphp
            <div id="mymo-carousel-widget-3xx" class="wrap-slider">
                <div class="section-bar clearfix">
                    <h3 class="section-title"><span>{{ @$genre->title }}</span></h3>
                </div>
                <div id="mymo-carousel-widget-3" class="owl-carousel owl-theme">
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
                        var owl = $('#mymo-carousel-widget-3');
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
            @endif

            @for($i = 1; $i <= 3; $i++)
            @if(@$home->{'genre' . $i}->status == 1)
                @php
                    $genre = genre_setting(@$home->{'genre' . $i}->genre);
                @endphp

            <section id="mymo-advanced-widget-{{ $i }}">
                <h4 class="section-heading">
                    <a href="{{ @$genre->url }}" title="{{ @$genre->title }}">
                        <span class="h-text">{{ @$genre->title }}</span>
                    </a>

                    @if(@$home->{'genre' . $i}->child_genres)
                        @php
                        $child_genres = child_genres_setting($home->{'genre' . $i}->child_genres);
                        @endphp
                    <ul class="heading-nav pull-right hidden-xs">
                        @foreach($child_genres as $child)
                        <li class="section-btn mymo_ajax_get_post" data-catid="{{ $child->id }}" data-showpost="12" data-widgetid="mymo-advanced-widget-{{ $i }}" data-layout="6col">
                            <span data-text="{{ $child->name }}"></span>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </h4>

                <div id="mymo-advanced-widget-{{ $i }}-ajax-box" class="mymo_box">
                    @if(!$genre->items->isEmpty())
                        @foreach($genre->items as $item)
                        <article class="col-md-2 col-sm-4 col-xs-6 thumb grid-item post-{{ $item->id }}">
                            @include('themes.mymo.data.item')
                        </article>
                        @endforeach
                    @endif

                    <a href="{{ @$genre->url }}" class="see-more">@lang('app.view_all') »</a>
                </div>
            </section>
            <div class="clearfix"></div>
            @endif
            @endfor
        </div>

    </div>
@endsection
