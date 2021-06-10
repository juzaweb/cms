@extends('mymo_core::layouts.backend')

@section('content')

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="float-right">
                <div class="btn-group">
                    <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#tmdb-modal"><i class="fa fa-plus"></i> @lang('movie::app.add_from_tmdb')</a>
                </div>

                <div class="btn-group">
                    <a href="{{ route('admin.movies.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('movie::app.add_new')</a>
                    <button class="btn btn-danger" type="button" id="delete-item"><i class="fa fa-trash"></i> @lang('movie::app.delete')</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <form method="post" class="form-inline">
                @csrf
                <select name="bulk_actions" class="form-control w-60 mb-2 mr-1">
                    <option value="">@lang('mymo_core::app.bulk_actions')</option>
                    <option value="publish">@lang('mymo_core::app.publish')</option>
                    <option value="private">@lang('mymo_core::app.private')</option>
                    <option value="draft">@lang('mymo_core::app.draft')</option>
                    <option value="delete">@lang('mymo_core::app.delete')</option>
                </select>

                <button type="submit" class="btn btn-primary mb-2" id="apply-action">@lang('mymo_core::app.apply')</button>
            </form>
        </div>

        <div class="col-md-8">
            <form action="" method="get" class="form-inline" id="form-search">
                <div class="form-group mb-2 mr-1">
                    <label for="search" class="sr-only">@lang('movie::app.search')</label>
                    <input name="search" type="text" id="search" class="form-control" placeholder="@lang('movie::app.search')" autocomplete="off">
                </div>

                <div class="form-group mb-2 mr-1">
                    <label for="genre" class="sr-only">@lang('movie::app.genre')</label>
                    <select name="genre" id="genre" class="form-control load-taxonomies" data-placeholder="--- @lang('movie::app.genre') ---" data-taxonomy="genres" data-post-type="movies"></select>
                </div>

                <div class="form-group mb-2 mr-1">
                    <label for="country" class="sr-only">@lang('movie::app.country')</label>
                    <select name="country" id="country" class="form-control load-countries" data-placeholder="--- @lang('movie::app.country') ---"></select>
                </div>

                <div class="form-group mb-2 mr-1">
                    <label for="status" class="sr-only">@lang('movie::app.status')</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">--- @lang('movie::app.status') ---</option>
                        <option value="public">@lang('mymo_core::app.public')</option>
                        <option value="private">@lang('mymo_core::app.private')</option>
                        <option value="draft">@lang('mymo_core::app.draft')</option>
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
                    <th data-width="10%" data-field="thumbnail" data-formatter="thumbnail_formatter">@lang('movie::app.thumbnail')</th>
                    <th data-field="name" data-formatter="name_formatter">@lang('movie::app.name')</th>
                    <th data-width="20%" data-field="description">@lang('movie::app.description')</th>
                    <th data-width="15%" data-field="status" data-align="center" data-formatter="status_formatter">@lang('movie::app.status')</th>
                    <th data-width="15%" data-field="options" data-align="center" data-formatter="options_formatter">@lang('movie::app.options')</th>
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
                return '<span class="text-success">'+ mymo.lang.enabled +'</span>';
            }
            return '<span class="text-danger">'+ mymo.lang.disabled +'</span>';
        }

        function options_formatter(value, row, index) {
            let result = '<div class="dropdown d-inline-block mb-2 mr-2">\n' +
                '          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\n' +
                '            Options' +
                '          </button>\n' +
                '          <div class="dropdown-menu" role="menu" style="">\n' +
                '            <a href="'+ row.upload_url +'" class="dropdown-item">Upload videos</a>\n' +
                '            <a href="'+ row.download_url +'" class="dropdown-item">Download videos</a>\n' +
                '            <a href="'+ row.preview_url +'" target="_blank" class="dropdown-item">Preview</a>\n' +
                '          </div>\n' +
                '        </div>';
            return result;
        }

        var table = new MymoTable({
            url: '{{ route('admin.movies.get-data') }}',
            action_url: '{{ route('admin.movies.bulk-actions') }}',
        });
    </script>

@include('movie::movies.form_tmdb')

@endsection
