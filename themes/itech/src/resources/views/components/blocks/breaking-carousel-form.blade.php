{{ Field::select(__('itech::translation.post_type'), "{$name}[type]", ['value' => $data['type'] ?? 'recent'])->dropDownList(
    [
        'recent' => __('itech::translation.recent_posts'),
        'random' => __('itech::translation.random_posts'),
    ],
) }}

{{ Field::text(__('itech::translation.limit'), "{$name}[limit]", ['value' => $data['limit'] ?? '6', 'type' => 'number']) }}
