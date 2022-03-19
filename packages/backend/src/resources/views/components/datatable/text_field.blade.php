<div class="form-group mb-2 mr-1">
    <label for="search-{{ $name }}" class="sr-only">{{ $field['label'] ?? '' }}</label>
    <input name="{{ $name }}" id="search-{{ $name }}" class="form-control" placeholder="{{ $field['placeholder'] ?? '' }}" autocomplete="off">
</div>