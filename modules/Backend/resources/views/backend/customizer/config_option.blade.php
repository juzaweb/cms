<div class="theme-editor__panel-body">
    <div class="ui-stack ui-stack--vertical next-tab__panel--grow">
        <div class="ui-stack-item ui-stack-item--fill">
            <section class="next-card theme-editor__card">
                <ul class="theme-editor-action-list theme-editor-action-list--divided theme-editor-action-list--rounded">
                    @foreach($panels as $key => $panel)
                        @component('cms::backend.customizer.components.action_item', [
                            'title' => $panel->get('title'),
                            'key' => $key,
                            'id' => 'panel-' . $key,
                        ])
                        @endcomponent
                    @endforeach
                </ul>
            </section>
        </div>
    </div>
</div>

@foreach($panels as $key => $panel)

    @component('cms::backend.editor.components.editor_panel', [
        'key' => $key,
        'id' => 'panel-' . $key,
        'panel' => $panel
    ])

    @endcomponent

@endforeach
