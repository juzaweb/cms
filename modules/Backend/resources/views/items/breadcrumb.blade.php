<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ trans('cms::app.dashboard') }}</a></li>

        @foreach($items as $item)
            @if(isset($item['url']))
                <li class="breadcrumb-item"><a href="{{ $item['url'] }}" class="text-capitalize">{{ $item['title'] }}</a></li>
            @else
                <li class="breadcrumb-item text-capitalize active" aria-current="page">{{ $item['title'] }}</li>
            @endif
        @endforeach
    </ol>
</nav>
