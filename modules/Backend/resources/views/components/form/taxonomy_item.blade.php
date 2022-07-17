<li class="m-1" id="item-category-{{ $item->id }}">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="{{ $taxonomy->get('taxonomy') }}[]" class="custom-control-input" id="{{ $taxonomy->get('taxonomy') }}-{{ $item->id }}" value="{{ $item->id }}" @if(in_array($item->id, $value ?? [])) checked @endif>
        <label class="custom-control-label" for="{{ $taxonomy->get('taxonomy') }}-{{ $item->id }}">{{ $item->name }}</label>
    </div>
    @if($item->children->isNotEmpty())
    <ul class="ml-3 p-0">
        @foreach($item->children as $child)
            @component('cms::components.form.taxonomy_item', [
                'taxonomy' => $taxonomy,
                'item' => $child,
                'value' => $value
            ])
            @endcomponent
        @endforeach
    </ul>
    @endif
</li>



