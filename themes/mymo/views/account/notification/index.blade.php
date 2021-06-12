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
                                <span class="breadcrumb_last" aria-current="page">@lang('theme::app.notification')</span>
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
                        <span>@lang('theme::app.notification')</span><span class="count pull-right"><i></i> item</span>
                    </h3>
                </div>

                <table class="table w-100">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>@lang('theme::app.subject')</th>
                            <th width="20%">@lang('theme::app.created_at')</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($notifications as $index => $notification)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><a href="{{ route('account.notification.detail', [$notification->id]) }}" @if(empty($notification->read_at)) style="font-weight: bold" @endif>{{ $notification->data['subject'] }}</a></td>
                            <td>{{ $notification->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>


            <div class="clearfix"></div>
        </main>

    </div>
@endsection