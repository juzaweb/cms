<li class="m-1" id="item-{{ $taxonomy->get('singular') }}-{{ $item->id }}">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="taxonomies[]" class="custom-control-input" id="{{ $taxonomy->get('singular') }}-{{ $item->id }}" value="{{ $item->id }}" @if(in_array($item->id, $value ?? [])) checked @endif>
        <label class="custom-control-label" for="{{ $taxonomy->get('singular') }}-{{ $item->id }}">{{ $prefix ?? '' }}{{ $item->name }}</label>
    </div>
</li>

@if($item->childrens)
    @foreach($item->childrens as $child)
        @component('tadcms::components.category-item', [
            'taxonomy' => $taxonomy,
            'item' => $child,
            'prefix' => ($prefix ?? '') . '-- '
        ])
        @endcomponent
    @endforeach
@endif