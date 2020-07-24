@extends('themes.mymo.layout')

@section('content')
<div class="row container" id="wrapper">
    <div class="halim-panel-filter">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-8 hidden-xs">
                    <div class="yoast_breadcrumb"><span>
                            <span>
                                <a href="">@lang('app.home')</a> » <span class="breadcrumb_last" aria-current="page">{{ $user->name }}</span></span>
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
    </div>

    <aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
        <div class="section-bar clearfix">
            <h3 class="section-title">
                <span>@lang('app.change_password')</span>
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
                <div class="col-sm-4">
                    <form action="{{ route('account.change_password.handle') }}" method="post" class="form-ajax">
                        <label>@lang('app.current_password')</label>
                        <div class="form-group pass_show">
                            <input type="password" class="form-control" name="current_password">
                        </div>

                        <label>@lang('app.new_password')</label>
                        <div class="form-group pass_show">
                            <input type="password" class="form-control" name="password">
                        </div>

                        <label>@lang('app.confirm_password')</label>
                        <div class="form-group pass_show">
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">@lang('app.update')</button>
                        </div>
                    </form>
                </div>
                <style>
                    .pass_show{position: relative}
                    .pass_show .ptxt {
                        position: absolute;
                        top: 50%;
                        right: 10px;
                        z-index: 1;
                        color: #f36c01;
                        margin-top: -10px;
                        cursor: pointer;
                        transition: .3s ease all;
                    }
                    .pass_show .ptxt:hover{color: #333333;}
                </style>
                <script>
                    jQuery(document).ready(function(){
                        jQuery('.pass_show').append('<span class="ptxt">Show</span>');
                    });
                    jQuery(document).on('click','.pass_show .ptxt', function(){
                        jQuery(this).text($(this).text() == "Show" ? "Hide" : "Show");
                        jQuery(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; });

                    });
                </script>
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