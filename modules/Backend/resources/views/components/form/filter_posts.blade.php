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

        $option = array_merge(
            ['options' => $typeOptions, 'value' => $value['type'] ?? null],
             Arr::get($options ?? [], 'fields.type', [])
        );
    @endphp

    {{ Field::select(trans('cms::app.post_type'), "{$name}[type]", $option) }}
@else
    <input type="hidden" name="{{"{$name}[type]"}}" value="{{ $options['type'] }}">
@endif

@php
    $multiple = Arr::get($options, 'fields.taxonomy.multiple', false);
    $fieldName = $multiple ? 'taxonomies' : 'taxonomy';
    $option = array_merge(
        ['multiple' => $multiple, 'post_type' => $options['type'] ?? null, 'value' => $value[$fieldName] ?? null],
         Arr::get($options, "fields.{$fieldName}", [])
    );
@endphp

{{ Field::selectTaxonomy(trans("cms::app.{$fieldName}"), "{$name}[{$fieldName}]", $option) }}

<div class="row">
    @php
        $option = array_merge(
            [
                'options' => [
                    'id' => 'ID',
                    'views' => 'Views'
                ],
                 'value' => $value['sort_by'] ?? null
            ],
             Arr::get($options, 'fields.sort_by', [])
        );
    @endphp
    <div class="col-md-6">
        {{ Field::select(trans('cms::app.sort_by'), "{$name}[sort_by]", $option) }}
    </div>
    <div class="col-md-6">
        @php
            $option = array_merge(
                [
                    'options' => [
                        'asc' => 'ASC',
                        'desc' => 'DESC'
                    ],
                     'value' => $value['sort_order'] ?? null
                ],
                 Arr::get($options, 'fields.sort_order', [])
            );
        @endphp

        {{ Field::select(trans('cms::app.sort_order'), "{$name}[sort_order]", $option) }}
    </div>
</div>

@php
    $option = array_merge(
        ['type' => 'number', 'default' => 6, 'value' => $value['limit'] ?? null],
         Arr::get($options, 'fields.taxonomy', [])
    );
@endphp

{{ Field::text(trans('cms::app.limit'), "{$name}[limit]", $option) }}
