@extends('layouts.backend')

@section('title', $title)

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('app.video_ads'),
        'url' => route('admin.setting.video_ads')
    ], $model) }}

<div class="cui__utils__content">
    <form method="post" action="{{ route('admin.setting.video_ads.save') }}" class="form-ajax">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('app.save')</button>
                            <a href="{{ route('admin.setting.video_ads') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('app.cancel')</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="col-form-label" for="baseName">@lang('app.name')</label>
                            <input type="text" name="name" class="form-control" id="baseName" value="{{ $model->name }}" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="title">@lang('app.url')</label>
                            <input type="text" name="url" class="form-control" id="url" value="{{ $model->url }}" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="title">@lang('app.title')</label>
                            <input type="text" name="title" class="form-control" id="title" value="{{ $model->title }}" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="baseDescription">@lang('app.description')</label>
                            <textarea class="form-control" name="description" id="baseDescription" rows="6">{{ $model->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="title">@lang('app.video_url')</label>
                            <div class="row">
                                <div class="col-md-10">
                                    <input type="text" name="video_url" class="form-control" id="video_url" value="{{ $model->video_url }}" autocomplete="off" required>
                                </div>

                                <div class="col-md-2">
                                    <a href="javascript:void(0)" data-input="video_url" class="btn btn-primary lfm-file"><i class="fa fa-upload"></i> @lang('app.upload')</a>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="baseStatus">@lang('app.status')</label>
                            <select name="status" id="baseStatus" class="form-control" required>
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
