@extends('layouts.backend')

@section('title', $title)

@section('content')
    {{ Breadcrumbs::render('manager', [
            'name' => trans('app.movies'),
            'url' => route('admin.movies')
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
                            <div class="btn-group float-right">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('app.save')</button>
                                <a href="{{ route('admin.movies') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('app.cancel')</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="col-form-label" for="baseName">@lang('app.name')</label>

                                <input type="text" name="name" class="form-control" id="baseName" value="" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="baseDescription">@lang('app.description')</label>
                                <textarea class="form-control" name="description" id="baseDescription" rows="6"></textarea>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="baseStatus">@lang('app.status')</label>
                                <select name="status" id="baseStatus" class="form-control" required>
                                    <option value="1">@lang('app.enabled')</option>
                                    <option value="0">@lang('app.disabled')</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-thumbnail text-center">
                                <input id="thumbnail" type="hidden" name="thumbnail">
                                <div id="holder">
                                    <img src="{{ asset('images/thumb-default.png') }}" class="w-100">
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
    </div>
@endsection
