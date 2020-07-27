@extends('layouts.backend')

@section('title', $title)

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('app.banner_ads'),
        'url' => route('admin.setting.ads')
    ], $model) }}

<div class="cui__utils__content">
    <form method="post" action="{{ route('admin.setting.ads.save') }}" class="form-ajax">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('app.save')</button>
                            <a href="{{ route('admin.setting.ads') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('app.cancel')</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="col-form-label" for="key">@lang('app.code')</label>
                            <input type="text" class="form-control" id="key" value="{{ $model->key }}" disabled>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="name">@lang('app.name')</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ $model->name }}" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="body">@lang('app.content')</label>
                            <textarea class="form-control" name="body" id="body" rows="6">{{ $model->body }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="baseStatus">@lang('app.status')</label>
                            <select name="status" id="baseStatus" class="form-control">
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
