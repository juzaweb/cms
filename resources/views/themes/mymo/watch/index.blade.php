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
                    <a href="javascript:;" id="expand-ajax-filter">Lọc phim <i id="ajax-filter-icon" class="hl-angle-down"></i></a>
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

                <script type="text/javascript">var halim_cfg = {"act":"","post_url":"http:\/\/xemphimplus.net\/xem-phim-to-chuc-rugal","ajax_url":"http:\/\/xemphimplus.net\/wp-content\/themes\/halimmovies\/halim-ajax.php","player_url":"http:\/\/xemphimplus.net\/wp-content\/themes\/halimmovies\/player.php","loading_img":"http:\/\/xemphimplus.net\/wp-content\/themes\/halimmovies\/assets\/images\/ajax-loader.gif","eps_slug":"tap","server_slug":"s","type_slug":"slug-2","post_title":"Tổ Chức Rugal","post_id":14773,"episode_slug":"tap-1","server":1,"player_error_detect":"display_modal","paging_episode":"false","episode_display":"show_list_eps","episode_nav_num":100,"auto_reset_cache":true,"resume_playback":true,"resume_text":"Tự động phát lại phim từ thời điểm bạn xem gần đây nhất tại","resume_text_2":"Phát lại từ đầu?","playback":"Phát lại","continue_watching":"Xem tiếp","player_reload":"Tải lại trình phát","jw_error_msg_0":"Chúng tôi không thể tìm thấy video bạn đang tìm kiếm. Có thể có một số lý do cho việc này, ví dụ như nó đã bị xóa bởi chủ sở hữu!","jw_error_msg_1":"Video lỗi không thể phát được.","jw_error_msg_2":"Để xem tiếp, vui lòng click vào nút \"Tải lại trình phát\"","jw_error_msg_3":"hoặc click vào các nút được liệt kê bên dưới","light_on":"Bật đèn","light_off":"Tắt đèn","expand":"Phóng to","collapse":"Thu nhỏ","player_loading":"Đang khởi tạo trình phát, vui lòng chờ...","player_autonext":"Đang tự động chuyển tập, vui lòng chờ...","is_adult":false,"adult_title":"Adult Content Warning!","adult_content":"<span style=\"vertical-align: inherit;\"><span style=\"vertical-align: inherit;\">Trang web này chứa nội dung dành cho các cá nhân từ 18\/21 tuổi trở lên được xác định theo luật pháp địa phương và quốc gia của khu vực nơi bạn cư trú. <\/span><span style=\"vertical-align: inherit;\">Nếu bạn chưa đủ 18 tuổi, hãy rời khỏi trang web này ngay lập tức. <\/span><span style=\"vertical-align: inherit;\">Khi vào trang web này, bạn đồng ý rằng bạn từ 18 tuổi trở lên. <\/span><span style=\"vertical-align: inherit;\">Bạn sẽ không phân phối lại tài liệu này cho bất kỳ ai, và bạn cũng sẽ không cho phép bất kỳ trẻ vị thành niên nào xem tài liệu này.<\/span><\/span>","show_only_once":"Không hiển thị lại","exit_btn":"THOÁT","is_18plus":"TÔI ĐỦ 18 TUỔI","report_lng":{"title":"Tổ Chức Rugal","alert":"Tên (email) và nội dung là bắt buộc","msg":"Nội dung","msg_success":"Cảm ơn bạn đã gửi thông báo lỗi. Chúng tôi sẽ tiến hành sửa lỗi sớm nhất có thể","loading_img":"http:\/\/xemphimplus.net\/wp-content\/plugins\/halim-movie-report\/loading.gif","report_btn":"Báo lỗi","name_or_email":"Tên hoặc Email","close":"Đóng"}}</script>

                <div class="halim-movie-wrapper">
                    <div class="title-block watch-page">
                        <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-id="14773" data-toggle="tooltip" title="Add to bookmark">

                        </div>
                        <div class="title-wrapper">
                            <h1 class="entry-title" data-toggle="tooltip" title="{{ $info->name }}">{{ $info->name }}<span class="title-year"> (<a href="/release/2020" rel="tag">2020</a>)</span></h1>
                        </div>

                        <div class="ratings_wrapper hidden-xs">
                            <div class="halim_imdbrating taq-score">
                                <span class="score">4.28</span><i>/</i>
                                <span class="max-ratings">5</span>
                                <span class="total_votes">8</span><span class="vote-txt"> đánh giá</span>
                            </div>
                            <div class="rate-this">
                                <div data-rate="85.5" data-id="14773" class="user-rate user-rate-active">
				<span class="user-rate-image post-large-rate stars-large">
					<span style="width: 85.5%"></span>
				</span>
                                </div>
                            </div>
                        </div>
                        <div class="more-info">
                            <span>Tập 16/16</span>
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
                            <div class="halim_imdbrating"><span>6.7</span></div>
                            <a href="{{ route('watch.play', [$info->slug]) }}" class="btn btn-sm btn-danger watch-movie visible-xs-block"><i class="hl-play"></i>Xem phim</a>


                            <span id="show-trailer" data-url="" class="btn btn-sm btn-primary show-trailer">
                            <i class="hl-youtube-play"></i> Trailer</span>

                            <span class="btn btn-sm btn-success quick-eps">
                                <a data-toggle="collapse" href="#collapseEps" aria-expanded="false" aria-controls="collapseEps"><i class="hl-sort-down"></i> Chọn tập</a>
                            </span>
                        </div>

                        <div class="film-poster col-md-9">
                            <div class="film-poster-img" style="background: url('{{ $info->getPoster() }}'); background-size: cover; background-repeat: no-repeat;background-position: 30% 25%;height: 300px;-webkit-filter: grayscale(100%); filter: grayscale(100%);"></div>
                            <div class="halim-play-btn hidden-xs">
                                <a href="{{ route('watch.play', [$info->slug]) }}" class="play-btn" title="Click to Play" data-toggle="tooltip" data-placement="bottom">Click to Play</a>
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
                        <div class="halim-server show_all_eps" data-episode-nav="">
                            <span class="halim-server-name">
                                <span class="hl-server"></span> Server HD</span>
                            <ul id="listsv-1" class="halim-list-eps">
                                <li class="halim-episode halim-episode-1-tap-1"><a href="/xem-phim-to-chuc-rugal/tap-1-sv1.html" title="1"><span class="halim-info-1-tap-1 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-1" data-position="first" data-embed="0">1</span></a></li>
                            </ul>

                            <div class="clearfix"></div>
                        </div>
                        <div id="pagination-1"></div>

                        <div class="halim-server show_all_eps" data-episode-nav="">
                            <span class="halim-server-name"><span class="hl-server"></span> Server VIP</span>
                            <ul id="listsv-2" class="halim-list-eps">
                                <li class="halim-episode halim-episode-2-tap-1"><span data-href="/xem-phim-to-chuc-rugal/tap-1-sv2.html" class="clickable halim-info-2-tap-1 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-1" data-position="first" data-embed="0">1</span></li>
                            </ul>

                            <div class="clearfix"></div>
                        </div>
                        <div id="pagination-2"></div>

                        <div class="halim-server show_all_eps" data-episode-nav=""><span class="halim-server-name"><span class="hl-server"></span> Server VIP 2</span>
                            <ul id="listsv-3" class="halim-list-eps">
                                <li class="halim-episode halim-episode-3-tap-1"><span data-href="/xem-phim-to-chuc-rugal/tap-1-sv3.html" class="clickable halim-info-3-tap-1 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-1" data-position="first" data-embed="0">1</span></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div id="pagination-3"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="halim--notice">
                    <!-- Ads -->

                </div>

                <div class="entry-content htmlwrap clearfix">
                    <div class="video-item halim-entry-box">
                        <article id="post-{{ $info->id }}" class="item-content">

                        </article>
                        <div class="item-content-toggle">
                            <div class="item-content-gradient"></div>
                            <span class="show-more" data-single="true" data-showmore="Hiển thị thêm" data-showless="Rút gọn">Hiển thị thêm</span>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <section class="related-movies">

            <div id="halim_related_movies-2xx" class="wrap-slider">
                <div class="section-bar clearfix">
                    <h3 class="section-title"><span>CÓ THỂ BẠN MUỐN XEM?</span></h3>
                </div>
                <div id="halim_related_movies-2" class="owl-carousel owl-theme related-film">
                    @foreach($related_movies as $item)
                    <article class="thumb grid-item post-{{ $item->id }}">
                        @include('themes.mymo.data.mini_item')
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
        <div id="text-16" class="widget widget_text">
            <div class="textwidget">

            </div>
        </div>

        <div id="text-14" class="widget widget_text">
            <div class="textwidget">
                <!-- Ads -->
            </div>
        </div>
        <div id="halim_tab_popular_videos-widget-5" class="widget halim_tab_popular_videos-widget">			<div class="section-bar clearfix">
                <div class="section-title">
                    <span>Nổi bật</span>
                    <ul class="halim-popular-tab" role="tablist">
                        <li role="presentation" class="active">
                            <a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="10" data-type="day">Ngày</a>
                        </li>
                        <li role="presentation">
                            <a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="10" data-type="week">Tuần</a>
                        </li>
                        <li role="presentation">
                            <a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="10" data-type="month">Tháng</a>
                        </li>
                        <li role="presentation">
                            <a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="10" data-type="all">Tất cả</a>
                        </li>
                    </ul>
                </div>
            </div>

            <section class="tab-content">
                <div role="tabpanel" class="tab-pane active halim-ajax-popular-post">
                    <div class="halim-ajax-popular-post-loading hidden"></div>
                    <div id="halim-ajax-popular-post" class="popular-post"></div>
                </div>
            </section>
            <div class="clearfix"></div>
        </div>
    </aside>
</div>

@endsection