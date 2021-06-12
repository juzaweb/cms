@extends('layouts.master')

@section('content')
<div class="row container" id="wrapper">
    <div class="mymo-panel-filter">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-8 hidden-xs">
                    <div class="yoast_breadcrumb"><span>
                            <span>
                                <a href="{{ route('home') }}">@lang('theme::app.home')</a> »
                                <span class="breadcrumb_last" aria-current="page">{{ $user->name }}</span>
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


    @include('account.sidebar')

    <main id="main-contents" class="col-xs-12 col-sm-12 col-md-12">
        <section>
            <div class="section-bar clearfix">
                <h3 class="section-title">
                    <span>@lang('theme::app.bookmark')</span><span class="count pull-right"><i></i> item</span>
                </h3>
            </div>

            <div class="mymo_box">
                <ul class="mymo-bookmark-lists" id="bookmarkList" style="max-height: 350px;"></ul>
            </div>

            <div class="clearfix"></div>
        </section>
        <div class="section-bar clearfix">
            <div class="section-title">
                <span>@lang('theme::app.recently_visited')</span>
            </div>
        </div>
        <section class="tab-content">
            <div role="tabpanel" class="tab-pane active">
                <div class="popular-post">
                    @foreach($recently_visited as $item)
                        @include('data.mini_item')
                    @endforeach
                </div>

                {{ $recently_visited->links() }}
            </div>
        </section>

        <div class="clearfix"></div>
    </main>

</div>
@endsection