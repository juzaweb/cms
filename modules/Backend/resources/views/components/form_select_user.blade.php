<div class="form-group">
    <label class="col-form-label" for="{{ $id ?? $name }}">{{ $label ?? $name }}</label>
    <select
            name="{{ ($multiple ?? false) ? "{$name}[]" : $name }}"
            id="{{ $id ?? $name }}"
            class="form-control load-users {{ $class ?? '' }}"
            {{ ($multiple ?? false) ? 'multiple' : '' }}
    >
        @foreach($options as $key => $tname)
            <option value="{{ $key }}" @if(in_array($key, $value)) selected @endif>{{ $tname }}</option>
        @endforeach
    </select>
</div>
