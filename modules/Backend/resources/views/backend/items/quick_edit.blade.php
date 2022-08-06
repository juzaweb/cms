<form method="post" action="{{ route('admin.posts.update', [$row->type, $row->id]) }}" class="form-ajax">
    @method('PUT')

    <div class="row">
        <div class="col-md-6">
            {{ Field::text($row, 'title') }}
        </div>

        <div class="col-md-3">
            {{ Field::select($row, 'status', [
                'options' => $row->getStatuses()
            ]) }}
        </div>

        <div class="col-md-3">
            <br />
            <button type="submit" class="btn btn-success mt-3">
                <i class="fa fa-save"></i> {{ trans('cms::app.save') }}
            </button>
        </div>
    </div>

    <div class="row">
        @foreach($postTypeTaxonomies as $key => $taxonomy)
            @php
                $items = $taxonomies->where('taxonomy', '=', $taxonomy->get('taxonomy'));
                if ($items->isEmpty()) {
                    continue;
                }

                $value = $row->taxonomies
                    ->where('taxonomy', '=', $taxonomy->get('taxonomy'))
                    ->pluck('id')
                    ->toArray();
            @endphp

            <div class="col-md-6">
                <div class="form-group form-taxonomy">
                    <label class="col-form-label w-100">
                        {{ $taxonomy->get('label') }}
                    </label>

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
                </div>
            </div>
        @endforeach
    </div>
</form>
