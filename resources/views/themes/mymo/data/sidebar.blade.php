@php
$sidebar = theme_setting('sidebar');
@endphp

@if(@$sidebar->widget1->status == 1)
<div id="text-1" class="widget widget_text">
    <div class="textwidget">
        {!! @$sidebar->widget1->body !!}
    </div>
</div>
@endif

<div id="text-14" class="widget widget_text">
    <div class="textwidget">
        <!-- Ads -->
    </div>
</div>

@if(@$sidebar->popular_movies->status == 1)
<div id="halim_tab_popular_videos-widget-5" class="widget halim_tab_popular_videos-widget">
    <div class="section-bar clearfix">
        <div class="section-title">
            <span>{{ @$sidebar->popular_movies->title }}</span>
            <ul class="halim-popular-tab" role="tablist">
                <li role="presentation" class="active">
                    <a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="10" data-type="day">@lang('app.day')</a>
                </li>
                <li role="presentation">
                    <a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="10" data-type="week">@lang('app.week')</a>
                </li>
                <li role="presentation">
                    <a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="10" data-type="month">@lang('app.month')</a>
                </li>
                <li role="presentation">
                    <a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="10" data-type="all">@lang('app.all')</a>
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
@endif

@for($i=2;$i<=3;$i++)
    @if(@$sidebar->{'widget' . $i}->status == 1)
        <div id="text-{{ $i }}" class="widget widget_text">
            <div class="textwidget">
                {!! @$sidebar->{'widget' . $i}->body !!}
            </div>
        </div>
    @endif
@endfor