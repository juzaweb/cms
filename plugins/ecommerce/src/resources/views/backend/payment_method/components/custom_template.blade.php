{{ Field::textarea(
    trans('ecom::content.payment_description'),
    'data[description]',
    [
        'value' => $data['description'] ?? ''
    ]
) }}