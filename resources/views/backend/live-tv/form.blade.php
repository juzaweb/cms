@extends('layouts.backend')

@section('title', $title)

@section('content')
    {{ Breadcrumbs::render('manager', [
            'name' => trans('app.live_tv'),
            'url' => route('admin.live-tv')
        ], $model) }}

    <div class="cui__utils__content">
        <form action="{{ route('admin.movies.save') }}" method="post" class="form-ajax">
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
                                    <a href="{{ route('admin.live-tv.servers', ['movies', $model->id]) }}" class="btn btn-success"><i class="fa fa-upload"></i> @lang('app.add_stream')</a>
                                </div>
                                @endif

                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('app.save')</button>

                                    <a href="{{ route('admin.live-tv') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('app.cancel')</a>
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
                                <label class="col-form-label" for="description">@lang('app.description')</label>
                                <textarea class="form-control" name="description" id="description" rows="6">{{ $model->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="status">@lang('app.status')</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="1" @if($model->status == 1) selected @endif>@lang('app.enabled')</option>
                                    <option value="0" @if($model->status == 0 && !is_null($model->status)) selected @endif>@lang('app.disabled')</option>
                                </select>
                            </div>

                            @include('backend.seo_form')
                        </div>

                        <div class="col-md-4">
                            @include('backend.live-tv.form_sidebar')
                        </div>
                    </div>

                    <input type="hidden" name="id" value="{{ $model->id }}">
                </div>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        CKEDITOR.replace('description', {
            filebrowserImageBrowseUrl: '/admin-cp/filemanager?type=Images',
            filebrowserBrowseUrl: '/admin-cp/filemanager?type=Files'
        });
    </script>
@endsection
