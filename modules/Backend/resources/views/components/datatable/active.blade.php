@if($row->active)
    <span class="text-success">{{ trans('cms::app.active') }}</span>
@else
    <span class="text-secondary">{{ trans('cms::app.inactive') }}</span>
@endif