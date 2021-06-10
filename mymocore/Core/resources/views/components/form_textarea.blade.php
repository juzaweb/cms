<div class="form-group">
    <label class="col-form-label" for="{{ $name }}">{{ $label ?? $name }}</label>
    <textarea class="form-control" name="{{ $name }}" id="{{ $name }}" rows="5">{{ $value ?? '' }}</textarea>
</div>