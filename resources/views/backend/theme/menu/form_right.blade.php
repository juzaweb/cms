<form action="{{ route('admin.theme.menu.save') }}" method="post" class="form-ajax">
    <input type="hidden" name="id" value="{{ @$menu->id }}">
    <div class="card">
        <div class="card-header">
            <div class="form-group w-50">
                <label for="name" class="form-label">{{ trans('main.menu_name') }}</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ @$menu->name }}">
            </div>

            <div class="btn-group ml-auto">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('main.save') }}</button>
                <button type="button" class="btn btn-danger delete-menu"><i class="fa fa-trash"></i> {{ trans('main.delete') }}</button>
            </div>
        </div>
        <div class="card-body" id="form-menu">

            <div class="dd" id="nestable">
                <ol class="dd-list" id="dd-empty-placeholder">
                </ol>
            </div>

            <textarea name="setting" id="nestable-output" class="form-control d-none"></textarea>
        </div>

        <div class="card-footer">
            <div class="btn-group ml-auto">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('main.save') }}</button>
                <button type="button" class="btn btn-danger delete-menu"><i class="fa fa-trash"></i> {{ trans('main.delete') }}</button>
            </div>
        </div>
    </div>
</form>