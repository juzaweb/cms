<span class="tag badge badge-light m-1">{{ $item->name }} <a href="javascript:void(0)" class="text-danger ml-1 remove-tag-item"><i class="fa fa-times-circle"></i></a>
    <input type="hidden" name="taxonomies[]" class="{{ $item->taxonomy }}-explode" value="{{ $item->id }}">
</span>