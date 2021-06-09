@extends('mymo_core::layouts.backend')

@section('title', trans('app.subtitle'))

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
                'name' => $file->server->name,
                'url' => route('admin.movies.servers', [$page_type, $movie->id])
            ],
            [
                'name' => $file->label,
                'url' => route('admin.movies.servers.upload', [$page_type, $file->server->id])
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
            'name' => $file->server->name,
            'url' => route('admin.movies.servers', [$page_type, $movie->id])
        ],
        [
            'name' => $file->label,
            'url' => route('admin.movies.servers.upload', [$page_type, $file->server->id])
        ]
    ]) }}
    @endif

    <div class="cui__utils__content">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">@lang('app.subtitle')</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="btn-group float-right">
                            <a href="{{ route('admin.movies.servers.upload.subtitle.create', [$page_type, $file_id]) }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('app.add_new')</a>
                            <button type="button" class="btn btn-danger" id="delete-item"><i class="fa fa-trash"></i> @lang('app.delete')</button>
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
                    <table class="table mymo-table">
                        <thead>
                            <tr>
                                <th data-width="3%" data-field="state" data-checkbox="true"></th>
                                <th data-field="label" data-formatter="label_formatter" data-width="15%">@lang('app.label')</th>
                                <th data-field="url">@lang('app.url')</th>
                                <th data-width="15%" data-field="created">@lang('app.created_at')</th>
                                <th data-width="15%" data-field="status" data-align="center" data-formatter="status_formatter">@lang('app.status')</th>
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
                return '<span class="text-success">@lang('app.enabled')</span>';
            }
            return '<span class="text-danger">@lang('app.disabled')</span>';
        }

        var table = new MymoTable({
            url: '{{ route('admin.movies.servers.upload.subtitle.getdata', [$page_type, $file_id]) }}',
            remove_url: '{{ route('admin.movies.servers.upload.subtitle.remove', [$page_type, $file_id]) }}',
        });
    </script>
@endsection