
{{ Field::text(__('itube::translation.label'), "{$name}[label]", ['value' => $data['label'] ?? '']) }}

{{ Field::text(__('itube::translation.limit'), "{$name}[limit]", ['value' => $data['limit'] ?? '8', 'type' => 'number']) }}
