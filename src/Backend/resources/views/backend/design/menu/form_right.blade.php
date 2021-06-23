<form action="{{ route('admin.design.menu.save') }}" method="post" class="form-ajax">
    <input type="hidden" name="id" value="{{ @$menu->id }}">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" class="form-label">{{ trans('mymo::app.menu_name') }}</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ @$menu->name }}" autocomplete="off">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="btn-group float-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('mymo::app.save') }}</button>
                        <button type="button" class="btn btn-danger delete-menu"><i class="fa fa-trash"></i> {{ trans('mymo::app.delete') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" id="form-menu">

            <div class="dd" id="nestable">
                <ol class="dd-list" id="dd-empty-placeholder"></ol>
            </div>

            <textarea name="content" id="nestable-output" class="form-control d-none"></textarea>
        </div>

        <div class="card-footer">
            <div class="btn-group float-right">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('mymo::app.save') }}</button>
                <button type="button" class="btn btn-danger delete-menu"><i class="fa fa-trash"></i> {{ trans('mymo::app.delete') }}</button>
            </div>
        </div>
    </div>
</form>