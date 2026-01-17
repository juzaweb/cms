@php
    /** @var \Juzaweb\Modules\Core\Models\Pages\PageBlock $block */
@endphp
<div class='container row'>
    <div class='featured-posts section section' id='featured-posts-{{ $block->id }}' name='Grid Post Section 1'>
        <div class='widget HTML' data-version='2' id='HTML3'>
            <div class='widget-title'>
                <h3 class='title'>
                    {{ $block->label }}
                </h3>
            </div>
            <div class='widget-content'>
                {{ $block->data['limit'] ?? 6 }}/{{ $block->data['category'] ?? 'no' }}/grid-post
            </div>
        </div>
    </div>
</div>