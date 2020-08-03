@extends('themes.mymo.layout')

@section('content')
    <div class="row container" id="wrapper">
        <div class="mymo-panel-filter">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-8 hidden-xs">
                        <div class="yoast_breadcrumb">
                            <span>
                                <span>
                                    <a href="{{ route('home') }}">@lang('app.home')</a> »
                                    <span class="breadcrumb_last" aria-current="page">@lang('app.verified_success')</span>
                                </span>
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

        <main class="col-xs-12 col-sm-12 col-md-12">
            <div class="post-content panel-body text-center">
                <h4 class="title-info">@lang('app.verified_success')</h4>
                <p>@lang('app.verified_success_description')</p>
                <a href="{{ route('account') }}" title="@lang('app.profile')" class="btn btn-primary">@lang('app.profile')</a>

                <a href="/" title="@lang('app.back_to_home')" class="btn btn-primary">@lang('app.back_to_home')</a>
            </div>
        </main>
    </div>
@endsection
