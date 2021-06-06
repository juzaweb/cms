@extends('mymo_core::layouts.backend')

@section('content')

    @component('mymo_core::components.resource_form')
        {{--@if($model->id)
            <div class="btn-group mr-5">
                <a href="{{ route('admin.movies.servers', ['movies', $model->id]) }}" class="btn btn-success"><i class="fa fa-upload"></i> @lang('app.upload_videos')</a>
            </div>
        @endif--}}

    <div class="row">
        <div class="col-md-8">

            <div class="form-group">
                <label class="col-form-label" for="name">@lang('movie::app.name')</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $model->name }}" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label class="col-form-label" for="other_name">@lang('movie::app.other_name')</label>
                <input type="text" name="other_name" class="form-control" id="other_name" value="{{ $model->other_name }}" autocomplete="off">
            </div>

            @include('mymo_core::components.form_ckeditor', [
                'label' => trans('movie::app.description'),
                'name' => 'description',
                'value' => $model->description
            ])

            <div class="form-group">
                <label class="col-form-label" for="rating">@lang('movie::app.rating')</label>
                <input type="text" name="rating" class="form-control" id="rating" value="{{ $model->rating }}" autocomplete="off">
            </div>

            <div class="form-group">
                <label class="col-form-label" for="release">@lang('movie::app.release')</label>
                <input type="text" name="release" class="form-control datepicker" id="release" value="{{ $model->release }}" autocomplete="off">
            </div>

            <div class="form-group">
                <label class="col-form-label" for="runtime">@lang('movie::app.runtime')</label>
                <input type="text" name="runtime" class="form-control" id="runtime" value="{{ $model->runtime }}" autocomplete="off">
            </div>

            <div class="form-group">
                <label class="col-form-label" for="trailer_link">@lang('movie::app.trailer')</label>
                <input type="text" name="trailer_link" class="form-control" id="trailer_link" value="{{ $model->trailer_link }}" autocomplete="off">
            </div>

            {{--qualities--}}

            <div class="form-group">
                <label class="col-form-label" for="status">@lang('movie::app.status')</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="1" @if($model->status == 1) selected @endif>@lang('movie::app.enabled')</option>
                    <option value="0" @if($model->status == 0 && !is_null($model->status)) selected @endif>@lang('movie::app.disabled')</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            @component('mymo_core::components.form_image', [
                'label' => trans('movie::app.thumbnail'),
                'name' => 'thumbnail',
                'value' => $model->getThumbnail()
            ])
            @endcomponent
        </div>
    </div>
    @endcomponent

@endsection
