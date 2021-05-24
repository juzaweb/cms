@foreach($items as $item)
    <article class="col-md-2 col-sm-4 col-xs-6 thumb grid-item post-{{ $item->id }}">
    @include('data.item')
    </article>
@endforeach