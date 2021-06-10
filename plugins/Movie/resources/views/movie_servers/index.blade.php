@extends('mymo_core::layouts.backend')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="btn-group float-right">
                <a href="{{ route('admin.movies.servers.create', [$page_type, $movie->id]) }}" class="btn btn-success add-new-server"><i class="fa fa-plus-circle"></i> @lang('movie::app.add_new')</a>
                <button type="button" class="btn btn-danger" id="delete-item"><i class="fa fa-trash"></i> @lang('movie::app.delete')</button>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <form method="get" class="form-inline" id="form-search">
                <div class="form-group mb-2 mr-1">
                    <label for="inputName" class="sr-only">@lang('movie::app.search')</label>
                    <input name="search" type="text" id="inputName" class="form-control" placeholder="@lang('movie::app.search')" autocomplete="off">
                </div>

                <div class="form-group mb-2 mr-1">
                    <label for="status" class="sr-only">@lang('movie::app.status')</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">--- @lang('movie::app.status') ---</option>
                        <option value="1">@lang('movie::app.enabled')</option>
                        <option value="0">@lang('movie::app.disabled')</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> @lang('movie::app.search')</button>
            </form>
        </div>
    </div>

    <div class="table-responsive mb-5">
        <table class="table mymo-table">
            <thead>
                <tr>
                    <th data-width="3%" data-field="state" data-checkbox="true"></th>
                    <th data-field="name">@lang('movie::app.name')</th>
                    <th data-width="10%" data-field="order" data-align="center">@lang('movie::app.order')</th>
                    <th data-width="15%" data-field="created">@lang('movie::app.created_at')</th>
                    <th data-width="15%" data-field="status" data-align="center" data-formatter="status_formatter">@lang('movie::app.status')</th>
                    <th data-width="20%" data-field="options" data-align="center" data-formatter="options_formatter">@lang('movie::app.options')</th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        function status_formatter(value, row, index) {
            if (value == 1) {
                return '<span class="text-success">@lang('movie::app.enabled')</span>';
            }
            return '<span class="text-danger">@lang('movie::app.disabled')</span>';
        }

        function options_formatter(value, row, index) {
            let result = '<a href="'+ row.upload_url +'" class="btn btn-success btn-sm"><i class="fa fa-upload"></i> @lang('movie::app.upload_videos')</a>';
            return result;
        }

        var table = new MymoTable({
            url: '{{ route('admin.movies.servers.getdata', [$page_type, $movie->id]) }}',
            remove_url: '{{ route('admin.movies.servers.remove', [$page_type, $movie->id]) }}',
        });

    </script>
@endsection