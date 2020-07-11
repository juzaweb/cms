@extends('layouts.backend')

@section('title', $title)

@section('content')
    {{ Breadcrumbs::render('manager', [
            'name' => trans('app.tv_series'),
            'url' => route('admin.tv_series')
        ], $model) }}

    <div class="cui__utils__content">
        <form action="{{ route('admin.tv_series.save') }}" method="post" class="form-ajax">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
                        </div>

                        <div class="col-md-6">
                            <div class="float-right">
                            @if($model->id)
                                <div class="btn-group mr-5">
                                    <a href="{{ route('admin.movies.servers', ['mtype' => 'tv-series', 'movie_id' => $model->id]) }}" class="btn btn-success"><i class="fa fa-upload"></i> @lang('app.upload_videos')</a>
                                </div>
                            @endif

                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('app.save')</button>
                                    <a href="{{ route('admin.tv_series') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('app.cancel')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-8">

                            <div class="form-group">
                                <label class="col-form-label" for="name">@lang('app.name')</label>

                                <input type="text" name="name" class="form-control" id="name" value="{{ $model->name }}" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="other_name">@lang('app.other_name')</label>

                                <input type="text" name="other_name" class="form-control" id="other_name" value="{{ $model->other_name }}" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="baseDescription">@lang('app.description')</label>
                                <textarea class="form-control" name="description" id="baseDescription" rows="6">{{ $model->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="rating">@lang('app.rating')</label>

                                <input type="text" name="rating" class="form-control" id="rating" value="{{ $model->rating }}" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="release">@lang('app.release')</label>

                                <input type="text" name="release" class="form-control datepicker" id="release" value="{{ $model->release }}" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="runtime">@lang('app.runtime')</label>
                                <input type="text" name="runtime" class="form-control" id="runtime" value="{{ $model->runtime }}" autocomplete="off">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="current_episode">@lang('app.current_episode')</label>
                                        <input type="text" name="current_episode" class="form-control" id="current_episode" value="{{ $model->current_episode }}" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="max_episode">@lang('app.max_episode')</label>
                                        <input type="text" name="max_episode" class="form-control" id="max_episode" value="{{ $model->max_episode }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="trailer_link">@lang('app.trailer')</label>
                                <input type="text" name="trailer_link" class="form-control" id="trailer_link" value="{{ $model->trailer_link }}" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="video_quality">@lang('app.video_quality')</label>
                                <select class="form-control" name="video_quality" id="video_quality">
                                    @foreach($qualities as $item)
                                        @php
                                            $selected = ($model->video_quality == $item->name);
                                            if (empty($selected)) {
                                                $selected = (empty($model->video_quality) && $item->default == 1);
                                            }
                                        @endphp
                                        <option value="{{ $item->name }}" @if($selected) selected @endif>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="baseStatus">@lang('app.status')</label>
                                <select name="status" id="baseStatus" class="form-control" required>
                                    <option value="1" @if($model->status == 1) selected @endif>@lang('app.enabled')</option>
                                    <option value="0" @if($model->status == 0 && !is_null($model->status)) selected @endif>@lang('app.disabled')</option>
                                </select>
                            </div>

                            @include('backend.seo_form')
                        </div>

                        <div class="col-md-4">
                            @include('backend.tv_series.form_sidebar')
                        </div>
                    </div>

                    <input type="hidden" name="id" value="{{ $model->id }}">
                </div>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        CKEDITOR.replace('baseDescription', {
            filebrowserImageBrowseUrl: '/admin-cp/filemanager?type=Images',
            filebrowserBrowseUrl: '/admin-cp/filemanager?type=Files'
        });
    </script>
@endsection
