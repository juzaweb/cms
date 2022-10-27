@php
$value = $options['value'] ?? [];
@endphp
@if(empty($options['type']))
    @php
        $typeOptions = \Juzaweb\CMS\Facades\HookAction::getPostTypes()
            ->mapWithKeys(function ($item) {
                return [$item->get('key') => $item->get('label')];
            })
            ->toArray();
    @endphp

    {{ Field::select(trans('cms::app.post_type'), "{$name}[type]", ['options' => $typeOptions, 'value' => $value['type'] ?? null]) }}
@else
    <input type="hidden" name="{{"{$name}[type]"}}" value="{{ $options['type'] }}">
@endif

@if($options['multiple_taxonomy'] ?? true)
    {{ Field::selectTaxonomy(trans('cms::app.taxonomies'), "{$name}[taxonomies]", ['multiple' => true, 'post_type' => $options['type'] ?? null, 'value' => $value['taxonomies'] ?? null]) }}
@else
    {{ Field::selectTaxonomy(trans('cms::app.taxonomy'), "{$name}[taxonomy]", ['post_type' => $options['type'] ?? null, 'value' => $value['taxonomy'] ?? null]) }}
@endif

<div class="row">
    <div class="col-md-6">
        {{ Field::select(trans('cms::app.sort_by'), "{$name}[sort_by]", [
            'options' => [
                'id' => 'ID',
                'views' => 'Views'
            ],
             'value' => $value['sort_by'] ?? null
        ]) }}
    </div>
    <div class="col-md-6">
        {{ Field::select(trans('cms::app.sort_order'), "{$name}[sort_order]", [
            'options' => [
                'asc' => 'ASC',
                'desc' => 'DESC'
            ],
             'value' => $value['sort_order'] ?? null
        ]) }}
    </div>
</div>

{{ Field::text(trans('cms::app.limit'), "{$name}[limit]", ['type' => 'number', 'default' => 6, 'value' => $value['limit'] ?? null]) }}
