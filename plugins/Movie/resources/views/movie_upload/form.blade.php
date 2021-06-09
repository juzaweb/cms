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
                'name' => trans('app.servers'),
                'url' => route('admin.movies.servers', [$page_type, $movie->id])
            ],
            [
                'name' => $server->name,
                'url' => route('admin.movies.servers', [$page_type, $movie->id])
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
            'name' => trans('app.servers'),
            'url' => route('admin.movies.servers', [$page_type, $movie->id])
        ],
        [
            'name' => $server->name,
            'url' => route('admin.movies.servers', [$page_type, $movie->id])
        ]
    ], $model) }}
    @endif

    <div class="cui__utils__content">
        <form method="post" action="{{ route('admin.movies.servers.upload.save', [$page_type, $server->id]) }}" class="form-ajax">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
                        </div>

                        <div class="col-md-6">
                            <div class="btn-group float-right">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('app.save')</button>
                                <a href="{{ route('admin.movies.servers.upload', [$page_type, $server->id]) }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('app.cancel')</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">

                            <input type="hidden" name="id" id="id" value="{{ $model->id }}">

                            <div class="form-group">
                                <label class="col-form-label" for="label">@lang('app.label')</label>

                                <input type="text" name="label" class="form-control" id="label" autocomplete="off" required value="{{ $model->label }}">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="order">@lang('app.order')</label>

                                <input type="text" name="order" class="form-control" id="order" autocomplete="off" required value="{{ $model->order ? $model->order : 1 }}">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="source">@lang('app.source')</label>
                                <select name="source" id="source" class="form-control" required>
                                    <option value="">--- @lang('app.source') ---</option>
                                    <option value="youtube">Youtube</option>
                                    <option value="vimeo">Vimeo</option>
                                    <option value="gdrive">Google Drive</option>
                                    <option value="mp4" selected>MP4 From URL</option>
                                    <option value="mkv">MKV From URL</option>
                                    <option value="webm">WEBM From URL</option>
                                    <option value="m3u8">M3U8 From URL</option>
                                    <option value="embed">Embed URL</option>
                                </select>
                            </div>

                            <div class="form-group form-url">
                                <label class="col-form-label" for="url">@lang('app.video_url')</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" name="url" id="url" class="form-control" autocomplete="off" value="{{ $model->url }}">
                                    </div>

                                    <div class="col-md-2">
                                        <a href="javascript:void(0)" class="btn btn-primary lfm-file" data-input="url"><i class="fa fa-upload"></i> @lang('app.upload')</a>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>

                    <input type="hidden" name="id" value="{{ $model->id }}">
                </div>
            </div>
        </form>

    </div>
@endsection
