@switch($row->status)
    @case('publish')
    <span class="text-success">{{ trans('cms::app.publish') }}</span>
    @break

    @case('approved')
    <span class="text-success">{{ trans('cms::app.approved') }}</span>
    @break

    @case('private')
    <span class="text-warning">{{ trans('cms::app.private') }}</span>
    @break

    @case('pending')
    <span class="text-warning">{{ trans('cms::app.pending') }}</span>
    @break

    @case('draft')
    <span class="text-secondary">{{ trans('cms::app.draft') }}</span>
    @break

    @case('trash')
    <span class="text-danger">{{ trans('cms::app.trash') }}</span>
    @break

    @case('deny')
    <span class="text-danger">{{ trans('cms::app.deny') }}</span>
    @break

    @default
    <span class="text-secondary">{{ trans('cms::app.draft') }}</span>
    @break
@endswitch