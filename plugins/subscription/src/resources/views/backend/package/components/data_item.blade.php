<div class="col-md-4">
    <div class="form-group">
        <label class="col-form-label">{{ trans('cms::app.label') }}</label>
        <input type="text" name="data[label][]" class="form-control" autocomplete="off" value="{{ $data['label'] ?? '' }}">
    </div>
</div>

<div class="col-md-8">
    <div class="form-group">
        <label class="col-form-label">{{ trans('cms::app.value') }}</label>
        <input type="text" name="data[value][]" class="form-control" autocomplete="off" value="{{ $data['value'] ?? '' }}">
    </div>
</div>
