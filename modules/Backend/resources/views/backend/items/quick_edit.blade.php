<form method="post" action="{{ route('admin.posts.update', [$row->type, $row->id]) }}" class="form-ajax">
    @method('PUT')

    <div class="row">
        <div class="col-md-6">
            {{ Field::text($row, 'title') }}
        </div>

        <div class="col-md-3">
            {{ Field::select($row, 'status', [
                'options' => $row->getStatuses()
            ]) }}
        </div>
    </div>

    <div class="row">

    </div>

    <div class="row">
        <div class="col-md-6">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-save"></i> {{ trans('cms::app.save') }}
            </button>
        </div>
    </div>
</form>
