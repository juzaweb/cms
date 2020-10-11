@extends('layouts.backend')

@section('title', trans('app.upload'))

@section('content')

    @if($movie->tv_series == 0)
    {{ Breadcrumbs::render('multiple_parent', [
        [
            'name' => trans('app.movies'),
            'url' => route('admin.movies')
        ],
        [
            'name' => $movie->name,
            'url' => route('admin.movies.edit', ['id' => $movie->id])
        ],
        [
            'name' => trans('app.servers'),
            'url' => route('admin.movies.servers', [$page_type, $movie->id])
        ],
        [
            'name' => $server->name,
            'url' => route('admin.movies.servers', [$page_type, $movie->id])
        ]
    ]) }}
    @else
        {{ Breadcrumbs::render('multiple_parent', [
        [
            'name' => trans('app.tv_series'),
            'url' => route('admin.tv_series')
        ],
        [
            'name' => $movie->name,
            'url' => route('admin.tv_series.edit', ['id' => $movie->id])
        ],
        [
            'name' => trans('app.servers'),
            'url' => route('admin.movies.servers', [$page_type, $movie->id])
        ],
        [
            'name' => $server->name,
            'url' => route('admin.movies.servers', [$page_type, $movie->id])
        ]
    ]) }}
    @endif

    <div class="cui__utils__content">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">@lang('app.upload_videos')</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="float-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-success status-button" data-status="1"><i class="fa fa-check-circle"></i> @lang('app.enabled')</button>
                                <button type="button" class="btn btn-warning status-button" data-status="0"><i class="fa fa-times-circle"></i> @lang('app.disabled')</button>
                            </div>

                            <div class="btn-group">
                                <a href="{{ route('admin.movies.servers.upload.create', [$page_type, $server->id]) }}" class="btn btn-success add-new-video"><i class="fa fa-plus-circle"></i> @lang('app.add_video')</a>
                                <button type="button" class="btn btn-danger" id="delete-item"><i class="fa fa-trash"></i> @lang('app.delete')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-12">
                        <form method="get" class="form-inline" id="form-search">

                            <div class="form-group mb-2 mr-1">
                                <label for="inputName" class="sr-only">@lang('app.search')</label>
                                <input name="search" type="text" id="inputName" class="form-control" placeholder="@lang('app.search')" autocomplete="off">
                            </div>

                            <div class="form-group mb-2 mr-1">
                                <label for="inputStatus" class="sr-only">@lang('app.status')</label>
                                <select name="status" id="inputStatus" class="form-control">
                                    <option value="">--- @lang('app.status') ---</option>
                                    <option value="1">@lang('app.enabled')</option>
                                    <option value="0">@lang('app.disabled')</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> @lang('app.search')</button>
                        </form>
                    </div>
                </div>

                <div class="table-responsive mb-5">
                    <table class="table load-bootstrap-table">
                        <thead>
                        <tr>
                            <th data-width="3%" data-field="state" data-checkbox="true"></th>
                            <th data-field="label" data-width="15%" data-formatter="label_formatter">@lang('app.label')</th>
                            <th data-field="url">@lang('app.url')</th>
                            <th data-field="source" data-width="10%">@lang('app.source')</th>
                            <th data-field="order" data-width="10%" data-align="center">@lang('app.order')</th>
                            <th data-width="15%" data-field="status" data-align="center" data-formatter="status_formatter">@lang('app.status')</th>
                            <th data-width="15%" data-field="action" data-align="center" data-formatter="action_formatter">@lang('app.action')</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function label_formatter(value, row, index) {
            return '<a href="'+ row.edit_url +'">'+ value +'</a>';
        }

        function status_formatter(value, row, index) {
            if (value == 1) {
                return '<span class="text-success">'+ langs.enabled +'</span>';
            }
            return '<span class="text-danger">'+ langs.disabled +'</span>';
        }

        function action_formatter(value, row, index) {
            let str = '';
            str += '<a href="'+ row.subtitle_url +'" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> '+ langs.add_subtitle +'</a>';
            return str;
        }

        var table = new LoadBootstrapTable({
            url: '{{ route('admin.movies.servers.upload.getdata', [$page_type, $server->id]) }}',
            remove_url: '{{ route('admin.movies.servers.upload.remove', [$page_type, $server->id]) }}',
        });
    </script>
@endsection