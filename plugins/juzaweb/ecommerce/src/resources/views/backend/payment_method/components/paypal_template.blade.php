{{
    Field::select(
        trans('ecom::content.mode'),
        'data[mode]',
        [
            'value' => $data['mode'] ?? '',
            'options' => [
                'sandbox' => trans('ecom::content.sandbox'),
                'live' => trans('ecom::content.live'),
            ],
        ]
    )
}}

{{ Field::text(
    trans('ecom::content.sandbox_client_id'),
    'data[sandbox_client_id]',
    [
        'value' => $data['sandbox_client_id'] ?? ''
    ]
) }}

{{ Field::text(
    trans('ecom::content.sandbox_secret'),
    'data[sandbox_secret]',
    [
        'value' => $data['sandbox_secret'] ?? ''
    ]
) }}

{{ Field::text(
    trans('ecom::content.live_client_id'),
    'data[live_client_id]',
    [
        'value' => $data['live_client_id'] ?? ''
    ]
) }}

{{ Field::text(
    trans('ecom::content.live_secret'),
    'data[live_secret]',
    [
        'value' => $data['live_secret'] ?? ''
    ]
) }}