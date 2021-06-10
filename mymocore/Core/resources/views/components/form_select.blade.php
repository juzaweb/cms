<div class="form-group">
    <label class="col-form-label" for="{{ $name }}">{{ $label ?? $name }}</label>
    <select name="{{ $name }}" id="{{ $name }}" class="form-control select2-default">
        @foreach($options as $key => $name)
        <option value="{{ $key }}" @if($key == ($value ?? '')) selected @endif>{{ $name }}</option>
        @endforeach
    </select>
</div>