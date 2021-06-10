@extends('mymo_core::layouts.backend')

@section('content')

<div class="cui__utils__content">
    <form method="post" action="{{ route('admin.live-tv.category.save') }}" class="form-ajax">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('movie::app.save')</button>
                            <a href="{{ route('admin.live-tv.category') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('movie::app.cancel')</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-8">

                        <div class="form-group">
                            <label class="col-form-label" for="name">@lang('movie::app.name')</label>

                            <input type="text" name="name" class="form-control" id="name" value="{{ $model->name }}" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="description">@lang('movie::app.description')</label>
                            <textarea class="form-control" name="description" id="description" rows="6">{{ $model->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="status">@lang('movie::app.status')</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" @if($model->status == 1) selected @endif>@lang('movie::app.enabled')</option>
                                <option value="0" @if($model->status == 0 && !is_null($model->status)) selected @endif>@lang('movie::app.disabled')</option>
                            </select>
                        </div>


                    </div>

                    <div class="col-md-4">
                        <div class="form-thumbnail text-center">
                            <input id="thumbnail" type="hidden" name="thumbnail">
                            <div id="holder">
                                <img src="{{ $model->getThumbnail() }}" class="w-100">
                            </div>

                            <a href="javascript:void(0)" id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-capitalize">
                                <i class="fa fa-picture-o"></i> @lang('movie::app.choose_image')
                            </a>
                        </div>
                    </div>

                </div>

                <input type="hidden" name="id" value="{{ $model->id }}">
            </div>
        </div>
    </form>
    
</div>
@endsection
