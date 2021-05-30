@extends('mymo_core::layouts.backend')

@section('content')

<div class="cui__utils__content">
    <form method="post" action="{{ route('admin.page.save') }}" class="form-ajax">
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
            </div>

            <div class="col-md-6">
                <div class="btn-group float-right">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('mymo_core::app.save')</button>
                    <a href="{{ route('admin.page') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('mymo_core::app.cancel')</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">

                <div class="form-group">
                    <label class="col-form-label" for="baseName">@lang('mymo_core::app.name')</label>

                    <input type="text" name="name" class="form-control" id="baseName" value="{{ $model->name }}" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="baseContent">@lang('mymo_core::app.content')</label>
                    <textarea class="form-control" name="content" id="baseContent" rows="6">{{ $model->content }}</textarea>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="baseStatus">@lang('mymo_core::app.status')</label>
                    <select name="status" id="baseStatus" class="form-control">
                        <option value="1" @if($model->status == 1) selected @endif>@lang('mymo_core::app.enabled')</option>
                        <option value="0" @if($model->status == 0 && !is_null($model->status)) selected @endif>@lang('mymo_core::app.disabled')</option>
                    </select>
                </div>

                @include('mymo_core::backend.seo_form')
            </div>

            <div class="col-md-4">
                <div class="form-thumbnail text-center">
                    <input id="thumbnail" type="hidden" name="thumbnail">
                    <div id="holder">
                        <img src="{{ $model->getThumbnail() }}" class="w-100">
                    </div>

                    <a href="javascript:void(0)" id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-capitalize">
                        <i class="fa fa-picture-o"></i> @lang('mymo_core::app.choose_image')
                    </a>
                </div>

            </div>
        </div>

        <input type="hidden" name="id" value="{{ $model->id }}">
    </form>

    <script type="text/javascript">
        CKEDITOR.replace('baseContent', {
            filebrowserImageBrowseUrl: '/admin-cp/file-manager?type=Images',
            filebrowserBrowseUrl: '/admin-cp/file-manager?type=Files'
        });
    </script>
</div>
@endsection
