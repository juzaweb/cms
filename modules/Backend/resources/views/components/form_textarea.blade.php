<div class="form-group @if($hidden ?? false) box-hidden @endif">
    <label class="col-form-label" for="{{ $id ?? $name }}">{{ $label ?? $name }}</label>
    <textarea
        class="form-control"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        rows="{{ $rows ?? 3 }}"
        placeholder="{{ $placeholder ?? '' }}"
        @if($disabled ?? false) disabled @endif
    >{{ $value ?? '' }}</textarea>
</div>
