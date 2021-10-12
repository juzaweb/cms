@component('juzaweb::widgets.upload_image', [
    'label' => trans('theme::app.banner'),
    'name' => 'banner',
    'value' => $data['banner'] ?? ''
])
@endcomponent