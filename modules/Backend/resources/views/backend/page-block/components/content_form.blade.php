<div class="page-block-content">
    @php
        $currentTheme = jw_current_theme();
        $themePath = \Juzaweb\CMS\Facades\ThemeLoader::getThemePath($currentTheme);
    @endphp
    <div id="page-block-builder-nestable-{{ $key }}" class="dd jw-widget-builder">
        <ol class="dd-list">
            @foreach($items as $index => $item)

                @php
                    $block = $blocks[$item['block']] ?? null;
                @endphp

                @if(empty($block))
                    @continue
                @endif

                @php
                    $data = $block->get('view')->getData();
                @endphp

                @if(empty($data))
                    @continue
                @endif

                @component('cms::backend.page-block.components.page_block_item', [
                    'data' => $data,
                    'key' => 'block-' . $index,
                    'block' => $block,
                    'contentKey' => $contentKey,
                    'value' => $item,
                ])

                @endcomponent
            @endforeach
        </ol>
    </div>

    <div class="widget-button w-100 text-center">
        <div class="dropdown">
            <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton-{{ $key }}"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ trans('cms::app.add_block') }}
            </button>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{ $key }}">
                @foreach($blocks as $bkey => $b)
                    <a
                            href="javascript:void(0)"
                            class="dropdown-item add-block-data"
                            data-block="{{ $bkey }}"
                            data-key="{{ $key }}"
                            data-content_key="{{ $contentKey }}"
                    >{{ $b->get('label') }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>

