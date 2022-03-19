<div class="form-group">
    <label class="col-form-label" for="{{ $id ?? $name }}">{{ $label ?? $name }}</label>
    <select
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        class="form-control {{ $class ?? 'select2-default' }}"
        {{ ($multiple ?? false) ? 'multiple' : '' }}
        {{ ($disabled ?? false) ? 'disabled' : '' }}
        {{ ($readonly ?? false) ? 'readonly' : '' }}
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
                @foreach($opdata as $key => $val)
                    data-{{ $key }}="{{ $val }}"
                @endforeach
            >
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>