@extends('layouts.backend')

@section('title', $title)

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('mymo_core::app.posts'),
        'url' => route('admin.posts')
    ], $model) }}

<div class="cui__utils__content">
    <form method="post" action="{{ route('admin.posts.save') }}" class="form-ajax">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('mymo_core::app.save')</button>
                            <a href="{{ route('admin.posts') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('mymo_core::app.cancel')</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-8">

                        <div class="form-group">
                            <label class="col-form-label" for="baseTitle">@lang('mymo_core::app.title')</label>

                            <input type="text" name="title" class="form-control" id="baseTitle" value="{{ $model->title }}" autocomplete="off" required>
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
                        <div class="form-group">
                            <label class="col-form-label" for="baseStatus">@lang('mymo_core::app.thumbnail')</label>
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
                        <hr>
                        <div class="form-group">
                            <label class="col-form-label" for="categories">@lang('mymo_core::app.categories') <span><a href="javascript:void(0)" class="add-new-category float-right"><i class="fa fa-plus-circle"></i> @lang('mymo_core::app.add_category')</a></span></label>

                            <div class="show-categories">
                                @php
                                $selected = explode(',', $model->category);
                                @endphp
                                <ul class="mt-2 p-0">
                                @foreach($categories as $item)
                                    <li class="m-1" id="item-category-{{ $item->id }}">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="categories[]" class="custom-control-input" id="category-{{ $item->id }}" value="{{ $item->id }}" @if(in_array($item->id, $selected)) checked @endif>
                                            <label class="custom-control-label" for="category-{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    </li>
                                @endforeach
                                </ul>
                            </div>

                            <div class="form-add-category box-hidden">
                                <div class="form-group">
                                    <label class="col-form-label" for="categoryName">@lang('mymo_core::app.name')</label>
                                    <input type="text" class="form-control" id="categoryName" autocomplete="off">
                                </div>

                                <button type="button" class="btn btn-primary add-category"><i class="fa fa-plus-circle"></i> @lang('mymo_core::app.add_category')</button>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-form-label" for="select-tags">@lang('mymo_core::app.tags') <span><a href="javascript:void(0)" class="add-new-tags float-right"><i class="fa fa-plus-circle"></i> @lang('mymo_core::app.add_tags')</a></span></label>

                            <select id="select-tags" class="form-control load-tags select-tags" data-placeholder="--- @lang('mymo_core::app.tags') ---" data-explodes="tag-explode"></select>

                            <div class="show-tags mt-2">
                                @foreach($tags as $item)
                                <span class="tag m-1">{{ $item->name }} <a href="javascript:void(0)" class="text-danger ml-1 remove-tag-item"><i class="fa fa-times-circle"></i></a>
  <input type="hidden" name="tags[]" class="tag-explode" value="{{ $item->id }}">
</span>
                                @endforeach
                            </div>

                            <div class="form-add-tags box-hidden">
                                <div class="form-group">
                                    <label class="col-form-label" for="tagsName">@lang('mymo_core::app.tags')</label>
                                    <input type="text" class="form-control" id="tagsName" autocomplete="off">
                                </div>

                                <button type="button" class="btn btn-primary add-tags"><i class="fa fa-plus-circle"></i> @lang('mymo_core::app.add_tags')</button>
                            </div>
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
