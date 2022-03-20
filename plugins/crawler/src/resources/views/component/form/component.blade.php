
<div id="components">
    <table class="table" id="components-table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Element</th>
                <th>Attr</th>
                <th>Index</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        @if($model->components)
            @foreach($model->components as $component)
                @component('crawler::component.templates.component', [
                    'marker' => 'component-' . $component->id,
                    'item' => $component
                ])
                @endcomponent
            @endforeach
        @endif
        </tbody>
    </table>

    <div class="row mt-2 mb-3 justify-content-md-center">
        <div class="col-md-3">
            <a
                href="javascript:void(0)"
                id="add-component"
                class="btn btn-primary"
            >
                <i class="fa fa-plus"></i> Add Component
            </a>
        </div>
    </div>

    <template id="component-template">
        @component('crawler::component.templates.component', [
            'marker' => '{marker}'
        ])
        @endcomponent
    </template>
</div>