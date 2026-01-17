{{ Field::text(__('itech::translation.label'), "content[{$data['key']}][label]", ['value' => data_get($data, 'label')]) }}

{{ Field::text(__('itech::translation.number_of_posts_to_show'), "content[{$data['key']}][limit]", ['value' => data_get($data, 'limit', 5), 'min' => 1, 'type' => 'number']) }}

