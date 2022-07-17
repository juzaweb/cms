@if($taxonomy->get('taxonomy') == 'tags')
    @include('cms::components.form.tags')
@else
    @include('cms::components.form.categories')
@endif
