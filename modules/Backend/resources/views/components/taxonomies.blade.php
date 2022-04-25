@php
    $taxonomies = \Juzaweb\CMS\Facades\HookAction::getTaxonomies($postType);
@endphp

@foreach($taxonomies as $taxonomy)
    @component('cms::components.form_taxonomies', [
        'taxonomy' => $taxonomy,
        'model' => $model
    ])@endcomponent
@endforeach
