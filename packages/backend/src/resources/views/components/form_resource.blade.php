@php
    if (!isset($action)) {
        $currentUrl = url()->current();
        if (isset($model)) {
            $action = $model->id ?
                str_replace('/edit', '', $currentUrl) :
                str_replace('/create', '', $currentUrl);
        } else {
            $action = '';
        }
    }

    if (!isset($method)) {
        if (isset($model)) {
            $method = $model->id ? 'put' : 'post';
        } else {
            $method = 'post';
        }
    }
@endphp

<form
        action="{{ $action }}"
        method="post"
        class="form-ajax"
>
    @csrf

    @if($method == 'put')
        @method('PUT')
    @endif

    <div class="row mb-2">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="btn-group float-right">
                <button type="submit" class="btn btn-success px-5"><i class="fa fa-save"></i> {{ trans('cms::app.save') }}</button>

                <button type="button" class="btn btn-warning cancel-button px-3"><i class="fa fa-refresh"></i> {{ trans('cms::app.reset') }}</button>
            </div>
        </div>
    </div>

    {{ $slot ?? '' }}

</form>
