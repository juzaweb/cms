@extends('layouts.main')

@section('content')
    <div class="row container" id="wrapper">
        <div class="mymo-panel-filter">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-8 hidden-xs">
                        <div class="yoast_breadcrumb">
                            <span>
                                <span>
                                    <a href="/">@lang('theme::app.home')</a> »
                                    <span class="breadcrumb_last" aria-current="page">Error 404: Page not found</span>
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

        <main class="col-xs-12 col-sm-12 col-md-12">
            <div class="post-content panel-body text-center">
                <h4 class="title-info">404 Not Found!</h4>
                <p>The page you are looking for does not exist. You may have used an outdated link or may have typed the URL incorrectly.</p>
                <a href="/" title="Back to home" class="btn btn-primary">Back to home</a>
            </div>
        </main>
    </div>
@endsection
