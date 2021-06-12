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
                                <a href="{{ route('account') }}">{{ $user->name }}</a> »
                                <span class="breadcrumb_last" aria-current="page">@lang('theme::app.change_password')</span>
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
    </div>

    @include('account.sidebar')

    <main id="main-contents" class="col-xs-12 col-sm-12 col-md-12">
        <section>
            <div class="section-bar clearfix">
                <h3 class="section-title">
                    <span>@lang('theme::app.bookmark')</span><span class="count pull-right"><i></i> item</span>
                </h3>
            </div>

            <div class="mymo_box">
                <div class="col-sm-4">
                    <form action="{{ route('account.change_password.handle') }}" method="post" class="form-ajax">
                        @csrf

                        <label>@lang('theme::app.current_password')</label>
                        <div class="form-group pass_show">
                            <input type="password" class="form-control" name="current_password" placeholder="@lang('theme::app.current_password')">
                        </div>

                        <label>@lang('theme::app.new_password')</label>
                        <div class="form-group pass_show">
                            <input type="password" class="form-control" name="password" placeholder="@lang('theme::app.new_password')">
                        </div>

                        <label>@lang('theme::app.confirm_password')</label>
                        <div class="form-group pass_show">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="@lang('theme::app.confirm_password')">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">@lang('theme::app.update')</button>
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