<div class="card sidebar-item" id="sidebar-{{ $item->get('key') }}">
    <form action="{{ route('admin.widget.update', [$item->get('key')]) }}" method="post" class="form-ajax">
        @method('PUT')

        <div class="card-header">
            <h5>{{ $item->get('label') }}</h5>

            <div class="text-right right-actions">
                <a href="javascript:void(0)" class="show-edit-form">
                    <i class="fa fa-sort-down fa-2x"></i>
                </a>
            </div>
        </div>

        <div class="card-body @if(empty($show)) box-hidden @endif">
            <div class="dd jw-widget-builder" data-key="{{ $item->get('key') }}">
                @php
                    $widgets = jw_get_widgets_sidebar($item->get('key'));
                @endphp
                <ol class="dd-list">
                    @foreach($widgets as $key => $widget)
                        @php
                            $widgetData = \Juzaweb\CMS\Facades\HookAction::getWidgets($widget['widget'] ?? 'null');
                        @endphp

                        @if(empty($widgetData))
                            @continue
                        @endif

                        @component('cms::backend.widget.components.sidebar_widget_item', [
                            'widget' => $widgetData,
                            'sidebar' => $item,
                            'key' => $key,
                            'data' => $widget
                        ])
                        @endcomponent
                    @endforeach
                </ol>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fa fa-save"></i> {{ trans('cms::app.save') }}
            </button>

        </div>
    </form>
</div>
