@extends('themes.mymo.layout')

@section('content')
    <div class="row container" id="wrapper">
        <div class="halim-panel-filter">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-8 hidden-xs">
                        XemPhimPlus | Phim Hay | Phim Mới
                    </div>
                    <div class="col-xs-4 text-right">
                        <a href="javascript:;" id="expand-ajax-filter">Lọc phim <i id="ajax-filter-icon"
                                                                                   class="hl-angle-down"></i></a>
                    </div>
                    <div id="alphabet-filter" style="float: right;display: inline-block;margin-right: 25px;"></div>
                </div>
            </div>
            <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                <div class="ajax"></div>
            </div>
        </div><!-- end panel-default -->

        <div class="col-xs-12 carausel-sliderWidget">
            <div id="halim-carousel-widget-3xx" class="wrap-slider">
                <div class="section-bar clearfix">
                    <h3 class="section-title"><span>Phim đề cử</span></h3>
                </div>
                <div id="halim-carousel-widget-3" class="owl-carousel owl-theme">
                    @for ($i = 0; $i < 10; $i++)
                        <article class="thumb grid-item post-{{ $i }}">
                            <div class="halim-item">
                                <a class="halim-thumb" href="/dep-trai-la-so-1" title="Đẹp Trai Là Số 1">
                                    <figure><img class="lazyload blur-up img-responsive" data-sizes="auto"
                                                 data-src="{{ asset('uploads/2020/05/dep-trai-la-so-1-15425-thumbnail.jpg') }}"
                                                 alt="Đẹp Trai Là Số 1" title="Đẹp Trai Là Số 1"></figure>
                                    <span class="status">FULL HD</span><span class="episode">Tập 22</span>
                                    <div class="icon_overlay" data-html="true"
                                         data-toggle="halim-popover"
                                         data-placement="top"
                                         data-trigger="hover"
                                         title="<span class=film-title>Đẹp Trai Là Số 1</span>"
                                         data-content="<div class=org-title>Intense Love (2020)</div>                            <div class=film-meta>
                                <div class=text-center>
                                    <span class=released><i class=hl-calendar></i> 2020</span>                                                                    </div>
                                <div class=film-content>Bộ phim là câu chuyện tình yêu hào môn hường phấn ngọt ngào giữa nữ minh tinh nóng&amp;hellip;</div>
                                <p class=category>Quốc gia: <span class=category-name>Trung Quốc</span></p>                                <p class=category>Thể loại: <span class=category-name>Tâm Lý</span><span class=category-name>Tình Cảm</span></p>
                            </div>">
                                    </div>

                                    <div class="halim-post-title-box">
                                        <div class="halim-post-title ">
                                            <h2 class="entry-title">Đẹp Trai Là Số 1</h2>
                                            <p class="original_title">Intense Love (2020)</p></div>
                                    </div>
                                </a>
                            </div>
                        </article>
                    @endfor
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
            <section id="halim-advanced-widget-2">
                <h4 class="section-heading">
                    <a href="/phim-moi/" title="Phim mới nhất">
                        <span class="h-text">Phim mới nhất</span>
                    </a>
                    <ul class="heading-nav pull-right hidden-xs">
                        <li class="section-btn halim_ajax_get_post" data-catid="752" data-showpost="12"
                            data-widgetid="halim-advanced-widget-2" data-layout="6col">
                            <span data-text="Hài Hước"></span>
                        </li>
                        <li class="section-btn halim_ajax_get_post" data-catid="84" data-showpost="12"
                            data-widgetid="halim-advanced-widget-2" data-layout="6col">
                            <span data-text="Hành Động"></span>
                        </li>
                        <li class="section-btn halim_ajax_get_post" data-catid="762" data-showpost="12"
                            data-widgetid="halim-advanced-widget-2" data-layout="6col">
                            <span data-text="Tình Cảm"></span>
                        </li>
                        <li class="section-btn halim_ajax_get_post" data-catid="753" data-showpost="12"
                            data-widgetid="halim-advanced-widget-2" data-layout="6col">
                            <span data-text="Viễn Tưỏng"></span></li>
                    </ul>
                </h4>
                <div id="halim-advanced-widget-2-ajax-box" class="halim_box">
                    @for ($i = 0; $i < 12; $i++)
                        <article class="col-md-2 col-sm-4 col-xs-6 thumb grid-item post-21352">
                            <div class="halim-item">
                                <a class="halim-thumb" href="/hoi-ket-cua-sat-thu" title="Hồi Kết Của Sát Thủ">
                                    <figure><img class="lazyload blur-up img-responsive" data-sizes="auto"
                                                 data-src="{{ asset('uploads/2020/06/hoi-ket-cua-sat-thu-21352-thumbnail.jpg') }}"
                                                 alt="Hồi Kết Của Sát Thủ" title="Hồi Kết Của Sát Thủ"></figure>
                                    <span class="status">FHD</span><span class="episode">Full</span>
                                    <div class="icon_overlay" data-html="true"
                                         data-toggle="halim-popover"
                                         data-placement="top"
                                         data-trigger="hover"
                                         title="<span class=film-title>Hồi Kết Của Sát Thủ</span>"
                                         data-content="<div class=org-title>Sniper: Assassin&amp;#039;s End</div>                            <div class=film-meta>
                                <div class=text-center>
                                    <span class=released><i class=hl-calendar></i> 2020</span>                                    <span class=runtime><i class=hl-clock></i> 90 phút</span>                                </div>
                                <div class=film-content>Tay bắn tỉa huyền thoại Thomas Beckett cùng con trai, đặc nhiệm bắn tỉa Brandon Beckett, đang chạy&amp;hellip;</div>
                                <p class=category>Quốc gia: <span class=category-name>Mỹ</span></p>                                <p class=category>Thể loại: <span class=category-name>Hành Động</span></p>
                            </div>">
                                    </div>

                                    <div class="halim-post-title-box">
                                        <div class="halim-post-title ">
                                            <h2 class="entry-title">Hồi Kết Của Sát Thủ</h2>
                                            <p class="original_title">Sniper: Assassin&#039;s End</p></div>
                                    </div>
                                </a>
                            </div>
                        </article>
                    @endfor
                    <a href="/phim-moi/" class="see-more">View all post »</a>
                </div>
            </section>
            <div class="clearfix"></div>
            <section id="halim-advanced-widget-4">
                <h4 class="section-heading">
                    <a href="/phim-bo/" title="Phim bộ mới nhất">
                        <span class="h-text">Phim bộ mới nhất</span>
                    </a>
                    <ul class="heading-nav pull-right hidden-xs">
                        <li class="section-btn halim_ajax_get_post" data-catid="766" data-showpost="12"
                            data-widgetid="halim-advanced-widget-4" data-layout="6col"><span
                                    data-text="Cổ Trang"></span></li>
                        <li class="section-btn halim_ajax_get_post" data-catid="769" data-showpost="12"
                            data-widgetid="halim-advanced-widget-4" data-layout="6col"><span
                                    data-text="Gia Đình"></span></li>
                        <li class="section-btn halim_ajax_get_post" data-catid="751" data-showpost="12"
                            data-widgetid="halim-advanced-widget-4" data-layout="6col"><span
                                    data-text="Hoạt Hình"></span></li>
                        <li class="section-btn halim_ajax_get_post" data-catid="761" data-showpost="12"
                            data-widgetid="halim-advanced-widget-4" data-layout="6col"><span
                                    data-text="Phiêu Lưu"></span></li>
                    </ul>
                </h4>
                <div id="halim-advanced-widget-4-ajax-box" class="halim_box">
                    @for ($i = 0; $i < 12; $i++)
                        <article class="col-md-2 col-sm-4 col-xs-6 thumb grid-item post-21128">
                            <div class="halim-item">
                                <a class="halim-thumb" href="/cam-ngon-truyen-phuong-quy-tu-thoi-ca"
                                   title="Cẩm Ngôn Truyện (Phượng Quy Tứ Thời Ca)">
                                    <figure><img class="blur-up img-responsive lazyautosizes lazyloaded"
                                                 data-sizes="auto"
                                                 data-src="{{ asset('uploads/2020/06/cam-ngon-truyen-phuong-quy-tu-thoi-ca-21128-thumbnail.jpg') }}"
                                                 alt="Cẩm Ngôn Truyện (Phượng Quy Tứ Thời Ca)"
                                                 title="Cẩm Ngôn Truyện (Phượng Quy Tứ Thời Ca)" sizes="185px"
                                                 src="{{ asset('uploads/2020/06/cam-ngon-truyen-phuong-quy-tu-thoi-ca-21128-thumbnail.jpg') }}">
                                    </figure>
                                    <span class="status">HD</span><span class="episode">Tập 8</span>
                                    <div class="icon_overlay" data-html="true" data-toggle="halim-popover"
                                         data-placement="top" data-trigger="hover" title="" data-content="<div class=org-title>The Legend of Jin Yan (2020)</div>                            <div class=film-meta>
                                <div class=text-center>
                                    <span class=released><i class=hl-calendar></i> 2020</span>                                                                    </div>
                                <div class=film-content>Phượng Quy Tứ Thời Ca / Cẩm Ngôn Truyện kể về con gái nhà tướng Văn Tố Cẩm&amp;hellip;</div>
                                <p class=category>Quốc gia: <span class=category-name>Trung Quốc</span></p>                                <p class=category>Thể loại: <span class=category-name>Cổ Trang</span><span class=category-name>Hành Động</span><span class=category-name>Tình Cảm</span></p>
                            </div>"
                                         data-original-title="<span class=film-title>Cẩm Ngôn Truyện (Phượng Quy Tứ Thời Ca)</span>">
                                    </div>

                                    <div class="halim-post-title-box">
                                        <div class="halim-post-title ">
                                            <h2 class="entry-title">Cẩm Ngôn Truyện (Phượng Quy Tứ Thời Ca)</h2>
                                            <p class="original_title">The Legend of Jin Yan (2020)</p></div>
                                    </div>
                                </a>
                            </div>
                        </article>
                    @endfor
                    <a href="/phim-bo/" class="see-more">View all post »</a>
                </div>
            </section>
            <div class="clearfix"></div>
            <section id="halim-advanced-widget-3">
                <h4 class="section-heading">
                    <a href="/phim-le/" title="Phim lẻ mới nhất">
                        <span class="h-text">Phim lẻ mới nhất</span>
                    </a>
                    <ul class="heading-nav pull-right hidden-xs">
                        <li class="section-btn halim_ajax_get_post" data-catid="768" data-showpost="12"
                            data-widgetid="halim-advanced-widget-3" data-layout="6col"><span
                                    data-text="Khoa Học"></span></li>
                        <li class="section-btn halim_ajax_get_post" data-catid="764" data-showpost="12"
                            data-widgetid="halim-advanced-widget-3" data-layout="6col"><span data-text="Tâm Lý"></span>
                        </li>
                        <li class="section-btn halim_ajax_get_post" data-catid="765" data-showpost="12"
                            data-widgetid="halim-advanced-widget-3" data-layout="6col"><span
                                    data-text="Thần Thoại"></span></li>
                        <li class="section-btn halim_ajax_get_post" data-catid="763" data-showpost="12"
                            data-widgetid="halim-advanced-widget-3" data-layout="6col"><span
                                    data-text="Võ Thuật"></span></li>
                    </ul>
                </h4>
                <div id="halim-advanced-widget-3-ajax-box" class="halim_box">
                    @for ($i = 0; $i < 12; $i++)
                        <article class="col-md-2 col-sm-4 col-xs-6 thumb grid-item post-21112">
                            <div class="halim-item">
                                <a class="halim-thumb" href="/long-nhan-tu" title="Lòng Nhân Từ">
                                    <figure><img class="lazyload blur-up img-responsive" data-sizes="auto"
                                                 data-src="{{ asset('uploads/2020/06/long-nhan-tu-21112-thumbnail.jpg') }}"
                                                 alt="Lòng Nhân Từ" title="Lòng Nhân Từ"></figure>
                                    <span class="status">FHD</span><span class="episode">Full</span>
                                    <div class="icon_overlay" data-html="true"
                                         data-toggle="halim-popover"
                                         data-placement="top"
                                         data-trigger="hover"
                                         title="<span class=film-title>Lòng Nhân Từ</span>"
                                         data-content="<div class=org-title>Just Mercy</div>                            <div class=film-meta>
                                <div class=text-center>
                                    <span class=released><i class=hl-calendar></i> 2019</span>                                    <span class=runtime><i class=hl-clock></i> 137 phút</span>                                </div>
                                <div class=film-content>Sau khi tốt nghiệp Harvard, Bryan đến Alabama để bảo vệ quyền lợi của những người bị kết&amp;hellip;</div>
                                <p class=category>Quốc gia: <span class=category-name>Mỹ</span></p>                                <p class=category>Thể loại: <span class=category-name>Hình Sự</span><span class=category-name>Kịch Tính</span><span class=category-name>Tiểu Sử</span></p>
                            </div>">
                                    </div>

                                    <div class="halim-post-title-box">
                                        <div class="halim-post-title ">
                                            <h2 class="entry-title">Lòng Nhân Từ</h2>
                                            <p class="original_title">Just Mercy</p></div>
                                    </div>
                                </a>
                            </div>
                        </article>
                    @endfor
                    <div class="clearfix"></div>
                    <a href="/phim-le/" class="see-more">View all post »</a>
                </div>
            </section>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection
