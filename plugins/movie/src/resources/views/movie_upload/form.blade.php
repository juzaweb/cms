@extends('cms::layouts.backend')

@section('content')

    @component('cms::components.form_resource', [
        'model' => $model
    ])

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="col-form-label" for="label">@lang('mymo::app.label')</label>
                    <input type="text" name="label" class="form-control" id="label" autocomplete="off" required value="{{ $model->label }}">
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="order">@lang('mymo::app.order')</label>
                    <input type="text" name="order" class="form-control" id="order" autocomplete="off" required value="{{ $model->order ? $model->order : 1 }}">
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="source">@lang('mymo::app.source')</label>
                    <select name="source" id="source" class="form-control" required>
                        <option value="">--- @lang('mymo::app.source') ---</option>
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
                    <label class="col-form-label" for="url">@lang('mymo::app.video_url')</label>
                    <div class="row">
                        <div class="col-md-10">
                            <input type="text" name="url" id="url" class="form-control" autocomplete="off" value="{{ $model->url }}">
                        </div>

                        <div class="col-md-2">
                            <a href="javascript:void(0)" class="btn btn-primary file-manager" data-input="url"><i class="fa fa-upload"></i> @lang('mymo::app.upload')</a>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="server_id" value="{{ $server_id }}">
            <input type="hidden" name="movie_id" value="{{ $server->movie_id }}">
        </div>

    @endcomponent

@endsection
