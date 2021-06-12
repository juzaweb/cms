@extends('layouts.master')

@section('content')

<div class="row container" id="wrapper">
    <div class="mymo-panel-filter">
        <div class="panel-heading">
            <div class="row">

                <div class="col-xs-8 hidden-xs">
                    <div class="yoast_breadcrumb">
                        <span>
                            <span>
                                <a href="{{ route('home') }}">@lang('theme::app.home')</a> »
                                <span class="breadcrumb_last" aria-current="page">{{ $info->name }}</span>
                            </span>
                        </span>
                    </div>
                </div>

                <div class="col-xs-4 text-right">
                    <a href="javascript:void(0)" id="expand-ajax-filter">@lang('theme::app.filter_movies') <i id="ajax-filter-icon" class="hl-angle-down"></i></a>
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

                    {{--<span class="pull-right sortby">Sort by: <a href="?sortby=movie">Movie</a> / <a href="?sortby=tv_series">TV Series</a></span>--}}

                </h3>
            </div>

            @php
                $ads = get_ads('genre_header');
            @endphp
            @if($ads)
                {!! $ads !!}
            @endif

            <div class="mymo_box">
                @foreach($items as $item)
                    <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-21564">
                        @include('data.item')
                    </article>
                @endforeach
            </div>

            <div class="clearfix"></div>
            <div class="text-center">
                {{ $items->links('data.pagination') }}
            </div>

            @if(@$info->description)
            <div class="entry-content htmlwrap clearfix">
                <div class="video-item mymo-entry-box">
                    <article id="post-312" class="item-content">
                        {!! $info->description !!}
                    </article>
                    <div class="item-content-toggle">
                        <div class="item-content-gradient"></div>
                        <span class="show-more" data-single="true" data-showmore="@lang('theme::app.show_more')" data-showless="@lang('theme::app.show_less')">@lang('theme::app.show_more')</span>
                    </div>
                </div>
            </div>
            @endif
        </section>
    </main>

    <aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
        @include('data.sidebar')
    </aside>
</div>

@endsection
