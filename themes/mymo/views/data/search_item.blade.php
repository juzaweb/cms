<li>@lang('theme::app.result_for_keyword'): <strong class="text-danger">{{ $keyword }}</strong></li>
@foreach($items as $item)
<li class="exact_result">
    <a href="{{ route('watch', [$item->slug]) }}" title="{{ $item->name }}{{ $item->other_name ? ' - ' . $item->other_name : '' }}">
        <div class="mymo_list_item">
            <div class="image"><img src="{{ $item->getThumbnail() }}" alt="{{ $item->name }}{{ $item->other_name ? ' - ' . $item->other_name : '' }}"></div>
            <span class="label">{{ $item->name }}</span>
            <span class="enName">{{ $item->other_name }}</span>
            <span class="date">{{ $item->created_at->format('Y-m-d') }}</span>
        </div>
    </a>
</li>
@endforeach