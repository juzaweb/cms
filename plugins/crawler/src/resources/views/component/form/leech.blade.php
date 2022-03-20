<hr>

<div class="form-group">
    <label class="col-form-label" for="crawler_thumbnail">Thumbnail</label>
    <input type="text" name="crawler_thumbnail" class="form-control" id="crawler_thumbnail" value="{{ $model->crawler_thumbnail }}" autocomplete="off">
</div>

<div class="form-group">
    <label class="col-form-label" for="crawler_title">Title</label>
    <input type="text" name="crawler_title" class="form-control" id="crawler_title" value="{{ $model->crawler_title }}" autocomplete="off" required>
</div>

<div class="form-group">
    <label class="col-form-label" for="crawler_content">Content</label>
    <textarea name="crawler_content" class="form-control" id="crawler_content" rows="6" required>{{ $model->crawler_content }}</textarea>
</div>

<hr>
<div class="form-group">
    <label class="col-form-label" for="crawler_content">Preview Url</label>
    <input type="text" name="preview_url" class="form-control" autocomplete="off">
</div>

<input type="hidden" id="review_action_link" value="{{ $linkPreview }}">

<button type="button" class="btn btn-success btn-sm" id="show-preview-leech"><i class="fa fa-eye"></i> Preview</button>
<button type="button" class="btn btn-warning btn-sm" id="clear-preview-leech"><i class="fa fa-times"></i> Clear</button>

<div id="leech-preview" class="box-hidden single-post-info-content border-dark p-3">
    <h2 id="leech-title"></h2>
    <div id="leech-thumbnail"></div>
    <div id="leech-content"></div>
</div>