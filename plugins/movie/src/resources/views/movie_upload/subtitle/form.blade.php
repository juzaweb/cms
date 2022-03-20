@extends('cms::layouts.backend')

@section('content')

    @component('cms::components.form_resource', [
        'model' => $model
    ])

        <div class="row">
            <div class="col-md-12">

                <div class="form-group">
                    <label class="col-form-label" for="label">@lang('mymo::app.label')</label>

                    <input type="text" name="label" class="form-control" id="label" value="{{ $model->label }}" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="url">@lang('mymo::app.url')</label>
                    <div class="row">
                        <div class="col-md-9">
                            <input type="text" name="url" class="form-control" id="url" value="{{ $model->url }}" autocomplete="off" required>
                        </div>

                        <div class="col-md-3">
                            <a href="javascript:void(0)" class="btn btn-primary file-manager" data-input="url"><i class="fa fa-upload"></i> @lang('mymo::app.upload')</a>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-form-label" for="order">@lang('mymo::app.order')</label>
                    <input type="number" name="order" class="form-control" id="order" value="{{ $model->order ?? 1 }}" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="status">@lang('mymo::app.status')</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" @if($model->status == 1) selected @endif>@lang('mymo::app.enabled')</option>
                        <option value="0" @if($model->status == 0 && !is_null($model->status)) selected @endif>@lang('mymo::app.disabled')</option>
                    </select>
                </div>

                <input type="hidden" name="file_id" value="{{ $file_id }}">
                <input type="hidden" name="movie_id" value="{{ $file->server->movie_id }}">

            </div>
        </div>

    @endcomponent

@endsection
