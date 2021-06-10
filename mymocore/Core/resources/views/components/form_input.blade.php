<div class="form-group">
    @php
    $required = $required ?? false;
    @endphp
    <label class="col-form-label" for="{{ $name }}">{{ $label ?? $name }} @if($required) <abbr>*</abbr> @endif</label>
    <input type="text" name="{{ $name }}" class="form-control" id="{{ $name }}" value="{{ $value ?? '' }}" autocomplete="off" @if($required) required @endif>
</div>