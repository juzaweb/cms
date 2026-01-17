@php
    /** @var \Juzaweb\Modules\Core\Models\Pages\PageBlock $block */
@endphp
<div class='row' id='break-wrapper'>
    <div class='section' id='break-section' name='News Ticker'>
        <div class='widget HTML' data-version='2' id='HTML2'>
            <div class='widget-title'>
                <h3 class='title'>
                    Ticker
                </h3>
            </div>
            <div class='widget-content'>
                {{ $block->data['limit'] ?? 6 }}/{{ $block->data['type'] ?? 'recent' }}/ticker-posts
            </div>
        </div>
    </div>
</div>
