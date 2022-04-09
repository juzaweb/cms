@extends('cms::layouts.backend')

@section('content')

    <div class="row" id="widget-container">
        <div class="col-md-4">
            @foreach($widgets as $key => $widget)
                @component('cms::backend.widget.components.widget_item', [
                        'widget' => $widget,
                        'key' => $key,
                        'sidebars' => $sidebars
                    ])
                @endcomponent
            @endforeach
        </div>

        <div class="col-md-8">
            @php
            $index = 0;
            @endphp
            @foreach($sidebars as $key => $sidebar)
                @component('cms::backend.widget.components.sidebar_item', [
                    'item' => $sidebar,
                    'show' => $index == 0,
                ])
                @endcomponent

                @php
                    $index ++;
                @endphp
            @endforeach
        </div>
    </div>
@endsection