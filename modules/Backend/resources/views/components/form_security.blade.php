<div class="form-group">
    @php
        $originValue = $value ?? $default ?? '';
        if ($originValue) {
            if (strlen($originValue) < 7) {
                $value = str_repeat('*', strlen($originValue));
            } else {
                $value = str_repeat('*', strlen($originValue) - 4).substr($originValue, -4);
            }
        }
    @endphp
    <label class="col-form-label" for="{{ $id  ?? $name }}">
        {{ $label ?? $name }} @if($required ?? false) <abbr>*</abbr> @endif
    </label>

    <div class="input-group">
        <input
            type="text"
            name="{{ $name }}"
            class="form-control {{ $class ?? '' }}"
            id="{{ $id ?? $name }}"
            autocomplete="off"
            value="{{ $value }}"
            @if($value) disabled @endif
            @if($disabled ?? false) disabled @endif
            @if($required ?? false) required @endif
            @if ($readonly ?? false) readonly @endif
        @foreach ($data ?? [] as $key => $val)
            {{ 'data-' . $key. '="'. $val .'"' }}
            @endforeach
        >

        @if($value)
            <div class="input-group-append">
                <a href="javascript:void(0)" class="input-group-text" onclick="$(this).closest('.input-group').find('.form-control').prop('disabled', false).val(null).focus()"><i class="fa fa-edit"></i></a>
            </div>
        @endif
    </div>
</div>
