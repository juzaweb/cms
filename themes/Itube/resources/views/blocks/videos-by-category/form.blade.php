
{{ Field::text(__('itube::translation.label'), "{$name}[label]", ['value' => $data['label'] ?? '']) }}

@php
    $categoryId = $data['category'] ?? '';
    $selectedCategory = [];
    if ($categoryId) {
        $category = \Juzaweb\Modules\VideoSharing\Models\VideoCategory::find($categoryId);
        if ($category) {
            $selectedCategory = [$category->id => $category->name];
        }
    }
@endphp

{{ Field::select(__('itube::translation.category'), "{$name}[category]", ['value' => $categoryId])
->dataUrl(load_data_url(\Juzaweb\Modules\VideoSharing\Models\VideoCategory::class, 'name'))
->dropDownList($selectedCategory) }}

{{ Field::text(__('itube::translation.limit'), "{$name}[limit]", ['value' => $data['limit'] ?? '12', 'type' => 'number']) }}
