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
                                <a href="{{ route('home') }}">@lang('app.home')</a> »
                                <span class="breadcrumb_last" aria-current="page">{{ $info->name }}</span>
                            </span>
                        </span>
                    </div>
                </div>

                <div class="col-xs-4 text-right">
                    <a href="javascript:void(0)" id="expand-ajax-filter">Lọc phim <i id="ajax-filter-icon" class="hl-angle-down"></i></a>
                </div>

                <div id="alphabet-filter" style="float: right;display: inline-block;margin-right: 25px;"></div>
            </div>
        </div>

        <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
            <div class="ajax"></div>
        </div>

    </div><!-- end panel-default -->

    <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
        <section>
            <div class="section-bar clearfix">
                <h3 class="section-title">
                    <span>{{ $info->name }}</span>

                    <span class="pull-right sortby">Sort by: <a href="?sortby=movie">Movie</a> / <a href="?sortby=tv_series">TV Series</a></span>

                </h3>
            </div>

            <div class="halim_box">
                @foreach($items as $item)
                    <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-21564">
                    @include('themes.mymo.data.item')
                    </article>
                @endforeach
            </div>

            <div class="clearfix"></div>
            <div class="text-center">
                {{ $items->links('themes.mymo.data.pagination') }}
            </div>

            <div class="entry-content htmlwrap clearfix">
                <div class="video-item halim-entry-box">
                    <article id="post-312" class="item-content">

                    </article>
                    <div class="item-content-toggle">
                        <div class="item-content-gradient"></div>
                        <span class="show-more" data-single="true" data-showmore="Hiển thị thêm" data-showless="Rút gọn">Hiển thị thêm</span>
                    </div>
                </div>
            </div>

        </section>
    </main>

    <aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
        <div id="text-16" class="widget widget_text">
            <div class="textwidget">
            </div>
        </div>

        <div id="text-14" class="widget widget_text">
            <div class="textwidget">

            </div>
        </div>

        <div id="halim_tab_popular_videos-widget-5" class="widget halim_tab_popular_videos-widget">
            <div class="section-bar clearfix">
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
