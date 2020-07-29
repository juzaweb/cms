@extends('themes.mymo.layout')

@section('content')
<div class="row container" id="wrapper">
    <div class="halim-panel-filter">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-8 hidden-xs">
                    <div class="yoast_breadcrumb">
                        <span>
                            <span>
                                <a href="/">@lang('app.home')</a> » <span>
                                    <a href="{{ route('genre', [$genre->slug]) }}">{{ $genre->name }}</a> »
                                    <span class="breadcrumb_last" aria-current="page">{{ $info->name }}</span>
                                </span>
                            </span>
                        </span>
                    </div>
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

    <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
        <section id="content">
            <div class="clearfix wrap-content">
                <script>var halim_cfg = {
                        "act": "watch",
                        "post_url": "{{ url()->current() }}",
                        "ajax_url": "",
                        "set_movie_view_url": "{{ route('watch.set_view', [$info->slug]) }}",
                        "player_url": "{{ route('watch.player', [$info->slug, $vid]) }}",
                        "loading_img": "{{ asset('styles/themes/mymo/images/ajax-loader.gif') }}",
                        "eps_slug": "tap",
                        "server_slug": "s",
                        "type_slug": "slug-2",
                        "post_title": "{{ $info->name }}",
                        "post_id": '{{ $info->id }}',
                        "episode_slug": "tap-1",
                        "server": "1",
                        "player_error_detect": "display_modal",
                        "paging_episode": "false",
                        "episode_display": "show_list_eps",
                        "episode_nav_num": 100,
                        "auto_reset_cache": true,
                        "resume_playback": true,
                        "resume_text": "Tự động phát lại phim từ thời điểm bạn xem gần đây nhất tại",
                        "resume_text_2": "Phát lại từ đầu?",
                        "playback": "Phát lại",
                        "continue_watching": "Xem tiếp",
                        "player_reload": "Tải lại trình phát",
                        "jw_error_msg_0": "Chúng tôi không thể tìm thấy video bạn đang tìm kiếm. Có thể có một số lý do cho việc này, ví dụ như nó đã bị xóa bởi chủ sở hữu!",
                        "jw_error_msg_1": "Video lỗi không thể phát được.",
                        "jw_error_msg_2": "Để xem tiếp, vui lòng click vào nút \"Tải lại trình phát\"",
                        "jw_error_msg_3": "hoặc click vào các nút được liệt kê bên dưới",
                        "light_on": "Bật đèn",
                        "light_off": "Tắt đèn",
                        "expand": "Phóng to",
                        "collapse": "Thu nhỏ",
                        "player_loading": "Đang khởi tạo trình phát, vui lòng chờ...",
                        "player_autonext": "Đang tự động chuyển tập, vui lòng chờ...",
                        "is_adult": false,
                        "adult_title": "Adult Content Warning!",
                        "adult_content": "<span style=\"vertical-align: inherit;\"><span style=\"vertical-align: inherit;\">Trang web này chứa nội dung dành cho các cá nhân từ 18\/21 tuổi trở lên được xác định theo luật pháp địa phương và quốc gia của khu vực nơi bạn cư trú. <\/span><span style=\"vertical-align: inherit;\">Nếu bạn chưa đủ 18 tuổi, hãy rời khỏi trang web này ngay lập tức. <\/span><span style=\"vertical-align: inherit;\">Khi vào trang web này, bạn đồng ý rằng bạn từ 18 tuổi trở lên. <\/span><span style=\"vertical-align: inherit;\">Bạn sẽ không phân phối lại tài liệu này cho bất kỳ ai, và bạn cũng sẽ không cho phép bất kỳ trẻ vị thành niên nào xem tài liệu này.<\/span><\/span>",
                        "show_only_once": "Không hiển thị lại",
                        "exit_btn": "THOÁT",
                        "is_18plus": "TÔI ĐỦ 18 TUỔI",
                        "report_lng": {
                            "title": "Tổ Chức Rugal",
                            "alert": "Tên (email) và nội dung là bắt buộc",
                            "msg": "Nội dung",
                            "msg_success": "Cảm ơn bạn đã gửi thông báo lỗi. Chúng tôi sẽ tiến hành sửa lỗi sớm nhất có thể",
                            "loading_img": "http:\/\/xemphimplus.net\/wp-content\/plugins\/halim-movie-report\/loading.gif",
                            "report_btn": "Báo lỗi",
                            "name_or_email": "Tên hoặc Email",
                            "close": "Đóng"
                        }
                    }</script>
                <div class="clearfix"></div>
                <div class="text-center">
                    <div class="textwidget">
                    </div>
                </div>
                <div class="clearfix"></div>

                <div id="halim-player-wrapper" class="ajax-player-loading" data-adult-content="">
                    <div id="halim-player-loader"></div>
                    <div id="ajax-player" class="player"></div>
                </div>

                <div class="clearfix"></div>

                <div class="button-watch">
                    <ul class="halim-social-plugin col-xs-4 hidden-xs">
                        <li class="fb-like" data-href="{{ route('watch', [$info->slug]) }}" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></li>
                    </ul>
                    <ul class="col-xs-12 col-md-8">
                        <div id="autonext" class="btn-cs autonext">
                            <i class="icon-autonext-sm"></i>
                            <span><i class="hl-next"></i> @lang('app.autoplay_next_episode'): <span id="autonext-status">@lang('app.on')</span></span>
                        </div>

                        <div id="explayer" class="hidden-xs">
                            <i class="hl-resize-full"></i>
                            @lang('app.expand')
                        </div>

                        <div id="toggle-light"><i class="hl-adjust"></i>
                            @lang('app.light_off')
                        </div>

                        <div id="report" class="halim-switch">
                            <i class="hl-attention"></i> @lang('app.report')
                        </div>

                        <div class="luotxem"><i class="hl-eye"></i>
                            <span>{{ $info->getViews() }}</span> @lang('app.views')
                        </div>

                        <div class="luotxem visible-xs-inline">
                            <a data-toggle="collapse" href="#moretool" aria-expanded="false" aria-controls="moretool"><i class="hl-forward"></i> @lang('app.share')</a>
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
                    <a href="javascript:;" data-toggle="tooltip" title="@lang('app.add_to_bookmark')">
                        <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-post_id="{{ $info->id }}" data-thumbnail="{{ $info->getThumbnail() }}" data-href="{{ route('watch', [$info->slug]) }}" data-title="{{ $info->name }}" data-date="{{ $info->release }}">
                            <!-- <div class="halim-pulse-ring"></div> -->
                        </div>
                    </a>

                    <div class="title-wrapper full">
                        <h1 class="entry-title"><a href="{{ route('watch.play', [$info->slug, $vid]) }}" title="{{ $info->meta_title }}" class="tl">{{ $info->meta_title }}</a></h1>

                        <span class="plot-collapse" data-toggle="collapse" data-target="#expand-post-content" aria-expanded="false" aria-controls="expand-post-content" data-text="@lang('app.movie_plot')"><i class="hl-angle-down"></i></span>
                    </div>

                    <div class="ratings_wrapper hidden-xs">
                        <div class="halim_imdbrating taq-score">
                            <span class="score">{{ $start }}</span><i>/</i>
                            <span class="max-ratings">5</span>
                            <span class="total_votes">{{ $info->countRating() }}</span><span class="vote-txt"> @lang('app.votes')</span>
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
                <div class="text-center halim-ajax-list-server">
                    <div id="halim-ajax-list-server">
                        <script>var svlists = [];</script></div>
                </div>

                <div id="halim-list-server" class="list-eps-ajax">
                    @foreach($servers as $server)
                        @php
                            $video_files = $server->video_files()
                                ->orderBy('order', 'asc')
                                ->get(['id', 'label']);
                        @endphp
                        <div class="halim-server show_all_eps" data-episode-nav="">
                            <span class="halim-server-name">
                                <span class="hl-server"></span> {{ $server->name }}
                            </span>

                            <ul id="listsv-{{ $server->id }}" class="halim-list-eps">
                                @foreach($video_files as $file)
                                    <li class="halim-episode halim-episode-{{ $file->id }} @if($file->id == $vid) active @endif"><a href="{{ route('watch.play', [$info->slug, $file->id]) }}" title="1"><span class="halim-info-{{ $file->id }} box-shadow halim-btn" data-post-id="{{ $info->id }}" data-server="{{ $server->id }}" data-episode-slug="{{ $file->id }}" data-position="first" data-embed="0">{{ $file->label }}</span></a></li>
                                @endforeach
                            </ul>

                            <div class="clearfix"></div>
                        </div>
                        <div id="pagination-1"></div>
                    @endforeach
                </div>
                <div class="clearfix"></div>

                <div class="htmlwrap clearfix">
                    <div class="fb-comments"  data-href="/to-chuc-rugal/" data-width="100%" data-mobile="true" data-colorscheme="dark" data-numposts="5" data-order-by="reverse_time"></div>
                </div>

                <div id="lightout"></div>

            </div>
        </section>

        <section class="related-movies">

            <div id="halim_related_movies-2xx" class="wrap-slider">
                <div class="section-bar clearfix">
                    <h3 class="section-title"><span>@lang('app.similar_movies')</span></h3>
                </div>
                <div id="halim_related_movies-2" class="owl-carousel owl-theme related-film">
                    @foreach($related_movies as $item)
                        <article class="thumb grid-item post-{{ $item->id }}">
                            @include('themes.mymo.data.relate_item')
                        </article>
                    @endforeach
                </div>
                <script>
                    jQuery(document).ready(function ($) {
                        var owl = $('#halim_related_movies-2');
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
        @include('themes.mymo.data.sidebar')
    </aside>
</div>
@endsection