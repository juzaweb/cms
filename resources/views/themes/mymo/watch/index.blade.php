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
                                <span><a href="/hanh-dong/">Hành Động</a> »
                                    <span class="breadcrumb_last" aria-current="page">{{ $item->name }}</span>
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
                            <h1 class="entry-title" data-toggle="tooltip" title="{{ $item->name }}">{{ $item->name }}<span class="title-year"> (<a href="/release/2020" rel="tag">2020</a>)</span></h1>
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

                                <a href="/hanh-dong" rel="category tag">Hành Động</a>,

                            </span>
                        </div>
                    </div>
                    <div class="movie_info col-xs-12">
                        <div class="movie-poster col-md-3">
                            <img class="movie-thumb" src="{{ $item->getThumbnail() }}" alt="{{ $item->name }}">
                            <div class="halim_imdbrating"><span>6.7</span></div>
                            <a href="/xem-phim-to-chuc-rugal/tap-1-sv1.html" class="btn btn-sm btn-danger watch-movie visible-xs-block"><i class="hl-play"></i>Xem phim</a>


                            <span id="show-trailer" data-url="" class="btn btn-sm btn-primary show-trailer">
                            <i class="hl-youtube-play"></i> Trailer</span>

                            <span class="btn btn-sm btn-success quick-eps">
                                <a data-toggle="collapse" href="#collapseEps" aria-expanded="false" aria-controls="collapseEps"><i class="hl-sort-down"></i> Chọn tập</a>
                            </span>
                        </div>

                        <div class="film-poster col-md-9">
                            <div class="film-poster-img" style="background: url('{{ image_url($item->poster) }}'); background-size: cover; background-repeat: no-repeat;background-position: 30% 25%;height: 300px;-webkit-filter: grayscale(100%); filter: grayscale(100%);"></div>
                            <div class="halim-play-btn hidden-xs">
                                <a href="" class="play-btn" title="Click to Play" data-toggle="tooltip" data-placement="bottom">Click to Play</a>
                            </div>

                            <div class="movie-trailer hidden"></div>
                            <div class="movie-detail">

                                <p class="actors">Quốc gia: <a href="/country/han-quoc" title="Hàn Quốc">Hàn Quốc</a></p>

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
                                <span class="hl-server"></span> Server HD</span><ul id="listsv-1" class="halim-list-eps"><li class="halim-episode halim-episode-1-tap-1"><a href="/xem-phim-to-chuc-rugal/tap-1-sv1.html" title="1"><span class="halim-info-1-tap-1 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-1" data-position="first" data-embed="0">1</span></a></li><li class="halim-episode halim-episode-1-tap-2"><a href="/xem-phim-to-chuc-rugal/tap-2-sv1.html" title="2"><span class="halim-info-1-tap-2 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-2" data-position="" data-embed="0">2</span></a></li><li class="halim-episode halim-episode-1-tap-3"><a href="/xem-phim-to-chuc-rugal/tap-3-sv1.html" title="3"><span class="halim-info-1-tap-3 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-3" data-position="" data-embed="0">3</span></a></li><li class="halim-episode halim-episode-1-tap-4"><a href="/xem-phim-to-chuc-rugal/tap-4-sv1.html" title="4"><span class="halim-info-1-tap-4 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-4" data-position="" data-embed="0">4</span></a></li><li class="halim-episode halim-episode-1-tap-5"><a href="/xem-phim-to-chuc-rugal/tap-5-sv1.html" title="5"><span class="halim-info-1-tap-5 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-5" data-position="" data-embed="0">5</span></a></li><li class="halim-episode halim-episode-1-tap-6"><a href="/xem-phim-to-chuc-rugal/tap-6-sv1.html" title="6"><span class="halim-info-1-tap-6 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-6" data-position="" data-embed="0">6</span></a></li><li class="halim-episode halim-episode-1-tap-7"><a href="/xem-phim-to-chuc-rugal/tap-7-sv1.html" title="7"><span class="halim-info-1-tap-7 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-7" data-position="" data-embed="0">7</span></a></li><li class="halim-episode halim-episode-1-tap-8"><a href="/xem-phim-to-chuc-rugal/tap-8-sv1.html" title="8"><span class="halim-info-1-tap-8 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-8" data-position="" data-embed="0">8</span></a></li><li class="halim-episode halim-episode-1-tap-9"><a href="/xem-phim-to-chuc-rugal/tap-9-sv1.html" title="9"><span class="halim-info-1-tap-9 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-9" data-position="" data-embed="0">9</span></a></li><li class="halim-episode halim-episode-1-tap-10"><a href="/xem-phim-to-chuc-rugal/tap-10-sv1.html" title="10"><span class="halim-info-1-tap-10 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-10" data-position="" data-embed="0">10</span></a></li><li class="halim-episode halim-episode-1-tap-11"><a href="/xem-phim-to-chuc-rugal/tap-11-sv1.html" title="11"><span class="halim-info-1-tap-11 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-11" data-position="" data-embed="0">11</span></a></li><li class="halim-episode halim-episode-1-tap-12"><a href="/xem-phim-to-chuc-rugal/tap-12-sv1.html" title="12"><span class="halim-info-1-tap-12 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-12" data-position="" data-embed="0">12</span></a></li><li class="halim-episode halim-episode-1-tap-13"><a href="/xem-phim-to-chuc-rugal/tap-13-sv1.html" title="13"><span class="halim-info-1-tap-13 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-13" data-position="" data-embed="0">13</span></a></li><li class="halim-episode halim-episode-1-tap-14"><a href="/xem-phim-to-chuc-rugal/tap-14-sv1.html" title="14"><span class="halim-info-1-tap-14 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-14" data-position="" data-embed="0">14</span></a></li><li class="halim-episode halim-episode-1-tap-15"><a href="/xem-phim-to-chuc-rugal/tap-15-sv1.html" title="15"><span class="halim-info-1-tap-15 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-15" data-position="" data-embed="0">15</span></a></li><li class="halim-episode halim-episode-1-tap-16"><a href="/xem-phim-to-chuc-rugal/tap-16-sv1.html" title="16"><span class="halim-info-1-tap-16 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-16" data-position="last" data-embed="0">16</span></a></li></ul><div class="clearfix"></div></div><div id="pagination-1"></div><div class="halim-server show_all_eps" data-episode-nav=""><span class="halim-server-name"><span class="hl-server"></span> Server VIP</span><ul id="listsv-2" class="halim-list-eps"><li class="halim-episode halim-episode-2-tap-1"><span data-href="/xem-phim-to-chuc-rugal/tap-1-sv2.html" class="clickable halim-info-2-tap-1 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-1" data-position="first" data-embed="0">1</span></li><li class="halim-episode halim-episode-2-tap-2"><span data-href="/xem-phim-to-chuc-rugal/tap-2-sv2.html" class="clickable halim-info-2-tap-2 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-2" data-position="" data-embed="0">2</span></li><li class="halim-episode halim-episode-2-tap-3"><span data-href="/xem-phim-to-chuc-rugal/tap-3-sv2.html" class="clickable halim-info-2-tap-3 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-3" data-position="" data-embed="0">3</span></li><li class="halim-episode halim-episode-2-tap-4"><span data-href="/xem-phim-to-chuc-rugal/tap-4-sv2.html" class="clickable halim-info-2-tap-4 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-4" data-position="" data-embed="0">4</span></li><li class="halim-episode halim-episode-2-tap-5"><span data-href="/xem-phim-to-chuc-rugal/tap-5-sv2.html" class="clickable halim-info-2-tap-5 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-5" data-position="" data-embed="0">5</span></li><li class="halim-episode halim-episode-2-tap-6"><span data-href="/xem-phim-to-chuc-rugal/tap-6-sv2.html" class="clickable halim-info-2-tap-6 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-6" data-position="" data-embed="0">6</span></li><li class="halim-episode halim-episode-2-tap-7"><span data-href="/xem-phim-to-chuc-rugal/tap-7-sv2.html" class="clickable halim-info-2-tap-7 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-7" data-position="" data-embed="0">7</span></li><li class="halim-episode halim-episode-2-tap-8"><span data-href="/xem-phim-to-chuc-rugal/tap-8-sv2.html" class="clickable halim-info-2-tap-8 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-8" data-position="" data-embed="0">8</span></li><li class="halim-episode halim-episode-2-tap-9"><span data-href="/xem-phim-to-chuc-rugal/tap-9-sv2.html" class="clickable halim-info-2-tap-9 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-9" data-position="" data-embed="0">9</span></li><li class="halim-episode halim-episode-2-tap-10"><span data-href="/xem-phim-to-chuc-rugal/tap-10-sv2.html" class="clickable halim-info-2-tap-10 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-10" data-position="" data-embed="0">10</span></li><li class="halim-episode halim-episode-2-tap-11"><span data-href="/xem-phim-to-chuc-rugal/tap-11-sv2.html" class="clickable halim-info-2-tap-11 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-11" data-position="" data-embed="0">11</span></li><li class="halim-episode halim-episode-2-tap-12"><span data-href="/xem-phim-to-chuc-rugal/tap-12-sv2.html" class="clickable halim-info-2-tap-12 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-12" data-position="" data-embed="0">12</span></li><li class="halim-episode halim-episode-2-tap-13"><span data-href="/xem-phim-to-chuc-rugal/tap-13-sv2.html" class="clickable halim-info-2-tap-13 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-13" data-position="" data-embed="0">13</span></li><li class="halim-episode halim-episode-2-tap-14"><span data-href="/xem-phim-to-chuc-rugal/tap-14-sv2.html" class="clickable halim-info-2-tap-14 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-14" data-position="" data-embed="0">14</span></li></ul><div class="clearfix"></div></div><div id="pagination-2"></div><div class="halim-server show_all_eps" data-episode-nav=""><span class="halim-server-name"><span class="hl-server"></span> Server VIP 2</span><ul id="listsv-3" class="halim-list-eps"><li class="halim-episode halim-episode-3-tap-1"><span data-href="/xem-phim-to-chuc-rugal/tap-1-sv3.html" class="clickable halim-info-3-tap-1 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-1" data-position="first" data-embed="0">1</span></li><li class="halim-episode halim-episode-3-tap-2"><span data-href="/xem-phim-to-chuc-rugal/tap-2-sv3.html" class="clickable halim-info-3-tap-2 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-2" data-position="" data-embed="0">2</span></li><li class="halim-episode halim-episode-3-tap-3"><span data-href="/xem-phim-to-chuc-rugal/tap-3-sv3.html" class="clickable halim-info-3-tap-3 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-3" data-position="" data-embed="0">3</span></li><li class="halim-episode halim-episode-3-tap-4"><span data-href="/xem-phim-to-chuc-rugal/tap-4-sv3.html" class="clickable halim-info-3-tap-4 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-4" data-position="" data-embed="0">4</span></li><li class="halim-episode halim-episode-3-tap-5"><span data-href="/xem-phim-to-chuc-rugal/tap-5-sv3.html" class="clickable halim-info-3-tap-5 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-5" data-position="" data-embed="0">5</span></li><li class="halim-episode halim-episode-3-tap-6"><span data-href="/xem-phim-to-chuc-rugal/tap-6-sv3.html" class="clickable halim-info-3-tap-6 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-6" data-position="" data-embed="0">6</span></li><li class="halim-episode halim-episode-3-tap-7"><span data-href="/xem-phim-to-chuc-rugal/tap-7-sv3.html" class="clickable halim-info-3-tap-7 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-7" data-position="" data-embed="0">7</span></li><li class="halim-episode halim-episode-3-tap-8"><span data-href="/xem-phim-to-chuc-rugal/tap-8-sv3.html" class="clickable halim-info-3-tap-8 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-8" data-position="" data-embed="0">8</span></li><li class="halim-episode halim-episode-3-tap-9"><span data-href="/xem-phim-to-chuc-rugal/tap-9-sv3.html" class="clickable halim-info-3-tap-9 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-9" data-position="" data-embed="0">9</span></li><li class="halim-episode halim-episode-3-tap-10"><span data-href="/xem-phim-to-chuc-rugal/tap-10-sv3.html" class="clickable halim-info-3-tap-10 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-10" data-position="" data-embed="0">10</span></li><li class="halim-episode halim-episode-3-tap-11"><span data-href="/xem-phim-to-chuc-rugal/tap-11-sv3.html" class="clickable halim-info-3-tap-11 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-11" data-position="" data-embed="0">11</span></li><li class="halim-episode halim-episode-3-tap-12"><span data-href="/xem-phim-to-chuc-rugal/tap-12-sv3.html" class="clickable halim-info-3-tap-12 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-12" data-position="" data-embed="0">12</span></li><li class="halim-episode halim-episode-3-tap-14"><span data-href="/xem-phim-to-chuc-rugal/tap-14-sv3.html" class="clickable halim-info-3-tap-14 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-14" data-position="" data-embed="0">14</span></li></ul><div class="clearfix"></div>
                        </div>
                        <div id="pagination-3"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="halim--notice">
                    <p><em>Nếu lần đầu không xem được phim, vui lòng nhấn tổ hợp phím Ctrl+F5 hoặc thử chọn server khác. Cảm ơn!</em>

                        Hãy <strong>đăng nhập</strong> để tự động ẩn hết tất cả các <strong>quảng cáo</strong>!</p>
                </div>

                <div class="entry-content htmlwrap clearfix">
                    <div class="video-item halim-entry-box">
                        <article id="post-14773" class="item-content">

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

                    <article class="thumb grid-item post-10849">
                        <div class="halim-item">
                            <a class="halim-thumb" href="/bay-nam-van-ngoanh-ve-phuong-bac" title="Bảy Năm Vẫn Ngoảnh Về Phương Bắc">

                                <figure><img class="lazyload blur-up img-responsive" data-sizes="auto" data-src="wp-content/uploads/2019/10/bay-nam-van-ngoanh-ve-phuong-bac-10849-thumbnail.jpg" alt="Bảy Năm Vẫn Ngoảnh Về Phương Bắc" title="Bảy Năm Vẫn Ngoảnh Về Phương Bắc"></figure>
                                <span class="status">FHD</span><span class="episode">Tập 37</span>
                                <div class="icon_overlay"                            data-html="true"
                                     data-toggle="halim-popover"
                                     data-placement="top"
                                     data-trigger="hover"
                                     title="<span class=film-title>Bảy Năm Vẫn Ngoảnh Về Phương Bắc</span>"
                                     data-content="<div class=org-title>Your Secret</div>                            <div class=film-meta>
                                <div class=text-center>
                                    <span class=released><i class=hl-calendar></i> 2019</span>                                                                    </div>
                                <div class=film-content>Phim được chuyển thể từ tiểu thuyết nổi tiếng: “7 năm vẫn ngoảnh về phương Bắc” - tác&amp;hellip;</div>
                                <p class=category>Quốc gia: <span class=category-name>Trung Quốc</span></p>                                <p class=category>Thể loại: <span class=category-name>Hành Động</span><span class=category-name>Tâm Lý</span></p>
                            </div>">
                                </div>

                                <div class="halim-post-title-box">
                                    <div class="halim-post-title ">
                                        <h2 class="entry-title">Bảy Năm Vẫn Ngoảnh Về Phương Bắc</h2><p class="original_title">Your Secret</p>                        </div>
                                </div>
                            </a>
                        </div>
                    </article>

                </div>
                <script>
                    jQuery(document).ready(function($) {
                        var owl = $('#halim_related_movies-2');
                        owl.owlCarousel({loop: true,margin: 4,autoplay: true,autoplayTimeout: 4000,autoplayHoverPause: true,nav: true,navText: ['<i class="hl-down-open rotate-left"></i>', '<i class="hl-down-open rotate-right"></i>'],responsiveClass: true,responsive: {0: {items:2},480: {items:3}, 600: {items:4},1000: {items: 4}}})});
                </script>
            </div>
        </section>
        <div class="the_tag_list">

            <a href="/tag/ahihitv" title="ahihitv" rel="tag">ahihitv</a>
            <a href="/tag/anime47" title="anime47" rel="tag">anime47</a>

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
                    <div id="halim-ajax-popular-post" class="popular-post">


                        <div class="item post-14807">
                            <a href="/phap-su-mu-ai-chet-gio-tay-full" title="Pháp Sư Mù: Ai Chết Giơ Tay">
                                <div class="item-link">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="wp-content/uploads/2020/04/phap-su-mu-250x350.jpg" class="lazyload blur-up post-thumb" alt="Pháp Sư Mù: Ai Chết Giơ Tay" title="Pháp Sư Mù: Ai Chết Giơ Tay" />
                                </div>
                                <h3 class="title">Pháp Sư Mù: Ai Chết Giơ Tay</h3>
                            </a>
                            <div class="viewsCount">3K lượt xem</div>
                        </div>
                        <div class="item post-18510">
                            <a href="/365-ngay" title="365 Ngày">
                                <div class="item-link">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="wp-content/uploads/2020/06/365-ngay-18510-thumbnail.jpg" class="lazyload blur-up post-thumb" alt="365 Ngày" title="365 Ngày" />
                                </div>
                                <h3 class="title">365 Ngày</h3>
                                <p class="original_title">365 dni / 365 days</p>            </a>
                            <div class="viewsCount">3K lượt xem</div>
                        </div>
                        <div class="item post-13999">
                            <a href="/quen-em-khong-quen-tinh-ta" title="Quên Em Không Quên Tình Ta">
                                <div class="item-link">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="wp-content/uploads/2020/03/quen-em-khong-quen-tinh-ta-13999-thumbnail.jpg" class="lazyload blur-up post-thumb" alt="Quên Em Không Quên Tình Ta" title="Quên Em Không Quên Tình Ta" />
                                </div>
                                <h3 class="title">Quên Em Không Quên Tình Ta</h3>
                                <p class="original_title">Forget You Remember Love (2020)</p>            </a>
                            <div class="viewsCount">2.8K lượt xem</div>
                        </div>
                        <div class="item post-21352">
                            <a href="/hoi-ket-cua-sat-thu" title="Hồi Kết Của Sát Thủ">
                                <div class="item-link">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="wp-content/uploads/2020/06/hoi-ket-cua-sat-thu-21352-thumbnail.jpg" class="lazyload blur-up post-thumb" alt="Hồi Kết Của Sát Thủ" title="Hồi Kết Của Sát Thủ" />
                                </div>
                                <h3 class="title">Hồi Kết Của Sát Thủ</h3>
                                <p class="original_title">Sniper: Assassin&#039;s End</p>            </a>
                            <div class="viewsCount">2.7K lượt xem</div>
                        </div>
                        <div class="item post-14605">
                            <a href="/vuong-trieu-duc-vong" title="Vương Triều Dục Vọng">
                                <div class="item-link">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="wp-content/uploads/2020/03/vuong-trieu-duc-vong-thumb.jpg" class="lazyload blur-up post-thumb" alt="Vương Triều Dục Vọng" title="Vương Triều Dục Vọng" />
                                </div>
                                <h3 class="title">Vương Triều Dục Vọng</h3>
                                <p class="original_title">The Treacherous </p>            </a>
                            <div class="viewsCount">2.6K lượt xem</div>
                        </div>
                        <div class="item post-11387">
                            <a href="/ban-chat-cua-lang-man" title="Bản Chất Của Lãng Mạn">
                                <div class="item-link">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="wp-content/uploads/2019/10/ban-chat-cua-lang-man-11387-thumbnail.jpg" class="lazyload blur-up post-thumb" alt="Bản Chất Của Lãng Mạn" title="Bản Chất Của Lãng Mạn" />
                                </div>
                                <h3 class="title">Bản Chất Của Lãng Mạn</h3>
                                <p class="original_title">Melloga Chejil / Be Melodramatic</p>            </a>
                            <div class="viewsCount">2.6K lượt xem</div>
                        </div>
                        <div class="item post-11253">
                            <a href="/chin-cay-so-tinh-yeu" title="Chín Cây Số Tình Yêu">
                                <div class="item-link">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="wp-content/uploads/2019/10/chin-cay-so-tinh-yeu-11253-thumbnail.jpg" class="lazyload blur-up post-thumb" alt="Chín Cây Số Tình Yêu" title="Chín Cây Số Tình Yêu" />
                                </div>
                                <h3 class="title">Chín Cây Số Tình Yêu</h3>
                                <p class="original_title">Nine Kilometers of Love</p>            </a>
                            <div class="viewsCount">2.5K lượt xem</div>
                        </div>
                        <div class="item post-12734">
                            <a href="/giai-ma-tinh-duc" title="Giải Mã Tình Dục">
                                <div class="item-link">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="wp-content/uploads/2020/01/giai-ma-tinh-duc-12734-thumbnail.jpg" class="lazyload blur-up post-thumb" alt="Giải Mã Tình Dục" title="Giải Mã Tình Dục" />
                                </div>
                                <h3 class="title">Giải Mã Tình Dục</h3>
                                <p class="original_title">Sex, Explained</p>            </a>
                            <div class="viewsCount">2.5K lượt xem</div>
                        </div>
                        <div class="item post-10455">
                            <a href="/co-nang-cao-keu" title="Cô Nàng Cao Kều">
                                <div class="item-link">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="wp-content/uploads/2019/09/co-nang-cao-keu-10455-thumbnail.jpg" class="lazyload blur-up post-thumb" alt="Cô Nàng Cao Kều" title="Cô Nàng Cao Kều" />
                                </div>
                                <h3 class="title">Cô Nàng Cao Kều</h3>
                                <p class="original_title">Tall Girl</p>            </a>
                            <div class="viewsCount">2.5K lượt xem</div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="clearfix"></div>
        </div>
    </aside>
</div>

@endsection