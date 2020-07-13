<div class="item post-{{ $item->id }}">
    <a href="{{ route('watch', [$model->slug]) }}" title="{{ $model->name }}{{ $model->other_name ? ' - ' . $model->other_name : '' }}">
        <div class="item-link">
            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="{{ $item->getThumbnail() }}" class="lazyload blur-up post-thumb" alt="{{ $model->name }}{{ $model->other_name ? ' - ' . $model->other_name : '' }}" title="{{ $model->name }}{{ $model->other_name ? ' - ' . $model->other_name : '' }}" />
        </div>
        <h3 class="title">{{ $model->name }}</h3>
        <p class="original_title">{{ $model->other_name }} ({{ @explode('-', $item->release)[0] }})</p>
    </a>
    <div class="viewsCount">{{ $item->getViews() }} @lang('app.views')</div>
</div>