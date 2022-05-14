@if($checkUpdate)
    <div class="alert alert-success">Version {{ $versionAvailable }} ready to update.</div>
@else
    <div class="alert alert-secondary">{{ trans('cms::app.no_new_version_available') }}</div>
@endif

<form method="get" action="{{ route('admin.update.process', ['cms']) }}">
    @csrf

    <button type="submit" class="btn btn-primary">
        <i class="fa fa-upload"></i>
        @if($checkUpdate)
            {{ trans('cms::app.update_now') }}
        @else
            {{ trans('cms::app.re_update') }}
        @endif
    </button>
</form>
