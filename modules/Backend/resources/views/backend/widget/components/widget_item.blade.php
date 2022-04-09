<div class="widget-block mb-2">
    <div class="widget-block-body">
        <a href="javascript:void(0)" class="dropdown-action"><i class="fa fa-sort-down fa-2x"></i></a>
        <div class="widget-title">{{ $widget->get('label') }}</div>
        <div class="widget-description">{{ $widget->get('description') }}</div>
    </div>

    <div class="sidebar-blocks box-hidden">
        <form action="" method="get" class="form-add-widget">
            <div class="list-group mt-3">
                @foreach($sidebars as $sidebarKey => $sidebar)
                    <a href="javascript:void(0)" class="list-group-item rounded-0 widget-sidebar-item">
                        <span></span> {{ trans('cms::app.add_to', ['name' => $sidebar->get('label')]) }}
                        <input type="checkbox" name="sidebars[]" value="{{ $sidebarKey }}" class="box-hidden">
                    </a>
                @endforeach
            </div>

            <div class="text-center mb-2">
                <input type="hidden" name="widget" value="{{ $key }}">

                <button type="submit" class="btn btn-success btn-sm mt-2">{{ trans('cms::app.add_widget') }}</button>
            </div>
        </form>

    </div>

</div>