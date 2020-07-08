@extends('layouts.backend')

@section('title', $title)

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('app.pages'),
        'url' => route('admin.pages')
    ], $model) }}

<div class="cui__utils__content">
    <form method="post" action="{{ route('admin.pages.save') }}" class="form-ajax">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('app.save')</button>
                            <a href="{{ route('admin.pages') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('app.cancel')</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-8">

                        <div class="form-group">
                            <label class="col-form-label" for="baseName">@lang('app.name')</label>

                            <input type="text" name="name" class="form-control" id="baseName" value="{{ $model->name }}" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="baseContent">@lang('app.content')</label>
                            <textarea class="form-control" name="content" id="baseContent" rows="6">{{ $model->content }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="baseStatus">@lang('app.status')</label>
                            <select name="status" id="baseStatus" class="form-control">
                                <option value="1" @if($model->status == 1) selected @endif>@lang('app.enabled')</option>
                                <option value="0" @if($model->status == 0 && !is_null($model->status)) selected @endif>@lang('app.disabled')</option>
                            </select>
                        </div>

                        @include('backend.seo_form')
                    </div>

                    <div class="col-md-4">
                        <div class="form-thumbnail text-center">
                            <input id="thumbnail" type="hidden" name="thumbnail">
                            <div id="holder">
                                <img src="{{ $model->getThumbnail() }}" class="w-100">
                            </div>

                            <a href="javascript:void(0)" id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-capitalize">
                                <i class="fa fa-picture-o"></i> @lang('app.choose_image')
                            </a>
                        </div>

                    </div>
                </div>

                <input type="hidden" name="id" value="{{ $model->id }}">
            </div>
        </div>
    </form>

    <script type="text/javascript">
        CKEDITOR.replace('baseContent', {
            filebrowserImageBrowseUrl: '/admin-cp/filemanager?type=Images',
            filebrowserBrowseUrl: '/admin-cp/filemanager?type=Files'
        });
    </script>
</div>
@endsection
