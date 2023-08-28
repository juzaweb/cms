<div class="form-group">
    <label class="col-form-label" for="{{ $id  ?? $name }}">
        {{ $label ?? $name }} @if($required ?? false) <abbr>*</abbr> @endif
    </label>
    <div class="row">
        <div class="col-md-9">
            <input
                type="text"
                name="{{ $name }}"
                class="form-control"
                id="{{ $id  ?? $name }}"
                value="{{ $value ?? $default ?? '' }}"
                autocomplete="off"
                @if($required ?? false) required @endif
            >
        </div>

        <div class="col-md-3">
            <a href="javascript:void(0)"
               class="btn btn-primary file-manager"
               data-input="{{ $id  ?? $name }}"
               data-type="{{ $type ?? 'file' }}"
               data-disk="{{ $disk ?? config('juzaweb.filemanager.disk') }}"
            >
                <i class="fa fa-upload"></i> {{ trans('cms::app.upload') }}
            </a>
        </div>
    </div>
</div>
