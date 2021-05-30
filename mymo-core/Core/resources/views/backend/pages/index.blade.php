@extends('mymo_core::layouts.backend')

@section('content')

    <div class="row">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="btn-group float-right">
                <a href="{{ route('admin.page.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('mymo_core::app.add_new')</a>
                <button type="button" class="btn btn-danger" id="delete-item"><i class="fa fa-trash"></i> @lang('mymo_core::app.delete')</button>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <form method="get" class="form-inline" id="form-search">

                <div class="form-group mb-2 mr-1">
                    <label for="inputName" class="sr-only">@lang('mymo_core::app.search')</label>
                    <input name="search" type="text" id="inputName" class="form-control" placeholder="@lang('mymo_core::app.search')" autocomplete="off">
                </div>

                <div class="form-group mb-2 mr-1">
                    <label for="inputStatus" class="sr-only">@lang('mymo_core::app.status')</label>
                    <select name="status" id="inputStatus" class="form-control">
                        <option value="">--- @lang('mymo_core::app.status') ---</option>
                        <option value="1">@lang('mymo_core::app.enabled')</option>
                        <option value="0">@lang('mymo_core::app.disabled')</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> @lang('mymo_core::app.search')</button>
            </form>
        </div>

    </div>

    <div class="table-responsive mb-5">
        <table class="table load-bootstrap-table">
            <thead>
            <tr>
                <th data-width="3%" data-field="state" data-checkbox="true"></th>
                <th data-width="10%" data-field="thumbnail" data-formatter="thumbnail_formatter">@lang('mymo_core::app.thumbnail')</th>
                <th data-field="name" data-formatter="name_formatter">@lang('mymo_core::app.name')</th>

                <th data-width="15%" data-field="created">@lang('mymo_core::app.created_at')</th>
                <th data-width="15%" data-field="status" data-align="center" data-formatter="status_formatter">@lang('mymo_core::app.status')</th>
            </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        function thumbnail_formatter(value, row, index) {
            return '<img src="'+ row.thumb_url +'" class="w-100">';
        }

        function name_formatter(value, row, index) {
            return '<a href="'+ row.edit_url +'">'+ value +'</a>';
        }

        function status_formatter(value, row, index) {
            if (value == 1) {
                return '<span class="text-success">@lang('mymo_core::app.enabled')</span>';
            }
            return '<span class="text-danger">@lang('mymo_core::app.disabled')</span>';
        }

        var table = new MymoTable({
            url: '{{ route('admin.page.getdata') }}',
            action_url: '{{ route('admin.page.remove') }}',
        });
    </script>
@endsection