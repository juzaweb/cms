<div class="form-group mb-2 mr-1">
    <select name="{{ $name }}" id="search-{{ $name }}" class="form-control select2-default" data-width="{{ $field['width'] ?? '100%' }}">
        <option value="">{{ trans('cms::app.all') }} {{ $field['label'] }}</option>
        @foreach($field['options'] ?? [] as $key => $val)
            <option value="{{ $key }}">{{ $val }}</option>
        @endforeach
    </select>
</div>