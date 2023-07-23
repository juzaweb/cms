<div class="theme-editor__panel" id="panel-{{ $id }}" tabindex="-1">
    @php
    $childs = $panel->get('childs', collect([]));
    @endphp
    <header class="te-panel__header">
        <button class="ui-button btn--plain te-panel__header-action" data-bind-event-click="closeSection()" data-trekkie-id="close-panel" aria-label="Back to theme settings" type="button" name="button">

            <svg class="next-icon next-icon--size-20 next-icon--rotate-180 te-panel__header-action-icon">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#next-chevron"></use>
            </svg>
        </button>

        <h2 class="ui-heading theme-editor__heading">{{ $panel->get('title') }}</h2>
    </header>

    @if($childs->isNotEmpty())
    <div class="theme-editor__panel-body" data-scrollable>
        <div class="ui-stack ui-stack--vertical next-tab__panel--grow">
            <div class="ui-stack-item ui-stack-item--fill">
                <section class="next-card theme-editor__card">
                    <ul class="theme-editor-action-list theme-editor-action-list--divided theme-editor-action-list--rounded">
                        @foreach($childs as $keyChild => $child)
                            @component('cms::backend.editor.components.action_item', [
                        'title' => $child->get('title'),
                        'key' => $keyChild,
                        'id' => 'section-' . $keyChild
                    ])
                            @endcomponent
                        @endforeach
                    </ul>
                </section>
            </div>
        </div>
    </div>
    @endif

    @php
        $controls = $panel->get('controls', collect([]));
    @endphp

    @if($controls->isNotEmpty())
        @component('cms::backend.editor.components.editor_card', [
            'key' => $key,
            'id' => $key,
            'title' => $panel->get('title')
        ])

            @foreach($controls as $control)
                {{ $control->get('control')->contentTemplate() }}
            @endforeach

        @endcomponent
    @endif

</div>

@foreach($childs as $keyChild => $child)

    @component('cms::backend.editor.components.editor_panel', [
        'key' => $keyChild,
        'id' => 'section-' . $keyChild,
        'panel' => $child
    ])

    @endcomponent

@endforeach
