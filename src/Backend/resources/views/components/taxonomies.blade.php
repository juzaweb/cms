@php
    $taxonomies = \Mymo\PostType\PostType::getTaxonomies($postType);
@endphp

@foreach($taxonomies as $taxonomy)
    @component('mymo::components.form_taxonomies', [
        'taxonomy' => $taxonomy,
        'model' => $model
    ])@endcomponent
@endforeach