@extends('layouts.backend')

@section('title', $title)

@section('content')

    {{ Breadcrumbs::render('manager', [
            'name' => trans('app.subtitle'),
            'url' => route('admin.movies.servers.upload.subtitle', [$file_id])
        ], $model) }}

    <div class="cui__utils__content">
        <form method="post" action="{{ route('admin.movies.servers.upload.save', [$server->id]) }}" class="form-ajax">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
                        </div>

                        <div class="col-md-6">
                            <div class="btn-group float-right">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('app.save')</button>
                                <a href="{{ route('admin.movies.servers.upload.subtitle', [$file_id]) }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('app.cancel')</a>
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
                                    <option value="upload">Upload</option>
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
                                <input type="text" name="url" id="url" class="form-control" autocomplete="off" value="{{ $model->url }}"> <a href="javascript:void(0)" class="btn btn-primary lfm-file" data-input="url"><i class="fa fa-upload"></i> @lang('app.upload')</a>
                            </div>


                        </div>
                    </div>

                    <input type="hidden" name="id" value="{{ $model->id }}">
                </div>
            </div>
        </form>

    </div>
@endsection
