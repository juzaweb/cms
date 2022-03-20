<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-body">
                {{ Field::text($model, 'name') }}

                {{ Field::textarea($model, 'description') }}
            </div>
        </div>

    </div>
</div>