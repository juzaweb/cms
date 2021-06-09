@extends('mymo_core::layouts.backend')

@section('content')

    <form method="post" action="{{ route('admin.movies.download.save', [$page_type, $movie_id]) }}" class="form-ajax">

        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
            </div>

            <div class="col-md-6">
                <div class="btn-group float-right">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('movie::app.save')</button>
                    <a href="{{ route('admin.movies.download', [$page_type, $movie_id]) }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('movie::app.cancel')</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="form-group">
                    <label class="col-form-label" for="label">@lang('movie::app.label')</label>

                    <input type="text" name="label" class="form-control" id="label" value="{{ $model->label }}" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="url">@lang('movie::app.download_link')</label>

                    <input type="text" name="url" class="form-control" id="url" value="{{ $model->url }}" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="order">@lang('movie::app.order')</label>

                    <input type="number" name="order" class="form-control" id="order" value="{{ $model->order ?? '1' }}" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="baseStatus">@lang('movie::app.status')</label>
                    <select name="status" id="baseStatus" class="form-control">
                        <option value="1" @if($model->status == 1) selected @endif>@lang('movie::app.enabled')</option>
                        <option value="0" @if($model->status == 0 && !is_null($model->status)) selected @endif>@lang('movie::app.disabled')</option>
                    </select>
                </div>

            </div>

        </div>

        <input type="hidden" name="id" value="{{ $model->id }}">


    </form>

@endsection
