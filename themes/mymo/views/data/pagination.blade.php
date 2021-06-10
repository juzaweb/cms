@if ($paginator->hasPages())
<ul class='page-numbers'>
    @if (!$paginator->onFirstPage())
        <li><a href="{{ $paginator->previousPageUrl() }}" class="prev page-numbers" title="@lang('pagination.previous')"><i class="hl-down-open rotate-left"></i></a></li>
    @endif

    @foreach ($elements as $element)
        @if(is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li><span aria-current="page" class="page-numbers current">{{ $page }}</span></li>
                @else
                    <li><a class="page-numbers" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
    {{--<li><span class="page-numbers dots">&hellip;</span></li>
    <li><a class="page-numbers" href="/phim-moi-nhat/page/156">156</a></li>--}}
    @if ($paginator->hasMorePages())
    <li><a class="next page-numbers" href="{{ $paginator->nextPageUrl() }}" title="@lang('pagination.next')"><i class="hl-down-open rotate-right"></i></a></li>
    @endif
</ul>
@endif