<div class="form-group">
    <label class="col-form-label" for="{{ $id ?? $name }}">
        {{ $label ?? $name }} @if($required ?? false) <abbr>*</abbr> @endif
    </label>
    <select
        name="{{ ($multiple ?? false) ? "{$name}[]" : $name }}"
        id="{{ $id ?? $name }}"
        class="form-control {{ $class ?? 'select2-default' }}"
        {{ ($multiple ?? false) ? 'multiple' : '' }}
        {{ ($disabled ?? false) ? 'disabled' : '' }}
        {{ ($readonly ?? false) ? 'readonly' : '' }}
        @if($required ?? false) required @endif
        @foreach($data ?? [] as $key => $val)
            data-{{ $key }}="{{ $val }}"
        @endforeach
    >
        @php
            $value = $value ?? [];
            $value = !is_array($value) ? [$value] : $value;
        @endphp
        @foreach($options ?? [] as $key => $name)
            @php
                if(is_array($name)) :
                    $label = $name['label'];
                    $opdata = $name['data'];
                else :
                    $label = $name;
                    $opdata = [];
                endif;
            @endphp
            <option
                value="{{ $key }}"
                @if(in_array($key, $value)) selected @endif
                @foreach($opdata as $opkey => $opval)
                    data-{{ $opkey }}="{{ $opval }}"
                @endforeach
            >
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>
