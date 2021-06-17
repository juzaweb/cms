@php
    $taxonomies = \Mymo\PostType\PostType::getTaxonomies($postType);
@endphp

@foreach($taxonomies as $taxonomy)
    @component('mymo_core::components.form_taxonomies', [
        'taxonomy' => $taxonomy,
        'model' => $model
    ])@endcomponent
@endforeach