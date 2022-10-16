<div class="form-group">
    <label class="col-form-label" for="{{ $id  ?? $name }}">
        {{ $label ?? $name }} @if($required ?? false) <abbr>*</abbr> @endif
    </label>

    <input
        type="{{ $type ?? 'text' }}"
        name="{{ $name }}"
        class="form-control {{ $class ?? '' }}"
        id="{{ $id ?? $name }}"
        value="{{ $value ?? $default ?? '' }}"
        autocomplete="off"
        placeholder="{{ $placeholder ?? '' }}"
        @if($disabled ?? false) disabled @endif
        @if($required ?? false) required @endif
        @if ($readonly ?? false) readonly @endif
        @foreach ($data ?? [] as $key => $val)
            {{ 'data-' . $key. '="'. $val .'"' }}
        @endforeach
    >
</div>
