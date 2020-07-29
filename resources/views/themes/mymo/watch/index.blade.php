@extends('themes.mymo.layout')

@section('content')

<div class="row container" id="wrapper">
    <div class="halim-panel-filter">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-8 hidden-xs">
                    <div class="yoast_breadcrumb">
                        <span>
                            <span><a href="{{ route('home') }}">@lang('app.home')</a> »
                                <span><a href="{{ route('genre', [$genre->slug]) }}">{{ $genre->name }}</a> »
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

                <script type="text/javascript">var halim_cfg = {
                        "act": "",
                        "post_url": "{{ url()->current() }}",
                        "ajax_url": "",
                        "player_url": "{{ route('watch.player', [$info->slug, $player_id]) }}",
                        "rating_url": "{{ route('watch.rating', [$info->slug]) }}",
                        "loading_img": "{{ asset('styles/themes/mymo/images/ajax-loader.gif') }}",
                        "eps_slug": "eps",
                        "server_slug": "s",
                        "type_slug": "slug-2",
                        "post_title": "{{ $info->name }}",
                        "post_id": '',
                        "episode_slug": "",
                        "server": 1,
                        "player_error_detect": "display_modal",
                        "paging_episode": "false",
                        "episode_display": "show_list_eps",
                        "episode_nav_num": 100,
                        "auto_reset_cache": true,
                        "resume_playback": true,
                        "resume_text": "Tự động phát lại phim từ thời điểm bạn xem gần đây nhất tại",
                        "resume_text_2": "Phát lại từ đầu?",
                        "playback": "@lang('app.playback')",
                        "continue_watching": "@lang('app.continue_watching')",
                        "player_reload": "@lang('app.player_reload')",
                        "jw_error_msg_0": "Chúng tôi không thể tìm thấy video bạn đang tìm kiếm. Có thể có một số lý do cho việc này, ví dụ như nó đã bị xóa bởi chủ sở hữu!",
                        "jw_error_msg_1": "Video lỗi không thể phát được.",
                        "jw_error_msg_2": "Để xem tiếp, vui lòng click vào nút \"Tải lại trình phát\"",
                        "jw_error_msg_3": "hoặc click vào các nút được liệt kê bên dưới",
                        "light_on": "@lang('app.light_on')",
                        "light_off": "@lang('app.light_off')",
                        "expand": "@lang('app.expand')",
                        "collapse": "@lang('app.collapse')",
                        "player_loading": "@lang('app.player_loading')",
                        "player_autonext": "@lang('app.player_autonext')",
                        "is_adult": false,
                        "adult_title": "Adult Content Warning!",
                        "adult_content": "<span style=\"vertical-align: inherit;\"><span style=\"vertical-align: inherit;\">Trang web này chứa nội dung dành cho các cá nhân từ 18\/21 tuổi trở lên được xác định theo luật pháp địa phương và quốc gia của khu vực nơi bạn cư trú. <\/span><span style=\"vertical-align: inherit;\">Nếu bạn chưa đủ 18 tuổi, hãy rời khỏi trang web này ngay lập tức. <\/span><span style=\"vertical-align: inherit;\">Khi vào trang web này, bạn đồng ý rằng bạn từ 18 tuổi trở lên. <\/span><span style=\"vertical-align: inherit;\">Bạn sẽ không phân phối lại tài liệu này cho bất kỳ ai, và bạn cũng sẽ không cho phép bất kỳ trẻ vị thành niên nào xem tài liệu này.<\/span><\/span>",
                        "show_only_once": "Không hiển thị lại",
                        "exit_btn": "THOÁT",
                        "is_18plus": "TÔI ĐỦ 18 TUỔI",
                        "report_lng": {
                            "title": "{{ $info->name }}",
                            "alert": "Tên (email) và nội dung là bắt buộc",
                            "msg": "Nội dung",
                            "msg_success": "Cảm ơn bạn đã gửi thông báo lỗi. Chúng tôi sẽ tiến hành sửa lỗi sớm nhất có thể",
                            "loading_img": "{{ asset('styles/themes/mymo/images/loading.gif') }}",
                            "report_btn": "@lang('app.report')",
                            "name_or_email": "Tên hoặc Email",
                            "close": "@lang('app.close')"
                        }
                    }
                </script>

                <div class="halim-movie-wrapper">
                    <div class="title-block watch-page">
                        <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-id="{{ $info->id }}" data-toggle="tooltip" title="@lang('app.add_to_bookmark')">

                        </div>
                        <div class="title-wrapper">
                            <h1 class="entry-title" data-toggle="tooltip" title="{{ $info->name }}">{{ $info->name }}<span class="title-year"> (<a href="{{ route('year', [$info->year]) }}" rel="tag">{{ $info->year }}</a>)</span></h1>
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

                        <div class="more-info">
                            @if($info->tv_series == 0)
                            <span>Full</span>
                            <span>{{ $info->runtime }}</span>
                            @else
                            <span>@lang('app.episode') {{ $info->current_episode }}{{ $info->max_episode ? '/' . $info->max_episode : '' }}</span>
                            @endif
                            <span>
                            @foreach($genres as $genre)
                                <a href="{{ route('genre', [$genre->slug]) }}" rel="category tag">{{ $genre->name }}</a>,
                            @endforeach
                            </span>
                        </div>
                    </div>
                    <div class="movie_info col-xs-12">
                        <div class="movie-poster col-md-3">
                            <img class="movie-thumb" src="{{ $info->getThumbnail() }}" alt="{{ $info->name }}">
                            <div class="halim_imdbrating"><span>{{ $info->rating }}</span></div>
                            <a href="{{ route('watch.play', [$info->slug, $player_id]) }}" class="btn btn-sm btn-danger watch-movie visible-xs-block"><i class="hl-play"></i>@lang('watch')</a>


                            <span id="show-trailer" data-url="{{ $info->trailer }}" class="btn btn-sm btn-primary show-trailer">
                            <i class="hl-youtube-play"></i> @lang('app.trailer')</span>

                            <span class="btn btn-sm btn-success quick-eps" data-toggle="collapse" href="#collapseEps" aria-expanded="false" aria-controls="collapseEps">
                                <i class="hl-sort-down"></i> @lang('app.episodes')
                            </span>
                        </div>

                        <div class="film-poster col-md-9">
                            <div class="film-poster-img" style="background: url('{{ $info->getPoster() }}'); background-size: cover; background-repeat: no-repeat;background-position: 30% 25%;height: 300px;-webkit-filter: grayscale(100%); filter: grayscale(100%);"></div>
                            <div class="halim-play-btn hidden-xs">
                                <a href="{{ route('watch.play', [$info->slug, $player_id]) }}" class="play-btn" title="Click to Play" data-toggle="tooltip" data-placement="bottom">Click to Play</a>
                            </div>

                            <div class="movie-trailer hidden"></div>
                            <div class="movie-detail">

                                <p class="actors">@lang('app.countries'):
                                    @foreach($countries as $country)
                                    <a href="{{ route('country', [$country->slug]) }}" title="{{ $country->name }}">{{ $country->name }}</a>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="clearfix"></div>

                <div id="halim_trailer"></div>

                <div class="collapse" id="collapseEps">
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
                                <li class="halim-episode halim-episode-{{ $file->id }}"><a href="{{ route('watch.play', [$info->slug, $file->id]) }}" title="1"><span class="halim-info-{{ $file->id }} box-shadow halim-btn" data-post-id="{{ $info->id }}" data-server="{{ $server->id }}" data-episode-slug="{{ $file->id }}" data-position="first" data-embed="0">{{ $file->label }}</span></a></li>
                                @endforeach
                            </ul>

                            <div class="clearfix"></div>
                        </div>
                        <div id="pagination-1"></div>
                        @endforeach
                    </div>
                </div>
                <div class="clearfix"></div>
                @php($ads = get_ads('player_bottom'))
                @if($ads)
                <div class="halim--notice">
                    <!-- Ads -->
                    {!! $ads !!}
                </div>
                @endif

                <div class="entry-content htmlwrap clearfix">
                    <div class="video-item halim-entry-box">
                        <article id="post-{{ $info->id }}" class="item-content">
                            {!! $info->description !!}
                        </article>
                        <div class="item-content-toggle">
                            <div class="item-content-gradient"></div>
                            <span class="show-more" data-single="true" data-showmore="@lang('app.show_more')" data-showless="@lang('app.show_less')">@lang('app.show_more')</span>
                        </div>
                    </div>
                </div>
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
                    $(document).on("turbolinks:load", function() {
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
                            responsive: {
                                0: {items:2},
                                480: {items:3},
                                600: {items:4},
                                1000: {items: 4}
                            }
                        });
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