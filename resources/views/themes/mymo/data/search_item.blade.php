<li>Result for keyword: <strong style="color: red;">aa</strong></li>

<li class="exact_result"><a href="{{ route('watch', [$item->slug]) }}">
        <div class="halim_list_item">
            <div class="image"><img src="{{ $item->getThumbnail() }}" alt></div>
            <span class="label">{{ $item->name }}</span>
            <span class="enName">{{ $item->other_name }}</span>
            <span class="date">{{ $item->created_at->format('Y-m-d') }}</span>
        </div>
    </a>
</li>