@extends('cms::layouts.backend')

@section('content')

    @component('cms::components.form_resource', [
        'model' => $model
    ])

        <div class="row">

            <div class="col-md-8">
                <div class="form-group">
                    <label class="col-form-label" for="baseName">@lang('mymo::app.name')</label>
                    <input type="text" name="name" class="form-control" id="baseName" value="{{ $model->name }}" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="title">@lang('mymo::app.url')</label>
                    <input type="text" name="url" class="form-control" id="url" value="{{ $model->url }}" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="title">@lang('mymo::app.title')</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ $model->title }}" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="baseDescription">@lang('mymo::app.description')</label>
                    <textarea class="form-control" name="description" id="baseDescription" rows="6">{{ $model->description }}</textarea>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="title">@lang('mymo::app.video_url')</label>
                    <div class="row">
                        <div class="col-md-10">
                            <input type="text" name="video_url" class="form-control" id="video_url" value="{{ $model->video_url }}" autocomplete="off" required>
                        </div>

                        <div class="col-md-2">
                            <a href="javascript:void(0)" data-input="video_url" class="btn btn-primary file-manager"><i class="fa fa-upload"></i> @lang('mymo::app.upload')</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-form-label" for="baseStatus">@lang('mymo::app.status')</label>
                    <select name="status" id="baseStatus" class="form-control" required>
                        <option value="1" @if($model->status == 1) selected @endif>@lang('mymo::app.enabled')</option>
                        <option value="0" @if($model->status == 0 && !is_null($model->status)) selected @endif>@lang('mymo::app.disabled')</option>
                    </select>
                </div>
            </div>
        </div>

    @endcomponent
@endsection
