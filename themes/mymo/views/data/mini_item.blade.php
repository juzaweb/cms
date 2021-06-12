<div class="item post-{{ $item->id }}">
    <a href="{{ route('watch', [$item->slug]) }}" title="{{ $item->name }}{{ $item->other_name ? ' - ' . $item->other_name : '' }}">
        <div class="item-link">
            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="{{ $item->getThumbnail() }}" class="lazyload blur-up post-thumb" alt="{{ $item->name }}{{ $item->other_name ? ' - ' . $item->other_name : '' }}" title="{{ $item->name }}{{ $item->other_name ? ' - ' . $item->other_name : '' }}" />
        </div>
        <h3 class="title">{{ $item->name }}</h3>
        <p class="original_title">{{ $item->other_name }} ({{ $item->year }})</p>
    </a>
    <div class="viewsCount">{{ $item->getViews() }} @lang('theme::app.views')</div>
</div>