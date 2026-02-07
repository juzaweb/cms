{{ Field::text(__('itech::translation.label'), "{$name}[label]", ['value' => $data['label'] ?? '']) }}

{{ Field::select(__('itech::translation.category'), "{$name}[category]", ['value' => $data['category'] ?? ''])
->dataUrl(load_data_url(\Juzaweb\Modules\Blog\Models\Category::class, 'name'))
->dropDownList(
    \Juzaweb\Modules\Blog\Models\Category::where('id', $data['category'] ?? '')->get()->pluck('name', 'id')->toArray(),
) }}

