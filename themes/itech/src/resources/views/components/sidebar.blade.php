<div id='sidebar-wrapper'>
    <div class='sidebar no-items section' id='social-widget' name='Social Widget'>
    </div>
    <div class='sidebar common-widget section' id='sidebar1' name='Sidebar Right'>
        @if(function_exists('ads_position') && $ad = ads_position('sidebar_top'))
            <div class='widget' data-version='2'>
                <div class='widget-title'>
                    <h3 class='title'>
                        {{ __('itech::translation.ads') }}
                    </h3>
                </div>
                <div class='widget-content'>
                    {!! $ad !!}
                </div>
            </div>
        @endif

        {{ dynamic_sidebar('sidebar') }}

    </div>
</div>