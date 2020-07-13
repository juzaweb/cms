@extends('layouts.frontend')

@section('content')
<div class="row container" id="wrapper">
    <div class="halim-panel-filter">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-8 hidden-xs">
                    <div class="yoast_breadcrumb">
                        <span>
                            <span>
                                <a href="/">Trang chủ</a> » <span>
                                    <a href="/hanh-dong/">Hành Động</a> »
                                    <span class="breadcrumb_last" aria-current="page">Tổ Chức Rugal</span>
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
                <script>var halim_cfg = {"act":"watch","post_url":"http:\/\/xemphimplus.net\/xem-phim-to-chuc-rugal","ajax_url":"http:\/\/xemphimplus.net\/wp-content\/themes\/halimmovies\/halim-ajax.php","player_url":"http:\/\/xemphimplus.net\/wp-content\/themes\/halimmovies\/player.php","loading_img":"http:\/\/xemphimplus.net\/wp-content\/themes\/halimmovies\/assets\/images\/ajax-loader.gif","eps_slug":"tap","server_slug":"s","type_slug":"slug-2","post_title":"Tổ Chức Rugal","post_id":14773,"episode_slug":"tap-1","server":"1","player_error_detect":"display_modal","paging_episode":"false","episode_display":"show_list_eps","episode_nav_num":100,"auto_reset_cache":true,"resume_playback":true,"resume_text":"Tự động phát lại phim từ thời điểm bạn xem gần đây nhất tại","resume_text_2":"Phát lại từ đầu?","playback":"Phát lại","continue_watching":"Xem tiếp","player_reload":"Tải lại trình phát","jw_error_msg_0":"Chúng tôi không thể tìm thấy video bạn đang tìm kiếm. Có thể có một số lý do cho việc này, ví dụ như nó đã bị xóa bởi chủ sở hữu!","jw_error_msg_1":"Video lỗi không thể phát được.","jw_error_msg_2":"Để xem tiếp, vui lòng click vào nút \"Tải lại trình phát\"","jw_error_msg_3":"hoặc click vào các nút được liệt kê bên dưới","light_on":"Bật đèn","light_off":"Tắt đèn","expand":"Phóng to","collapse":"Thu nhỏ","player_loading":"Đang khởi tạo trình phát, vui lòng chờ...","player_autonext":"Đang tự động chuyển tập, vui lòng chờ...","is_adult":false,"adult_title":"Adult Content Warning!","adult_content":"<span style=\"vertical-align: inherit;\"><span style=\"vertical-align: inherit;\">Trang web này chứa nội dung dành cho các cá nhân từ 18\/21 tuổi trở lên được xác định theo luật pháp địa phương và quốc gia của khu vực nơi bạn cư trú. <\/span><span style=\"vertical-align: inherit;\">Nếu bạn chưa đủ 18 tuổi, hãy rời khỏi trang web này ngay lập tức. <\/span><span style=\"vertical-align: inherit;\">Khi vào trang web này, bạn đồng ý rằng bạn từ 18 tuổi trở lên. <\/span><span style=\"vertical-align: inherit;\">Bạn sẽ không phân phối lại tài liệu này cho bất kỳ ai, và bạn cũng sẽ không cho phép bất kỳ trẻ vị thành niên nào xem tài liệu này.<\/span><\/span>","show_only_once":"Không hiển thị lại","exit_btn":"THOÁT","is_18plus":"TÔI ĐỦ 18 TUỔI","report_lng":{"title":"Tổ Chức Rugal","alert":"Tên (email) và nội dung là bắt buộc","msg":"Nội dung","msg_success":"Cảm ơn bạn đã gửi thông báo lỗi. Chúng tôi sẽ tiến hành sửa lỗi sớm nhất có thể","loading_img":"http:\/\/xemphimplus.net\/wp-content\/plugins\/halim-movie-report\/loading.gif","report_btn":"Báo lỗi","name_or_email":"Tên hoặc Email","close":"Đóng"}}</script>
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
                        <li class="fb-like" data-href="/to-chuc-rugal/" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></li>
                    </ul>
                    <ul class="col-xs-12 col-md-8">
                        <div id="autonext" class="btn-cs autonext">
                            <i class="icon-autonext-sm"></i>
                            <span><i class="hl-next"></i> Autoplay next episode: <span id="autonext-status">On</span></span>
                        </div>

                        <div id="explayer" class="hidden-xs">
                            <i class="hl-resize-full"></i>
                            Phóng to
                        </div>

                        <div id="toggle-light"><i class="hl-adjust"></i>
                            Tắt đèn
                        </div>

                        <div id="report" class="halim-switch">
                            <i class="hl-attention"></i> Báo lỗi
                        </div>

                        <div class="luotxem"><i class="hl-eye"></i>
                            <span>249.9K</span> lượt xem
                        </div>

                        <div class="luotxem visible-xs-inline">
                            <a data-toggle="collapse" href="#moretool" aria-expanded="false" aria-controls="moretool"><i class="hl-forward"></i> Chia sẻ</a>
                        </div>

                    </ul>
                </div>

                <div class="collapse" id="moretool">
                    <ul class="nav nav-pills x-nav-justified">
                        <li class="fb-like" data-href="/to-chuc-rugal/" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></li>
                        <div class="fb-save" data-uri="/to-chuc-rugal/" data-size="small"></div>
                    </ul>
                </div>

                <div class="clearfix"></div>
                <div class="text-center">			<div class="textwidget"><p style="color: yellow;border: 1px solid;padding: 5px;">Hãy <strong>Đăng Nhập</strong> ẩn hết <strong>&nbsp;Quảng Cáo</strong>!</p>
                    </div>
                </div><div class="text-center">			<div class="textwidget">
                        <style type="text/css">
                            #main-contents{position:relative;}
                            .float-left{position:absolute;left:-130px;top:0;}
                            .float-right{position:absolute;right:-460px;top:0;}
                        </style>

                    </div>
                </div>        <div class="clearfix"></div>

                <div class="title-block watch-page">
                    <a href="javascript:;" data-toggle="tooltip" title="Thêm vào tủ phim">
                        <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-post_id="14773" data-thumbnail="/wp-content/uploads/2020/04/to-chuc-rugal-14773-thumbnail.jpg" data-href="/to-chuc-rugal" data-title="Tổ Chức Rugal" data-date="2020-04-04">
                            <!-- <div class="halim-pulse-ring"></div> -->
                        </div>
                    </a>
                    <div class="title-wrapper full">
                        <h1 class="entry-title"><a href="/to-chuc-rugal" title="Xem phim Tổ Chức Rugal Tập 1 Full [Vietsub + Thuyết minh]" class="tl">Xem phim Tổ Chức Rugal Tập 1 Full [Vietsub + Thuyết minh]</a></h1>
                        <span class="plot-collapse" data-toggle="collapse" data-target="#expand-post-content" aria-expanded="false" aria-controls="expand-post-content" data-text="Nội dung phim"><i class="hl-angle-down"></i></span>
                    </div>

                    <div class="ratings_wrapper">
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

                </div>

                <div class="entry-content htmlwrap clearfix collapse" id="expand-post-content">
                    <article id="post-14773" class="item-content post-14773">
                        <p><a href="/to-chuc-rugal"><strong>Tổ Chức Rugal</strong></a> xoay quanh Kang Ki Bum (Choi Jin Hyuk), vốn là một cảnh sát giỏi nhưng trong khi đang điều tra về tổ chức Argos thì bị người của Argos tìm đến tiêu diệt. Cả vợ và con anh đều bị sát hại, còn anh thì bị làm cho mù mắt. Khi tỉnh lại, Ki Bum bị buộc tội giết chính vợ con mình. Trong tình thế tuyệt vọng, NIS tìm đến Ki Bum và kết nạp anh vào đội Rugal - một nhóm người đặc biệt lãnh nhiệm vụ đánh sập tổ chức tội phạm</p>
                        <h2>Xem Phim Tổ Chức Rugal Vietsub mới nhất</h2>
                        <p><img class="aligncenter size-full wp-image-15462" src="wp-content/uploads/2020/04/rugal.gif" alt="" width="1170" height="400" /></p>
                        <p>Là Dự án hành động máu lửa thảng hoặc hoi ra mắt giữa bão dịch, Rugal (tổ chức Rugal) của đài cáp toàn siêu phẩm "nặng đô" OCN lôi kéo ngay trong khoảng phút đầu nhá hàng, mang màn song kiếm hợp bích của hai "chú đại" Park Sung Woong và Choi Jin Hyuk. khởi động 2 tập đầu có mức rating trợ thì ổn, đạt 3.8%, Rugal đã thành công thu hút sự chú ý của các fan cứng đam mê phim hành động, đính kèm "drama" báo thù như Vagabond (Lãng Khách) dịp cuối năm 2019. Thế nhưng, gây chú ý với những phân đoạn bạo lực được đính mác "Rated 18+" trên Netflix như vậy, Rugal có thực làm người xem trằm trồ mang các gì đã diễn ra trong hai tập trước nhất?</p>
                        <p>Chưa cần bàn đến bất cứ nhân tố nào khác, Rugal đã "ăn điểm" ngay tức khắc mang hội mọt phim Hàn với phần ưu ái mức bạo lực "nặng đô" thi thoảng gặp trên màn ảnh nhỏ. hai tay che mắt, người co rúm đến việc phải bịt mồm vì chứng kiến sự đẫm máu, chân thực đến hoảng hồn của hai tập đầu Rugal chính là các gì rất nhiều người xem sẽ phải trải qua.</p>
                        <p>Trong khi nam chính Kang Gi Bum (Choi Jin Hyuk) bị phe phản diện chọc mù 2 mắt bằng dao, chịu đòn như 1 bài luyện tập thể lực tại doanh nghiệp đến cận cảnh các con phố đạn xuyên đầu cảnh sát, Rugal đã đích thực nâng tầm độ bạo lực của phim hành động Hàn lúc phát sóng trên TV. nếu như là 1 khán fake yếu tim và "sợ đau" lẫn máu, Rugal không hề là một Dự án dành cho bạn.</p>
                    </article>
                </div>
                <div class="clearfix"></div>
                <div class="text-center halim-ajax-list-server"><div id="halim-ajax-list-server"><script>var svlists = [];</script></div></div><div id="halim-list-server" class="list-eps-ajax"><div class="halim-server show_all_eps" data-episode-nav=""><span class="halim-server-name"><span class="hl-server"></span> Server HD</span><ul id="listsv-1" class="halim-list-eps"><li class="active halim-episode halim-episode-1-tap-1"><a href="/xem-phim-to-chuc-rugal/tap-1-sv1.html" title="1"><span class="active halim-info-1-tap-1 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-1" data-position="first" data-embed="0">1</span></a></li><li class="halim-episode halim-episode-1-tap-2"><a href="/xem-phim-to-chuc-rugal/tap-2-sv1.html" title="2"><span class="halim-info-1-tap-2 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-2" data-position="" data-embed="0">2</span></a></li><li class="halim-episode halim-episode-1-tap-3"><a href="/xem-phim-to-chuc-rugal/tap-3-sv1.html" title="3"><span class="halim-info-1-tap-3 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-3" data-position="" data-embed="0">3</span></a></li><li class="halim-episode halim-episode-1-tap-4"><a href="/xem-phim-to-chuc-rugal/tap-4-sv1.html" title="4"><span class="halim-info-1-tap-4 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-4" data-position="" data-embed="0">4</span></a></li><li class="halim-episode halim-episode-1-tap-5"><a href="/xem-phim-to-chuc-rugal/tap-5-sv1.html" title="5"><span class="halim-info-1-tap-5 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-5" data-position="" data-embed="0">5</span></a></li><li class="halim-episode halim-episode-1-tap-6"><a href="/xem-phim-to-chuc-rugal/tap-6-sv1.html" title="6"><span class="halim-info-1-tap-6 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-6" data-position="" data-embed="0">6</span></a></li><li class="halim-episode halim-episode-1-tap-7"><a href="/xem-phim-to-chuc-rugal/tap-7-sv1.html" title="7"><span class="halim-info-1-tap-7 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-7" data-position="" data-embed="0">7</span></a></li><li class="halim-episode halim-episode-1-tap-8"><a href="/xem-phim-to-chuc-rugal/tap-8-sv1.html" title="8"><span class="halim-info-1-tap-8 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-8" data-position="" data-embed="0">8</span></a></li><li class="halim-episode halim-episode-1-tap-9"><a href="/xem-phim-to-chuc-rugal/tap-9-sv1.html" title="9"><span class="halim-info-1-tap-9 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-9" data-position="" data-embed="0">9</span></a></li><li class="halim-episode halim-episode-1-tap-10"><a href="/xem-phim-to-chuc-rugal/tap-10-sv1.html" title="10"><span class="halim-info-1-tap-10 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-10" data-position="" data-embed="0">10</span></a></li><li class="halim-episode halim-episode-1-tap-11"><a href="/xem-phim-to-chuc-rugal/tap-11-sv1.html" title="11"><span class="halim-info-1-tap-11 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-11" data-position="" data-embed="0">11</span></a></li><li class="halim-episode halim-episode-1-tap-12"><a href="/xem-phim-to-chuc-rugal/tap-12-sv1.html" title="12"><span class="halim-info-1-tap-12 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-12" data-position="" data-embed="0">12</span></a></li><li class="halim-episode halim-episode-1-tap-13"><a href="/xem-phim-to-chuc-rugal/tap-13-sv1.html" title="13"><span class="halim-info-1-tap-13 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-13" data-position="" data-embed="0">13</span></a></li><li class="halim-episode halim-episode-1-tap-14"><a href="/xem-phim-to-chuc-rugal/tap-14-sv1.html" title="14"><span class="halim-info-1-tap-14 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-14" data-position="" data-embed="0">14</span></a></li><li class="halim-episode halim-episode-1-tap-15"><a href="/xem-phim-to-chuc-rugal/tap-15-sv1.html" title="15"><span class="halim-info-1-tap-15 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-15" data-position="" data-embed="0">15</span></a></li><li class="halim-episode halim-episode-1-tap-16"><a href="/xem-phim-to-chuc-rugal/tap-16-sv1.html" title="16"><span class="halim-info-1-tap-16 box-shadow halim-btn" data-post-id="14773" data-server="1"  data-episode-slug="tap-16" data-position="last" data-embed="0">16</span></a></li></ul><div class="clearfix"></div></div><div id="pagination-1"></div><div class="halim-server show_all_eps" data-episode-nav=""><span class="halim-server-name"><span class="hl-server"></span> Server VIP</span><ul id="listsv-2" class="halim-list-eps"><li class="halim-episode halim-episode-2-tap-1"><span data-href="/xem-phim-to-chuc-rugal/tap-1-sv2.html" class="clickable halim-info-2-tap-1 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-1" data-position="first" data-embed="0">1</span></li><li class="halim-episode halim-episode-2-tap-2"><span data-href="/xem-phim-to-chuc-rugal/tap-2-sv2.html" class="clickable halim-info-2-tap-2 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-2" data-position="" data-embed="0">2</span></li><li class="halim-episode halim-episode-2-tap-3"><span data-href="/xem-phim-to-chuc-rugal/tap-3-sv2.html" class="clickable halim-info-2-tap-3 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-3" data-position="" data-embed="0">3</span></li><li class="halim-episode halim-episode-2-tap-4"><span data-href="/xem-phim-to-chuc-rugal/tap-4-sv2.html" class="clickable halim-info-2-tap-4 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-4" data-position="" data-embed="0">4</span></li><li class="halim-episode halim-episode-2-tap-5"><span data-href="/xem-phim-to-chuc-rugal/tap-5-sv2.html" class="clickable halim-info-2-tap-5 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-5" data-position="" data-embed="0">5</span></li><li class="halim-episode halim-episode-2-tap-6"><span data-href="/xem-phim-to-chuc-rugal/tap-6-sv2.html" class="clickable halim-info-2-tap-6 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-6" data-position="" data-embed="0">6</span></li><li class="halim-episode halim-episode-2-tap-7"><span data-href="/xem-phim-to-chuc-rugal/tap-7-sv2.html" class="clickable halim-info-2-tap-7 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-7" data-position="" data-embed="0">7</span></li><li class="halim-episode halim-episode-2-tap-8"><span data-href="/xem-phim-to-chuc-rugal/tap-8-sv2.html" class="clickable halim-info-2-tap-8 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-8" data-position="" data-embed="0">8</span></li><li class="halim-episode halim-episode-2-tap-9"><span data-href="/xem-phim-to-chuc-rugal/tap-9-sv2.html" class="clickable halim-info-2-tap-9 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-9" data-position="" data-embed="0">9</span></li><li class="halim-episode halim-episode-2-tap-10"><span data-href="/xem-phim-to-chuc-rugal/tap-10-sv2.html" class="clickable halim-info-2-tap-10 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-10" data-position="" data-embed="0">10</span></li><li class="halim-episode halim-episode-2-tap-11"><span data-href="/xem-phim-to-chuc-rugal/tap-11-sv2.html" class="clickable halim-info-2-tap-11 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-11" data-position="" data-embed="0">11</span></li><li class="halim-episode halim-episode-2-tap-12"><span data-href="/xem-phim-to-chuc-rugal/tap-12-sv2.html" class="clickable halim-info-2-tap-12 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-12" data-position="" data-embed="0">12</span></li><li class="halim-episode halim-episode-2-tap-13"><span data-href="/xem-phim-to-chuc-rugal/tap-13-sv2.html" class="clickable halim-info-2-tap-13 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-13" data-position="" data-embed="0">13</span></li><li class="halim-episode halim-episode-2-tap-14"><span data-href="/xem-phim-to-chuc-rugal/tap-14-sv2.html" class="clickable halim-info-2-tap-14 box-shadow halim-btn" data-post-id="14773" data-server="2" data-episode-slug="tap-14" data-position="" data-embed="0">14</span></li></ul><div class="clearfix"></div></div><div id="pagination-2"></div><div class="halim-server show_all_eps" data-episode-nav=""><span class="halim-server-name"><span class="hl-server"></span> Server VIP 2</span><ul id="listsv-3" class="halim-list-eps"><li class="halim-episode halim-episode-3-tap-1"><span data-href="/xem-phim-to-chuc-rugal/tap-1-sv3.html" class="clickable halim-info-3-tap-1 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-1" data-position="first" data-embed="0">1</span></li><li class="halim-episode halim-episode-3-tap-2"><span data-href="/xem-phim-to-chuc-rugal/tap-2-sv3.html" class="clickable halim-info-3-tap-2 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-2" data-position="" data-embed="0">2</span></li><li class="halim-episode halim-episode-3-tap-3"><span data-href="/xem-phim-to-chuc-rugal/tap-3-sv3.html" class="clickable halim-info-3-tap-3 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-3" data-position="" data-embed="0">3</span></li><li class="halim-episode halim-episode-3-tap-4"><span data-href="/xem-phim-to-chuc-rugal/tap-4-sv3.html" class="clickable halim-info-3-tap-4 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-4" data-position="" data-embed="0">4</span></li><li class="halim-episode halim-episode-3-tap-5"><span data-href="/xem-phim-to-chuc-rugal/tap-5-sv3.html" class="clickable halim-info-3-tap-5 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-5" data-position="" data-embed="0">5</span></li><li class="halim-episode halim-episode-3-tap-6"><span data-href="/xem-phim-to-chuc-rugal/tap-6-sv3.html" class="clickable halim-info-3-tap-6 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-6" data-position="" data-embed="0">6</span></li><li class="halim-episode halim-episode-3-tap-7"><span data-href="/xem-phim-to-chuc-rugal/tap-7-sv3.html" class="clickable halim-info-3-tap-7 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-7" data-position="" data-embed="0">7</span></li><li class="halim-episode halim-episode-3-tap-8"><span data-href="/xem-phim-to-chuc-rugal/tap-8-sv3.html" class="clickable halim-info-3-tap-8 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-8" data-position="" data-embed="0">8</span></li><li class="halim-episode halim-episode-3-tap-9"><span data-href="/xem-phim-to-chuc-rugal/tap-9-sv3.html" class="clickable halim-info-3-tap-9 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-9" data-position="" data-embed="0">9</span></li><li class="halim-episode halim-episode-3-tap-10"><span data-href="/xem-phim-to-chuc-rugal/tap-10-sv3.html" class="clickable halim-info-3-tap-10 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-10" data-position="" data-embed="0">10</span></li><li class="halim-episode halim-episode-3-tap-11"><span data-href="/xem-phim-to-chuc-rugal/tap-11-sv3.html" class="clickable halim-info-3-tap-11 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-11" data-position="" data-embed="0">11</span></li><li class="halim-episode halim-episode-3-tap-12"><span data-href="/xem-phim-to-chuc-rugal/tap-12-sv3.html" class="clickable halim-info-3-tap-12 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-12" data-position="" data-embed="0">12</span></li><li class="halim-episode halim-episode-3-tap-14"><span data-href="/xem-phim-to-chuc-rugal/tap-14-sv3.html" class="clickable halim-info-3-tap-14 box-shadow halim-btn" data-post-id="14773" data-server="3" data-episode-slug="tap-14" data-position="" data-embed="0">14</span></li></ul><div class="clearfix"></div></div><div id="pagination-3"></div></div>        <div class="clearfix"></div>
                <div class="htmlwrap clearfix">
                    <div class="fb-comments"  data-href="/to-chuc-rugal/" data-width="100%" data-mobile="true" data-colorscheme="dark" data-numposts="5" data-order-by="reverse_time"></div>
                </div>
                <div id="lightout"></div>

            </div>
        </section>

        <section class="related-movies">

            <div id="halim_related_movies-2xx" class="wrap-slider">
                <div class="section-bar clearfix">
                    <h3 class="section-title"><span>CÓ THỂ BẠN MUỐN XEM?</span></h3>
                </div>
                <div id="halim_related_movies-2" class="owl-carousel owl-theme related-film">
                    <article class="thumb grid-item post-11458">
                        <div class="halim-item">
                            <a class="halim-thumb" href="/tiem-ao-cuoi-nhu-y" title="Tiệm Áo Cưới Như Ý">
                                <figure><img class="lazyload blur-up img-responsive" data-sizes="auto" data-src="wp-content/uploads/2019/10/tiem-ao-cuoi-nhu-y-11458-thumbnail.jpg" alt="Tiệm Áo Cưới Như Ý" title="Tiệm Áo Cưới Như Ý"></figure>
                                <span class="status">HD</span><span class="episode">Tập 4</span>
                                <div class="icon_overlay"                            data-html="true"
                                     data-toggle="halim-popover"
                                     data-placement="top"
                                     data-trigger="hover"
                                     title="<span class=film-title>Tiệm Áo Cưới Như Ý</span>"
                                     data-content="<div class=org-title>High-end Wedding Studio</div>                            <div class=film-meta>
                            <div class=text-center>
                                <span class=released><i class=hl-calendar></i> 2019</span>                                                                    </div>
                            <div class=film-content>A Cửu - chủ tiệm áo cưới, luôn thể hiện gương mặt lạnh lùng, không đoái hoài tới&amp;hellip;</div>
                            <p class=category>Quốc gia: <span class=category-name>Trung Quốc</span></p>                                <p class=category>Thể loại: <span class=category-name>Tâm Lý</span><span class=category-name>Tình Cảm</span></p>
                        </div>">
                                </div>

                                <div class="halim-post-title-box">
                                    <div class="halim-post-title ">
                                        <h2 class="entry-title">Tiệm Áo Cưới Như Ý</h2><p class="original_title">High-end Wedding Studio</p>                        </div>
                                </div>
                            </a>
                        </div>
                    </article>
                    <article class="thumb grid-item post-3840">
                        <div class="halim-item">
                            <a class="halim-thumb" href="/giang-long-bach-lo-vi-suong-2018" title="Giáng Long Bạch Lộ Vi Sương (2018)">
                                <figure><img class="lazyload blur-up img-responsive" data-sizes="auto" data-src="wp-content/uploads/2019/05/giang-long-bach-lo-vi-suong-2018-3840-thumbnail.jpg" alt="Giáng Long Bạch Lộ Vi Sương (2018)" title="Giáng Long Bạch Lộ Vi Sương (2018)"></figure>
                                <span class="status">HD</span><span class="episode">Tập 10</span>
                                <div class="icon_overlay"                            data-html="true"
                                     data-toggle="halim-popover"
                                     data-placement="top"
                                     data-trigger="hover"
                                     title="<span class=film-title>Giáng Long Bạch Lộ Vi Sương (2018)</span>"
                                     data-content="                            <div class=film-meta>
                            <div class=text-center>
                                <span class=released><i class=hl-calendar></i> 2018</span>                                                                    </div>
                            <div class=film-content>Giáng Long Bạch Lộ Vi Sương kể về những năm đầu thời dân quốc, con trai của Bạch&amp;hellip;</div>
                            <p class=category>Quốc gia: <span class=category-name>Trung Quốc</span></p>                                <p class=category>Thể loại: <span class=category-name>Tâm Lý</span><span class=category-name>Tình Cảm</span></p>
                        </div>">
                                </div>

                                <div class="halim-post-title-box">
                                    <div class="halim-post-title title-2-line">
                                        <h2 class="entry-title">Giáng Long Bạch Lộ Vi Sương (2018)</h2>                        </div>
                                </div>
                            </a>
                        </div>
                    </article>
                    <article class="thumb grid-item post-2838">
                        <div class="halim-item">
                            <a class="halim-thumb" href="/ve-si-phan-1" title="Vệ Sĩ (Phần 1)">
                                <figure><img class="lazyload blur-up img-responsive" data-sizes="auto" data-src="wp-content/uploads/2019/05/ve-si-phan-1-2838-thumbnail.jpg" alt="Vệ Sĩ (Phần 1)" title="Vệ Sĩ (Phần 1)"></figure>
                                <span class="status">HD</span><span class="episode">Tập 6</span>
                                <div class="icon_overlay"                            data-html="true"
                                     data-toggle="halim-popover"
                                     data-placement="top"
                                     data-trigger="hover"
                                     title="<span class=film-title>Vệ Sĩ (Phần 1)</span>"
                                     data-content="<div class=org-title>Bodyguard (Season 1)</div>                            <div class=film-meta>
                            <div class=text-center>
                                <span class=released><i class=hl-calendar></i> 2018</span>                                                                    </div>
                            <div class=film-content>Bodyguard xoay quanh nhân vật Trung sĩ Cảnh sát David Budd - một cựu chiến binh trong chiến&amp;hellip;</div>
                            <p class=category>Quốc gia: <span class=category-name>Mỹ</span></p>                                <p class=category>Thể loại: <span class=category-name>Hành Động</span><span class=category-name>Kịch Tính</span></p>
                        </div>">
                                </div>

                                <div class="halim-post-title-box">
                                    <div class="halim-post-title ">
                                        <h2 class="entry-title">Vệ Sĩ (Phần 1)</h2><p class="original_title">Bodyguard (Season 1)</p>                        </div>
                                </div>
                            </a>
                        </div>
                    </article>
                    <article class="thumb grid-item post-7081">
                        <div class="halim-item">
                            <a class="halim-thumb" href="/sabrina-co-phu-thuy-nho-phan-2" title="Sabrina Cô Phù Thủy Nhỏ - Phần 2">
                                <figure><img class="lazyload blur-up img-responsive" data-sizes="auto" data-src="wp-content/uploads/2019/05/sabrina-co-phu-thuy-nho-phan-2-7081-thumbnail.jpg" alt="Sabrina Cô Phù Thủy Nhỏ - Phần 2" title="Sabrina Cô Phù Thủy Nhỏ - Phần 2"></figure>
                                <span class="status">SD</span><span class="episode">Tập 21</span>
                                <div class="icon_overlay"                            data-html="true"
                                     data-toggle="halim-popover"
                                     data-placement="top"
                                     data-trigger="hover"
                                     title="<span class=film-title>Sabrina Cô Phù Thủy Nhỏ - Phần 2</span>"
                                     data-content="<div class=org-title>Sabrina, the Teenage Witch - Season 2</div>                            <div class=film-meta>
                            <div class=text-center>
                                <span class=released><i class=hl-calendar></i> 2003</span>                                                                    </div>
                            <div class=film-content>Sabrina Spellman, là một phù thủy tuổi thiếu niên. Vào lần sinh nhật lần thứ 16 của mình,&amp;hellip;</div>
                            <p class=category>Quốc gia: <span class=category-name>Mỹ</span></p>                                <p class=category>Thể loại: <span class=category-name>Gia Đình</span><span class=category-name>Hài Hước</span><span class=category-name>Viễn Tưỏng</span></p>
                        </div>">
                                </div>

                                <div class="halim-post-title-box">
                                    <div class="halim-post-title ">
                                        <h2 class="entry-title">Sabrina Cô Phù Thủy Nhỏ - Phần 2</h2><p class="original_title">Sabrina, the Teenage Witch - Season 2</p>                        </div>
                                </div>
                            </a>
                        </div>
                    </article>
                    <article class="thumb grid-item post-2739">
                        <div class="halim-item">
                            <a class="halim-thumb" href="/con-tau-dinh-menh-5" title="Con Tàu Định Mệnh 5">
                                <figure><img class="lazyload blur-up img-responsive" data-sizes="auto" data-src="wp-content/uploads/2019/05/con-tau-dinh-menh-5-2739-thumbnail.jpg" alt="Con Tàu Định Mệnh 5" title="Con Tàu Định Mệnh 5"></figure>
                                <span class="status">HD</span><span class="episode">Tập 10</span>
                                <div class="icon_overlay"                            data-html="true"
                                     data-toggle="halim-popover"
                                     data-placement="top"
                                     data-trigger="hover"
                                     title="<span class=film-title>Con Tàu Định Mệnh 5</span>"
                                     data-content="                            <div class=film-meta>
                            <div class=text-center>
                                <span class=released><i class=hl-calendar></i> 2018</span>                                                                    </div>
                            <div class=film-content>Trong phim Con Tàu Định Mệnh 5, các thành viên của đoàn hải quân trên 1 con tàu&amp;hellip;</div>
                            <p class=category>Quốc gia: <span class=category-name>Mỹ</span></p>                                <p class=category>Thể loại: <span class=category-name>Chiến Tranh</span><span class=category-name>Hành Động</span><span class=category-name>Kinh Dị</span><span class=category-name>Tâm Lý</span><span class=category-name>Viễn Tưỏng</span></p>
                        </div>">
                                </div>

                                <div class="halim-post-title-box">
                                    <div class="halim-post-title title-2-line">
                                        <h2 class="entry-title">Con Tàu Định Mệnh 5</h2>                        </div>
                                </div>
                            </a>
                        </div>
                    </article>
                    <article class="thumb grid-item post-6106">
                        <div class="halim-item">
                            <a class="halim-thumb" href="/danh-sach-den-phan-6" title="Danh Sách Đen (Phần 6)">
                                <figure><img class="lazyload blur-up img-responsive" data-sizes="auto" data-src="wp-content/uploads/2019/05/danh-sach-den-phan-6-6106-thumbnail.jpg" alt="Danh Sách Đen (Phần 6)" title="Danh Sách Đen (Phần 6)"></figure>
                                <span class="status">HD</span><span class="episode">Tập 16</span>
                                <div class="icon_overlay"                            data-html="true"
                                     data-toggle="halim-popover"
                                     data-placement="top"
                                     data-trigger="hover"
                                     title="<span class=film-title>Danh Sách Đen (Phần 6)</span>"
                                     data-content="<div class=org-title>The Blacklist Season 6</div>                            <div class=film-meta>
                            <div class=text-center>
                                <span class=released><i class=hl-calendar></i> 2019</span>                                                                    </div>
                            <div class=film-content>Phim Danh Sách Đen 7 2018 nói về cựu đặc vụ của chính phủ Raymond &quot;Red&quot; Reddington (James Spader) là&amp;hellip;</div>
                            <p class=category>Quốc gia: <span class=category-name>Mỹ</span></p>                                <p class=category>Thể loại: <span class=category-name>Bí Ẩn</span><span class=category-name>Hình Sự</span><span class=category-name>Kinh Dị</span><span class=category-name>Tâm Lý</span></p>
                        </div>">
                                </div>

                                <div class="halim-post-title-box">
                                    <div class="halim-post-title ">
                                        <h2 class="entry-title">Danh Sách Đen (Phần 6)</h2><p class="original_title">The Blacklist Season 6</p>                        </div>
                                </div>
                            </a>
                        </div>
                    </article>
                    <article class="thumb grid-item post-6358">
                        <div class="halim-item">
                            <a class="halim-thumb" href="/how-i-met-your-mother-7" title="How I Met Your Mother 7">
                                <figure><img class="lazyload blur-up img-responsive" data-sizes="auto" data-src="wp-content/uploads/2019/05/how-i-met-your-mother-7-6358-thumbnail.jpg" alt="How I Met Your Mother 7" title="How I Met Your Mother 7"></figure>
                                <span class="status">HD</span><span class="episode">Tập 23</span>
                                <div class="icon_overlay"                            data-html="true"
                                     data-toggle="halim-popover"
                                     data-placement="top"
                                     data-trigger="hover"
                                     title="<span class=film-title>How I Met Your Mother 7</span>"
                                     data-content="<div class=org-title>How I Met Your Mother Season 7</div>                            <div class=film-meta>
                            <div class=text-center>
                                <span class=released><i class=hl-calendar></i> 2011</span>                                                                    </div>
                            <div class=film-content>Phim How I Met Your Mother 7 bắt đầu bằng việc quay lại quá khứ khi Ted đang giúp&amp;hellip;</div>
                            <p class=category>Quốc gia: <span class=category-name>Mỹ</span></p>                                <p class=category>Thể loại: <span class=category-name>Gia Đình</span><span class=category-name>Hài Hước</span><span class=category-name>Tâm Lý</span></p>
                        </div>">
                                </div>

                                <div class="halim-post-title-box">
                                    <div class="halim-post-title ">
                                        <h2 class="entry-title">How I Met Your Mother 7</h2><p class="original_title">How I Met Your Mother Season 7</p>                        </div>
                                </div>
                            </a>
                        </div>
                    </article>
                    <article class="thumb grid-item post-15520">
                        <div class="halim-item">
                            <a class="halim-thumb" href="/sat-thu-luoi-keo-phan-2" title="Sát Thủ Lưỡi Kéo (Phần 2)">
                                <figure><img class="lazyload blur-up img-responsive" data-sizes="auto" data-src="wp-content/uploads/2020/05/sat-thu-luoi-keo-phan-2-15520-thumbnail.jpg" alt="Sát Thủ Lưỡi Kéo (Phần 2)" title="Sát Thủ Lưỡi Kéo (Phần 2)"></figure>
                                <span class="status">FHD</span><span class="episode">Tập 10</span>
                                <div class="icon_overlay"                            data-html="true"
                                     data-toggle="halim-popover"
                                     data-placement="top"
                                     data-trigger="hover"
                                     title="<span class=film-title>Sát Thủ Lưỡi Kéo (Phần 2)</span>"
                                     data-content="<div class=org-title>Scissor Seven Season 2 / Killer Seven Season 2</div>                            <div class=film-meta>
                            <div class=text-center>
                                <span class=released><i class=hl-calendar></i> 2020</span>                                                                    </div>
                            <div class=film-content>Trong lúc tìm cách lấy lại kí ức, sát thủ vụng về chuyên dùng kéo kiêm thợ làm&amp;hellip;</div>
                            <p class=category>Quốc gia: <span class=category-name>Trung Quốc</span></p>                                <p class=category>Thể loại: <span class=category-name>Hài Hước</span><span class=category-name>Hành Động</span><span class=category-name>Hoạt Hình</span><span class=category-name>Võ Thuật</span></p>
                        </div>">
                                </div>

                                <div class="halim-post-title-box">
                                    <div class="halim-post-title ">
                                        <h2 class="entry-title">Sát Thủ Lưỡi Kéo (Phần 2)</h2><p class="original_title">Scissor Seven Season 2 / Killer Seven Season 2</p>                        </div>
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
        <div class="the_tag_list"><a href="/tag/ahihitv" title="ahihitv" rel="tag">ahihitv</a><a href="/tag/anime47" title="anime47" rel="tag">anime47</a><a href="/tag/animetvn" title="animetvn" rel="tag">animetvn</a><a href="/tag/animevsub" title="animevsub" rel="tag">animevsub</a><a href="/tag/banhtv" title="Banhtv - Xem phim online hay với chất lượng HD" rel="tag">Banhtv - Xem phim online hay với chất lượng HD</a><a href="/tag/banhtv-net" title="Banhtv.net" rel="tag">Banhtv.net</a><a href="/tag/bilutv-org" title="Bilutv.org" rel="tag">Bilutv.org</a><a href="/tag/biphim" title="biphim" rel="tag">biphim</a><a href="/tag/biphim-tv" title="biphim.tv" rel="tag">biphim.tv</a><a href="/tag/bomtantv-org" title="bomtantv.org" rel="tag">bomtantv.org</a><a href="/tag/bongngotv" title="bongngo.tv" rel="tag">bongngo.tv</a><a href="/tag/cliptv-vn" title="cliptv.vn" rel="tag">cliptv.vn</a><a href="/tag/dongphim" title="DongPhim - Trang phim hot nhất hiện nay" rel="tag">DongPhim - Trang phim hot nhất hiện nay</a><a href="/tag/fimfast" title="FimFast - Xem phim gì chẳng có" rel="tag">FimFast - Xem phim gì chẳng có</a><a href="/tag/fptplay" title="fptplay" rel="tag">fptplay</a><a href="/tag/galaxycine" title="galaxycine" rel="tag">galaxycine</a><a href="/tag/goldphim-com" title="goldphim.com" rel="tag">goldphim.com</a><a href="/tag/hatde-tv" title="hatde.tv" rel="tag">hatde.tv</a><a href="/tag/hayhaytv" title="hayhaytv" rel="tag">hayhaytv</a><a href="/tag/hdmoi" title="hdmoi" rel="tag">hdmoi</a><a href="/tag/hdo" title="HDO" rel="tag">HDO</a><a href="/tag/hdonline" title="HDOnline - Xem Phim HD Online chất lượng tốt nhất" rel="tag">HDOnline - Xem Phim HD Online chất lượng tốt nhất</a><a href="/tag/hdsieunhanh" title="hdsieunhanh" rel="tag">hdsieunhanh</a><a href="/tag/hdviet" title="HDViet - Sự trổi dậy của Phim Ảnh" rel="tag">HDViet - Sự trổi dậy của Phim Ảnh</a><a href="/tag/huphim-com" title="huphim.com" rel="tag">huphim.com</a><a href="/tag/imdb" title="imdb" rel="tag">imdb</a><a href="/tag/khoaitv" title="KhoaiTv - Thống Trị Tín Đồ Mê Phim" rel="tag">KhoaiTv - Thống Trị Tín Đồ Mê Phim</a><a href="/tag/khophimle" title="khophimle" rel="tag">khophimle</a><a href="/tag/khophimplus-com" title="khophimplus.com" rel="tag">khophimplus.com</a><a href="/tag/kphim" title="kphim" rel="tag">kphim</a><a href="/tag/kshowonline-com" title="kshowonline.com" rel="tag">kshowonline.com</a><a href="/tag/lotte-cinema" title="lotte cinema" rel="tag">lotte cinema</a><a href="/tag/luotphim" title="luotphim" rel="tag">luotphim</a><a href="/tag/lytaphim" title="lytaphim" rel="tag">lytaphim</a><a href="/tag/maxphim" title="maxphim" rel="tag">maxphim</a><a href="/tag/motphim" title="MotPhim - Tiểu Thuyết Của Những Cuốn Phim" rel="tag">MotPhim - Tiểu Thuyết Của Những Cuốn Phim</a><a href="/tag/netflix" title="netflix" rel="tag">netflix</a><a href="/tag/netphim" title="netphim" rel="tag">netphim</a><a href="/tag/netphim-tv" title="netphim.tv" rel="tag">netphim.tv</a><a href="/tag/omphim-com" title="omphim.com" rel="tag">omphim.com</a><a href="/tag/phim-hay-2020" title="Phim Hay 2020" rel="tag">Phim Hay 2020</a><a href="/tag/phim-moi-2020" title="Phim Mới 2020" rel="tag">Phim Mới 2020</a><a href="/tag/phimkeengvn" title="phim.keeng.vn" rel="tag">phim.keeng.vn</a><a href="/tag/phim-xemchua-tv" title="phim.xemchua.tv" rel="tag">phim.xemchua.tv</a><a href="/tag/phim14" title="phim14" rel="tag">phim14</a><a href="/tag/phim33-com" title="Phim33.com" rel="tag">Phim33.com</a><a href="/tag/phim3s" title="Phim3s - Xem phim3s online với chất lượng tốt nhất" rel="tag">Phim3s - Xem phim3s online với chất lượng tốt nhất</a><a href="/tag/phim4400" title="phim4400" rel="tag">phim4400</a><a href="/tag/phim4400-tv" title="phim4400.tv" rel="tag">phim4400.tv</a><a href="/tag/phimbathu-com" title="PhimBatHu - Xem Phim Online với tốc độ siêu nhanh" rel="tag">PhimBatHu - Xem Phim Online với tốc độ siêu nhanh</a><a href="/tag/phimhan-tv" title="phimhan.tv" rel="tag">phimhan.tv</a><a href="/tag/phimhay-co" title="phimhay.co" rel="tag">phimhay.co</a><a href="/tag/phimhdonline-tv" title="phimhdonline.tv" rel="tag">phimhdonline.tv</a><a href="/tag/phimhdonlinetv" title="phimhdonlinetv" rel="tag">phimhdonlinetv</a><a href="/tag/phimhot-org" title="PhimHot.Org" rel="tag">PhimHot.Org</a><a href="/tag/phimmoi" title="Phimmoi - Xem phim mới mang lại đột phá" rel="tag">Phimmoi - Xem phim mới mang lại đột phá</a><a href="/tag/phimnhanh" title="phimnhanh" rel="tag">phimnhanh</a><a href="/tag/phimonhay" title="phimonhay" rel="tag">phimonhay</a><a href="/tag/phimtructuyenhd" title="phimtructuyenhd" rel="tag">phimtructuyenhd</a><a href="/tag/phimvn2" title="Phimvn2" rel="tag">Phimvn2</a><a href="/tag/razorphim" title="razorphim" rel="tag">razorphim</a><a href="/tag/showphim" title="showphim" rel="tag">showphim</a><a href="/tag/sieuphim-tv" title="sieuphim.tv" rel="tag">sieuphim.tv</a><a href="/tag/thapden" title="thapden" rel="tag">thapden</a><a href="/tag/thegioiphimhd" title="thegioiphimhd" rel="tag">thegioiphimhd</a><a href="/tag/to-chuc-rugal" title="to chuc rugal" rel="tag">to chuc rugal</a><a href="/tag/to-chuc-rugal-tap-1" title="to chuc rugal tap 1" rel="tag">to chuc rugal tap 1</a><a href="/tag/topphimhd" title="topphimhd" rel="tag">topphimhd</a><a href="/tag/topphimmoi" title="topphimmoi" rel="tag">topphimmoi</a><a href="/tag/tvhay" title="TVHay - Xem Phim Giải Trí" rel="tag">TVHay - Xem Phim Giải Trí</a><a href="/tag/tvhay-org" title="tvhay.org" rel="tag">tvhay.org</a><a href="/tag/viethd-net" title="viethd.net" rel="tag">viethd.net</a><a href="/tag/vietsubhd-xyz" title="vietsubhd.xyz" rel="tag">vietsubhd.xyz</a><a href="/tag/vietsubtv" title="vietsubtv" rel="tag">vietsubtv</a><a href="/tag/vivo-vn" title="vivo.vn" rel="tag">vivo.vn</a><a href="/tag/vivuphim" title="Vivuphim - Xem phim vivu không sợ lag" rel="tag">Vivuphim - Xem phim vivu không sợ lag</a><a href="/tag/vkool" title="vkool" rel="tag">vkool</a><a href="/tag/vkool-net" title="vkool.net" rel="tag">vkool.net</a><a href="/tag/vtv16" title="Vtv16 - Chuyên Mục Phim Hấp Dẫn" rel="tag">Vtv16 - Chuyên Mục Phim Hấp Dẫn</a><a href="/tag/vtvgiaitri" title="vtvgiaitri" rel="tag">vtvgiaitri</a><a href="/tag/vtvgo" title="vtvgo" rel="tag">vtvgo</a><a href="/tag/vuighe" title="vuighe" rel="tag">vuighe</a><a href="/tag/vuighe-tv" title="vuighe.tv" rel="tag">vuighe.tv</a><a href="/tag/vungtv" title="VungTV - Kho Tàng Phim Ảnh" rel="tag">VungTV - Kho Tàng Phim Ảnh</a><a href="/tag/woohay" title="woohay" rel="tag">woohay</a><a href="/tag/xemphimplus" title="xemphimplus" rel="tag">xemphimplus</a><a href="/tag/xemphimso" title="xemphimso" rel="tag">xemphimso</a><a href="/tag/xemvtv" title="Xemvtv - Đừng Bỏ Lỡ Thời Gian Trống" rel="tag">Xemvtv - Đừng Bỏ Lỡ Thời Gian Trống</a><a href="/tag/yeuphim" title="yeuphim" rel="tag">yeuphim</a><a href="/tag/yeuphimmoi" title="YeuPhimMoi - Trọn Vẹn Thời Gian Cho Phim" rel="tag">YeuPhimMoi - Trọn Vẹn Thời Gian Cho Phim</a><a href="/tag/zingtv" title="ZingTv - Phim Online Hay Nhất Mọi Thời Đại" rel="tag">ZingTv - Phim Online Hay Nhất Mọi Thời Đại</a></div></main>
    <aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
        <div id="text-16" class="widget widget_text">			<div class="textwidget">
            </div>
        </div><div id="text-14" class="widget widget_text">			<div class="textwidget"><p><!-- Composite Start --></p>
                <div id="M496140ScriptRootC754608"></div>
                <p><script src="https://jsc.mgid.com/x/e/xemphimplus.net.754608.js" async>
                    </script><br />
                    <!-- Composite End --></p>
            </div>
        </div><div id="halim_tab_popular_videos-widget-5" class="widget halim_tab_popular_videos-widget">			<div class="section-bar clearfix">
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
                        <div class="item post-18066">
                            <a href="/lam-sao-boss-lai-lam-sao-nua" title="Làm Sao? Boss Lại Làm Sao Nữa">
                                <div class="item-link">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="wp-content/uploads/2020/06/lam-sao-boss-lai-lam-sao-nua-18066-thumbnail.jpg" class="lazyload blur-up post-thumb" alt="Làm Sao? Boss Lại Làm Sao Nữa" title="Làm Sao? Boss Lại Làm Sao Nữa" />
                                </div>
                                <h3 class="title">Làm Sao? Boss Lại Làm Sao Nữa</h3>
                                <p class="original_title">What If You&#039;re My Boss? (2020)</p>            </a>
                            <div class="viewsCount">3.2K lượt xem</div>
                        </div>
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