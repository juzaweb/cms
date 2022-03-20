<hr>

<div id="removes">

    <table class="table" id="removes-table">
        <thead>
            <tr>
                <th>Element</th>
                <th>Index</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        @if($model->removes)
            @foreach($model->removes as $remove)
                @component('crawler::component.templates.remove', [
                    'marker' => 'remove-' . $remove->id,
                    'item' => $remove,
                ])
                @endcomponent
            @endforeach
        @endif
        </tbody>
    </table>

    <div class="row mt-2 justify-content-md-center">
        <div class="col-md-3">
            <a
                href="javascript:void(0)"
                id="add-remove"
                class="btn btn-primary"
            >
                <i class="fa fa-plus"></i> Add Remove Element
            </a>
        </div>
    </div>

    <template id="remove-template">
        @component('crawler::component.templates.remove', [
            'marker' => '{marker}'
        ])
        @endcomponent
    </template>
</div>