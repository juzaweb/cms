<div class="form-group form-taxonomy">
    <label class="col-form-label w-100">
        {{ $taxonomy->get('label') }}
        <span>
            <a href="javascript:void(0)" class="float-right add-new">
                <i class="fa fa-plus"></i> {{ trans('cms::app.add_new') }}
            </a>
        </span>
    </label>

    @php
        $items = \Juzaweb\Backend\Models\Taxonomy::with(['children'])
            ->whereNull('parent_id')
            ->where('taxonomy', '=', $taxonomy->get('taxonomy'))
            ->where('post_type', '=', $taxonomy->get('post_type'))
            ->get();
        $value = $model->taxonomies
            ->where('taxonomy', '=', $taxonomy->get('taxonomy'))
            ->pluck('id')
            ->toArray();
    @endphp

    <div class="show-taxonomies taxonomy-{{ $taxonomy->get('taxonomy') }}">
        <ul class="mt-2 p-0">
            @foreach($items as $item)
                @component('cms::components.form.taxonomy_item', [
                    'taxonomy' => $taxonomy,
                    'item' => $item,
                    'value' => $value
                ])
                @endcomponent
            @endforeach
        </ul>
    </div>

    <div class="form-add mt-2 form-add-taxonomy box-hidden">
        <div class="form-group">
            <label class="col-form-label">{{ trans('cms::app.name') }} <abbr>*</abbr></label>
            <input type="text" class="form-control taxonomy-name" autocomplete="off">
        </div>

        @if(in_array('hierarchical', $taxonomy->get('supports', [])))
            <div class="form-group mb-1">
                <label class="col-form-label">{{ trans('cms::app.parent') }}</label>
                <select type="text" class="form-control taxonomy-parent load-taxonomies" autocomplete="off"
                        data-post-type="{{ $taxonomy->get('post_type') }}"
                        data-taxonomy="{{ $taxonomy->get('taxonomy') }}">
                </select>
            </div>
        @endif

        <button
            type="button"
            class="btn btn-primary mt-2"
            data-type="{{ $taxonomy->get('type') }}"
            data-post_type="{{ $taxonomy->get('post_type') }}"
            data-taxonomy="{{ $taxonomy->get('taxonomy') }}"
        >
            <i class="fa fa-plus-circle"></i> {{ trans('cms::app.add') }}
        </button>
    </div>
</div>
