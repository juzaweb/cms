@extends('themes.mymo.layout')

@section('content')
<div class="row container" id="wrapper">
    <div class="halim-panel-filter">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-8 hidden-xs">
                    <div class="yoast_breadcrumb"><span><span><a href="http://xemphimplus.net/">Trang chủ</a> » <span class="breadcrumb_last" aria-current="page">Archives for theanhk</span></span></span></div>            </div>
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


    <aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
        <div class="section-bar clearfix">
            <h3 class="section-title">
                <span>Hồ sơ cá nhân</span>
            </h3>

            <div class="profile-sidebar">
                @include('themes.mymo.profile.sidebar')
            </div>
        </div>


    </aside>

    <main id="main-contents" class="col-xs-12 col-sm-12 col-md-12">
        <section>
            <div class="section-bar clearfix">
                <h3 class="section-title">
                    <span>Tủ phim</span><span class="count pull-right"><i></i> item</span>
                </h3>
            </div>

            <div class="halim_box">
                <ul class="halim-bookmark-lists" id="bookmarkList" style="max-height: 350px;"></ul>
            </div>

            <div class="clearfix"></div>
        </section>
        <div class="section-bar clearfix">
            <div class="section-title">
                <span>Recently Visited Posts</span>
            </div>
        </div>
        <section class="tab-content">
            <div role="tabpanel" class="tab-pane active">
                <div class="popular-post">
                    <div class="item post-25042">
                        <a href="http://xemphimplus.net/ban-trai-toi-la-nhan-vat-truyen-tranh" title="Bạn Trai Tôi Là Nhân Vật Truyện Tranh">
                            <div class="item-link">
                                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="/wp-content/uploads/2020/06/bantraitoi-300x450.jpg" class="lazyload blur-up post-thumb" alt="Bạn Trai Tôi Là Nhân Vật Truyện Tranh" title="Bạn Trai Tôi Là Nhân Vật Truyện Tranh" />
                            </div>
                            <h3 class="title">Bạn Trai Tôi Là Nhân Vật Truyện Tranh</h3>
                            <p class="original_title">Pop Out Boy! (2020)</p>									        </a>
                        <div class="viewsCount">8.3K lượt xem</div>
                    </div>
                    <div class="item post-25036">
                        <a href="http://xemphimplus.net/phi-vu-bao-to" title="Phi Vụ Bão Tố">
                            <div class="item-link">
                                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="/wp-content/uploads/2020/06/15LBQYX-300x450.jpg" class="lazyload blur-up post-thumb" alt="Phi Vụ Bão Tố" title="Phi Vụ Bão Tố" />
                            </div>
                            <h3 class="title">Phi Vụ Bão Tố</h3>
                            <p class="original_title">Force of Nature</p>									        </a>
                        <div class="viewsCount">10.8K lượt xem</div>
                    </div>
                    <div class="item post-24594">
                        <a href="http://xemphimplus.net/vo-boc-nguoi-may" title="Vỏ Bọc Người Máy">
                            <div class="item-link">
                                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="/wp-content/uploads/2020/06/vo-boc-nguoi-may-24594-thumbnail.jpg" class="lazyload blur-up post-thumb" alt="Vỏ Bọc Người Máy" title="Vỏ Bọc Người Máy" />
                            </div>
                            <h3 class="title">Vỏ Bọc Người Máy</h3>
                            <p class="original_title">Almost Human (2020)</p>									        </a>
                        <div class="viewsCount">19.8K lượt xem</div>
                    </div>
                    <div class="item post-24124">
                        <a href="http://xemphimplus.net/khu-mo-coi-brooklyn" title="Khu Mồ Côi Brooklyn">
                            <div class="item-link">
                                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="/wp-content/uploads/2020/06/khu-mo-coi-brooklyn-24124-thumbnail.jpg" class="lazyload blur-up post-thumb" alt="Khu Mồ Côi Brooklyn" title="Khu Mồ Côi Brooklyn" />
                            </div>
                            <h3 class="title">Khu Mồ Côi Brooklyn</h3>
                            <p class="original_title">Motherless Brooklyn</p>									        </a>
                        <div class="viewsCount">23.5K lượt xem</div>
                    </div>
                    <div class="item post-23900">
                        <a href="http://xemphimplus.net/tran-chien-o-rogue" title="Trận Chiến Ở Rogue">
                            <div class="item-link">
                                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="/wp-content/uploads/2020/06/tran-chien-o-rogue-23900-thumbnail.jpg" class="lazyload blur-up post-thumb" alt="Trận Chiến Ở Rogue" title="Trận Chiến Ở Rogue" />
                            </div>
                            <h3 class="title">Trận Chiến Ở Rogue</h3>
                            <p class="original_title">Rogue Warfare</p>									        </a>
                        <div class="viewsCount">38.4K lượt xem</div>
                    </div>
                </div>
            </div>
        </section>

        <div class="clearfix"></div>
    </main>

</div>
@endsection