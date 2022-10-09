<div class="form-group">
    @php
        $originValue = $value ?? $default ?? '';
        $value = substr($originValue, 0, 3).str_repeat('*',strlen($originValue)-7).substr($originValue, -4);
    @endphp
    <label class="col-form-label" for="{{ $id  ?? $name }}">
        {{ $label ?? $name }} @if($required ?? false) <abbr>*</abbr> @endif
    </label>

    <input
        type="text"
        name="{{ $name }}"
        class="form-control {{ $class ?? '' }}"
        id="{{ $id ?? $name }}"
        autocomplete="off"
        placeholder="{{ $value }}"
        @if($disabled ?? false) disabled @endif
        @if($required ?? false) required @endif
        @if ($readonly ?? false) readonly @endif
    @foreach ($data ?? [] as $key => $val)
        {{ 'data-' . $key. '="'. $val .'"' }}
        @endforeach
    >
</div>
