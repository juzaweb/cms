@extends('layouts.backend')

@section('title', $title)

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('mymo_core::app.video_qualities'),
        'url' => route('admin.video_qualities')
    ], $model) }}

<div class="cui__utils__content">
    <form method="post" action="{{ route('admin.video_qualities.save') }}" class="form-ajax">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('mymo_core::app.save')</button>
                            <a href="{{ route('admin.video_qualities') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('mymo_core::app.cancel')</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="col-form-label" for="baseName">@lang('mymo_core::app.name')</label>

                            <input type="text" name="name" class="form-control" id="baseName" value="{{ $model->name }}" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="default">@lang('mymo_core::app.default')</label>
                            <select name="default" id="default" class="form-control">
                                <option value="0" @if($model->default == 0) selected @endif>@lang('mymo_core::app.no')</option>
                                <option value="1" @if($model->default == 1) selected @endif>@lang('mymo_core::app.yes')</option>
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
