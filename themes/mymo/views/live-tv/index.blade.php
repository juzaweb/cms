@extends('layouts.master')

@section('content')
<div class="row container" id="wrapper">
    <div class="mymo-panel-filter">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-8 hidden-xs">
                    <div class="yoast_breadcrumb">
                        <span>
                            <span>
                                <a href="/">@lang('theme::app.home')</a> » <span>
                                    @if($genre)
                                    <a href="{{ route('genre', [$genre->slug]) }}">{{ $genre->name }}</a> »
                                    @endif
                                    <a href="{{ route('watch', [$info->slug]) }}">{{ $info->name }}</a> »

                                    <span class="breadcrumb_last" aria-current="page">@lang('theme::app.episode') {{ @\App\Core\Models\Video\VideoFiles::find($player_id, ['label'])->label }}</span>
                                </span>
                            </span>
                        </span>
                    </div>
                </div>

                <div class="col-xs-4 text-right">
                    <a href="javascript:;" id="expand-ajax-filter">@lang('theme::app.filter_movies') <i id="ajax-filter-icon" class="hl-angle-down"></i></a>
                </div>

                <div id="alphabet-filter" style="float: right;display: inline-block;margin-right: 25px;"></div>
            </div>
        </div>
        <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
            <div class="ajax"></div>
        </div>
    </div><!-- end panel-default -->

    <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
        <section id="content">
            <div class="clearfix wrap-content">
                @php
                $is_watch = 1;
                @endphp
                @include('watch.component.global_script')
                <div class="clearfix"></div>
                <div class="text-center">
                    <div class="textwidget">
                    </div>
                </div>
                <div class="clearfix"></div>

                <div id="mymo-player-wrapper" class="ajax-player-loading" data-adult-content="">
                    <div id="mymo-player-loader"></div>
                    <div id="ajax-player" class="player"></div>
                </div>

                <div class="clearfix"></div>

                <div class="button-watch">
                    <ul class="mymo-social-plugin col-xs-4 hidden-xs">
                        <li class="fb-like" data-href="{{ route('watch', [$info->slug]) }}" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></li>
                    </ul>
                    <ul class="col-xs-12 col-md-8">
                        <div id="autonext" class="btn-cs autonext">
                            <i class="icon-autonext-sm"></i>
                            <span><i class="hl-next"></i> @lang('theme::app.autoplay_next_episode'): <span id="autonext-status">@lang('theme::app.on')</span></span>
                        </div>

                        <div id="explayer" class="hidden-xs">
                            <i class="hl-resize-full"></i>
                            @lang('theme::app.expand')
                        </div>

                        <div id="toggle-light"><i class="hl-adjust"></i>
                            @lang('theme::app.light_off')
                        </div>

                        <div id="report" class="mymo-switch">
                            <i class="hl-attention"></i> @lang('theme::app.report')
                        </div>

                        <div class="luotxem"><i class="hl-eye"></i>
                            <span>{{ $info->getViews() }}</span> @lang('theme::app.views')
                        </div>

                        <div class="luotxem visible-xs-inline">
                            <a data-toggle="collapse" href="#moretool" aria-expanded="false" aria-controls="moretool"><i class="hl-forward"></i> @lang('theme::app.share')</a>
                        </div>

                    </ul>
                </div>

                <div class="collapse" id="moretool">
                    <ul class="nav nav-pills x-nav-justified">
                        <li class="fb-like" data-href="" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></li>
                        <div class="fb-save" data-uri="" data-size="small"></div>
                    </ul>
                </div>

                <div class="clearfix"></div>
                @php
                    $ads = get_ads('player_bottom');
                @endphp
                @if($ads)
                <div class="text-center">
                    <div class="textwidget">
                        <!-- Ads -->
                        {!! $ads !!}
                    </div>
                </div>
                @endif

                <div class="text-center">

                    <div class="textwidget">
                        <style type="text/css">
                            #main-contents{position:relative;}
                            .float-left{position:absolute;left:-130px;top:0;}
                            .float-right{position:absolute;right:-460px;top:0;}
                        </style>

                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="title-block watch-page">
                    <a href="javascript:;" data-toggle="tooltip" title="@lang('theme::app.add_to_bookmark')">
                        <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-post_id="{{ $info->id }}" data-thumbnail="{{ $info->getThumbnail() }}" data-href="{{ route('watch', [$info->slug]) }}" data-title="{{ $info->name }}" data-date="{{ $info->release }}">
                            <!-- <div class="mymo-pulse-ring"></div> -->
                        </div>
                    </a>

                    <div class="title-wrapper full">
                        <h1 class="entry-title"><a href="{{ route('watch.play', [$info->slug, $player_id]) }}" title="{{ $info->meta_title }}" class="tl">{{ $info->meta_title }}</a></h1>

                        <span class="plot-collapse" data-toggle="collapse" data-target="#expand-post-content" aria-expanded="false" aria-controls="expand-post-content" data-text="@lang('theme::app.movie_plot')"><i class="hl-angle-down"></i></span>
                    </div>

                    <div class="ratings_wrapper hidden-xs">
                        <div class="mymo_imdbrating taq-score">
                            <span class="score">{{ $start }}</span><i>/</i>
                            <span class="max-ratings">5</span>
                            <span class="total_votes">{{ $info->countRating() }}</span><span class="vote-txt"> @lang('theme::app.votes')</span>
                        </div>
                        <div class="rate-this">
                            <div data-rate="{{ $start * 100 / 5 }}" data-id="{{ $info->id }}" class="user-rate user-rate-active">
                                <span class="user-rate-image post-large-rate stars-large">
                                    <span style="width: {{ $start * 100 / 5 }}%"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="entry-content htmlwrap clearfix collapse" id="expand-post-content">
                    <article id="post-{{ $info->id }}" class="item-content post-{{ $info->id }}">
                        {!! $info->description !!}
                    </article>
                </div>

                <div class="clearfix"></div>
                <div class="text-center mymo-ajax-list-server">
                    <div id="mymo-ajax-list-server">
                        <script>var svlists = [];</script></div>
                </div>

                <div id="mymo-list-server" class="list-eps-ajax">
                    @foreach($servers as $server)
                        @php
                            $video_files = $server->video_files()
                                ->orderBy('order', 'asc')
                                ->get(['id', 'label']);
                        @endphp
                        <div class="mymo-server show_all_eps" data-episode-nav="">
                            <span class="mymo-server-name">
                                <span class="hl-server"></span> {{ $server->name }}
                            </span>

                            <ul id="listsv-{{ $server->id }}" class="mymo-list-eps">
                                @foreach($video_files as $file)
                                    <li class="mymo-episode mymo-episode-{{ $file->id }} @if($file->id == $player_id) active @endif"><a href="{{ route('watch.play', [$info->slug, $file->id]) }}" title="1"><span class="mymo-info-{{ $file->id }} box-shadow mymo-btn @if($file->id == $player_id) active @endif" data-post-id="{{ $info->id }}" data-server="{{ $server->id }}" data-episode-slug="{{ $file->id }}" data-position="first" data-embed="0">{{ $file->label }}</span></a></li>
                                @endforeach
                            </ul>

                            <div class="clearfix"></div>
                        </div>
                        <div id="pagination-{{ $server->id }}"></div>
                    @endforeach
                </div>
                <div class="clearfix"></div>

                @include('watch.component.comment')

                <div id="lightout"></div>

            </div>
        </section>

        <section class="related-movies">

            <div id="mymo_related_movies-2xx" class="wrap-slider">
                <div class="section-bar clearfix">
                    <h3 class="section-title"><span>@lang('theme::app.similar_movies')</span></h3>
                </div>
                <div id="mymo_related_movies-2" class="owl-carousel owl-theme related-film">
                    @foreach($related_movies as $item)
                        <article class="thumb grid-item post-{{ $item->id }}">
                            @include('data.relate_item')
                        </article>
                    @endforeach
                </div>
                <script>
                    jQuery(document).ready(function ($) {
                        var owl = $('#mymo_related_movies-2');
                        owl.owlCarousel({
                            loop: true,
                            margin: 4,
                            autoplay: true,
                            autoplayTimeout: 4000,
                            autoplayHoverPause: true,
                            nav: true,
                            navText: ['<i class="hl-down-open rotate-left"></i>', '<i class="hl-down-open rotate-right"></i>'],
                            responsiveClass: true,
                            responsive: {0: {items: 2}, 480: {items: 3}, 600: {items: 4}, 1000: {items: 4}}
                        })
                    });
                </script>
            </div>
        </section>
        <div class="the_tag_list">
            @foreach($tags as $tag)
                <a href="{{ route('tag', [$tag->slug]) }}" title="{{ $tag->name }}" rel="tag">{{ $tag->name }}</a>
            @endforeach
        </div>
    </main>
    <aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
        @include('data.sidebar')
    </aside>
</div>
@endsection