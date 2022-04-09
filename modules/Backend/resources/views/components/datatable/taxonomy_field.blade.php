<div class="form-group mb-2 mr-1">
    <select name="{{ $name }}" id="search-{{ $name }}" class="form-control load-taxonomies" data-post-type="{{ $field['taxonomy']->get('post_type') }}" data-taxonomy="{{ $field['taxonomy']->get('taxonomy') }}" data-placeholder="{{ trans('cms::app.all') }} {{ $field['label'] }}"></select>
</div>
