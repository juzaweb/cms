@foreach($items as $item)
    <article class="col-md-2 col-sm-4 col-xs-6 thumb grid-item post-{{ $item->id }}">
    @include('themes.mymo.data.item')
    </article>
@endforeach