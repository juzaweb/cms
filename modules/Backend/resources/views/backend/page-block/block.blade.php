@php
    $blocks = \Juzaweb\CMS\Facades\HookAction::getPageBlocks();
    $templateBlocks = $templateData['blocks'] ?? [];
    $currentTheme = jw_current_theme();
    $themePath = \Juzaweb\CMS\Facades\ThemeLoader::getThemePath($currentTheme);
    $key = \Illuminate\Support\Str::random(15);
@endphp

@foreach($templateBlocks as $contentKey => $block)
    @php
        $items = $model->getMeta('block_content', [])[$contentKey] ?? [];
    @endphp
    @component('cms::components.card', [
        'label' => $block['label']
    ])
        @component('cms::backend.page-block.components.content_form', compact(
            'key',
            'block',
            'blocks',
            'contentKey',
            'items'
        ))
        @endcomponent
    @endcomponent
@endforeach

@foreach($blocks as $bkey => $block)
    @php
        $data = $block->get('view')->getData();
    @endphp

    @if(empty($data))
        @continue
    @endif

    <template id="block-{{ $bkey }}-template">
        @component('cms::backend.page-block.components.page_block_item', [
            'data' => $data,
            'key' => '{marker}',
            'block' => $block,
            'contentKey' => '{content_key}',
        ])

        @endcomponent
    </template>
@endforeach
