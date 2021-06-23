@extends('mymo::layouts.backend')

@section('content')

    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="btn-group float-right">
                <a href="{{ route('admin.users.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('mymo::app.add_new')</a>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <form method="post" class="form-inline">
                @csrf
                <select name="bulk_actions" class="form-control w-60 mb-2 mr-1">
                    <option value="">@lang('mymo::app.bulk_actions')</option>
                    <option value="delete">@lang('mymo::app.delete')</option>
                </select>

                <button type="submit" class="btn btn-primary mb-2" id="apply-action">@lang('mymo::app.apply')</button>
            </form>
        </div>

        <div class="col-md-8">
            <form method="get" class="form-inline" id="form-search">

                <div class="form-group mb-2 mr-1">
                    <label for="inputName" class="sr-only">@lang('mymo::app.search')</label>
                    <input name="search" type="text" id="inputName" class="form-control" placeholder="@lang('mymo::app.search')" autocomplete="off">
                </div>

                <div class="form-group mb-2 mr-1">
                    <label for="inputStatus" class="sr-only">@lang('mymo::app.status')</label>
                    <select name="status" id="inputStatus" class="form-control">
                        <option value="">--- @lang('mymo::app.status') ---</option>
                        <option value="1">@lang('mymo::app.enabled')</option>
                        <option value="0">@lang('mymo::app.disabled')</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> @lang('mymo::app.search')</button>
            </form>
        </div>

    </div>

    <div class="table-responsive mb-5">
        <table class="table mymo-table">
            <thead>
            <tr>
                <th data-width="3%" data-field="state" data-checkbox="true"></th>
                <th data-width="10%" data-field="thumbnail" data-formatter="thumbnail_formatter">@lang('mymo::app.thumbnail')</th>
                <th data-field="name" data-formatter="name_formatter">@lang('mymo::app.name')</th>
                <th data-width="15%" data-field="email">@lang('mymo::app.email')</th>
                <th data-width="15%" data-field="created">@lang('mymo::app.created_at')</th>
                <th data-width="15%" data-field="status" data-align="center" data-formatter="status_formatter">@lang('mymo::app.status')</th>
            </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        function thumbnail_formatter(value, row, index) {
            return `<img src="${row.thumb_url}" class="w-100">`;
        }

        function name_formatter(value, row, index) {
            return `<a href="${row.edit_url}">${value}</a>`;
        }

        function status_formatter(value, row, index) {
            switch (row.status) {
                case 'active':
                    return `<span class="text-success">${mymo.lang.active}</span>`;
                case 'unconfirmed':
                    return `<span class="text-warning">${mymo.lang.unconfirmed}</span>`;
                case 'banned':
                    return `<span class="text-danger">${mymo.lang.banned}</span>`;
            }

            return `<span class="text-danger">${mymo.lang.disabled}</span>`;
        }

        var table = new MymoTable({
            url: '{{ route('admin.users.get-data') }}',
            action_url: '{{ route('admin.users.bulk-actions') }}',
        });
    </script>
@endsection