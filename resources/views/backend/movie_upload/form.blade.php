@extends('layouts.backend')

@section('title', $title)

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('app.genres'),
        'url' => route('admin.genres')
    ], $model) }}

<div class="cui__utils__content">
    <form method="post" action="{{ route('admin.movies.upload.save') }}" class="form-ajax">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('app.save')</button>
                            <a href="{{ route('admin.genres') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('app.cancel')</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-form-label" for="name">@lang('app.name')</label>

                            <input type="text" name="name" class="form-control" id="name" autocomplete="off" required value="{{ $model->name }}">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="order">@lang('app.order')</label>

                            <input type="text" name="order" class="form-control" id="order" autocomplete="off" value="{{ $model->order }}" required>
                        </div>


                    </div>
                </div>

                <input type="hidden" name="id" value="{{ $model->id }}">
            </div>
        </div>
    </form>
</div>
@endsection
