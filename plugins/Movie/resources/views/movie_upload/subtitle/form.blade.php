@extends('mymo_core::layouts.backend')

@section('title', $title)

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
        ], $model) }}
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
    ], $model) }}
    @endif

    <div class="cui__utils__content">
        <form method="post" action="{{ route('admin.movies.servers.upload.subtitle.save', [$page_type, $file_id]) }}" class="form-ajax">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
                        </div>

                        <div class="col-md-6">
                            <div class="btn-group float-right">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('app.save')</button>
                                <a href="{{ route('admin.movies.servers.upload.subtitle', [$page_type, $file_id]) }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('app.cancel')</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label class="col-form-label" for="label">@lang('app.label')</label>

                                <input type="text" name="label" class="form-control" id="label" value="{{ $model->label }}" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="url">@lang('app.url')</label>
                                <input type="text" name="url" class="form-control" id="url" value="{{ $model->url }}" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="order">@lang('app.order')</label>
                                <input type="number" name="order" class="form-control" id="order" value="{{ $model->order ?? 1 }}" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="status">@lang('app.status')</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" @if($model->status == 1) selected @endif>@lang('app.enabled')</option>
                                    <option value="0" @if($model->status == 0 && !is_null($model->status)) selected @endif>@lang('app.disabled')</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="{{ $model->id }}">
                </div>
            </div>
        </form>

    </div>
@endsection
