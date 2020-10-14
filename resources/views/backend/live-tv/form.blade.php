@extends('layouts.backend')

@section('title', $title)

@section('content')
    {{ Breadcrumbs::render('manager', [
            'name' => trans('app.live_tv'),
            'url' => route('admin.live-tv')
        ], $model) }}

    <div class="cui__utils__content">
        <form action="{{ route('admin.live-tv.save') }}" method="post" class="form-ajax">
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
                                    <a href="{{ route('admin.live-tv.stream', [$model->id]) }}" class="btn btn-success"><i class="fa fa-upload"></i> @lang('app.add_stream')</a>
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
                            <div class="form-group">
                                <label class="col-form-label" for="thumbnail">@lang('app.thumbnail')</label>
                                <div class="form-thumbnail text-center">
                                    <input id="thumbnail" type="hidden" name="thumbnail">
                                    <div id="holder">
                                        <img src="{{ $model->getThumbnail() }}" class="w-100">
                                    </div>

                                    <a href="javascript:void(0)" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-capitalize lfm">
                                        <i class="fa fa-picture-o"></i> @lang('app.choose_image')
                                    </a>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="poster">@lang('app.poster')</label>
                                <div class="form-thumbnail text-center">
                                    <input id="poster" type="hidden" name="poster" value="{{ $model->poster }}">
                                    <div id="holder-poster">
                                        <img src="{{ $model->getPoster() }}" class="w-100">
                                    </div>

                                    <a href="javascript:void(0)" data-input="poster" data-preview="holder-poster" class="btn btn-primary text-capitalize lfm">
                                        <i class="fa fa-picture-o"></i> @lang('app.choose_image')
                                    </a>
                                </div>
                            </div>

                            <hr>
                            <div class="form-group">
                                <label class="col-form-label">@lang('app.category') <span><a href="javascript:void(0)" class="add-new-category float-right"><i class="fa fa-plus-circle"></i> @lang('app.add_category')</a></span></label>

                                <select name="category_id" id="category_id" class="form-control load-live-tv-category" data-placeholder="--- @lang('app.category') ---"></select>

                                <div class="form-add-live-tv-category box-hidden">
                                    <div class="form-group">
                                        <label class="col-form-label" for="categoryName">@lang('app.category')</label>
                                        <input type="text" class="form-control" id="categoryName" autocomplete="off">
                                    </div>

                                    <button type="button" class="btn btn-primary add-live-tv-category"><i class="fa fa-plus-circle"></i> @lang('app.add_category')</button>
                                </div>
                            </div>

                            <hr>
                            <div class="form-group">
                                <label class="col-form-label" for="select-tags">@lang('app.tags') <span><a href="javascript:void(0)" class="add-new-tags float-right"><i class="fa fa-plus-circle"></i> @lang('app.add_tags')</a></span></label>

                                <select id="select-tags" class="form-control load-tags select-tags" data-placeholder="--- @lang('app.tags') ---" data-explodes="tags-explode"></select>

                                <div class="show-tags mt-2">
                                    @foreach($tags as $item)
                                        <span class="tag m-1">{{ $item->name }} <a href="javascript:void(0)" class="text-danger ml-1 remove-tag-item"><i class="fa fa-times-circle"></i></a>
  <input type="hidden" name="tags[]" class="tags-explode" value="{{ $item->id }}">
</span>
                                    @endforeach
                                </div>

                                <div class="form-add-tags box-hidden">
                                    <div class="form-group">
                                        <label class="col-form-label" for="tagsName">@lang('app.tags')</label>
                                        <input type="text" class="form-control" id="tagsName" autocomplete="off">
                                    </div>

                                    <button type="button" class="btn btn-primary add-tags"><i class="fa fa-plus-circle"></i> @lang('app.add_tags')</button>
                                </div>
                            </div>

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
