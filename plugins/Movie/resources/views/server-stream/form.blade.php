@extends('mymo_core::layouts.backend')

@section('title', $title)

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('app.server_stream'),
        'url' => route('admin.server-stream')
    ], $model) }}

<div class="cui__utils__content">
    <form method="post" action="{{ route('admin.server-stream.save') }}" class="form-ajax">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('app.save')</button>
                            <a href="{{ route('admin.server-stream') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('app.cancel')</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="col-form-label" for="key">@lang('app.key')</label>

                            <input type="text" name="key" class="form-control" id="key" value="{{ $model->key ?? Str::random(32) }}" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="name">@lang('app.name')</label>

                            <input type="text" name="name" class="form-control" id="name" value="{{ $model->name }}" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="name">@lang('app.base_url')</label>
                            <input type="text" name="base_url" class="form-control" id="base_url" value="{{ $model->base_url }}" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="name">@lang('app.priority')</label>
                            <input type="text" name="priority" class="form-control" id="priority" value="{{ $model->priority ?? 1 }}" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="status">@lang('app.status')</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" @if($model->status == 1) selected @endif>@lang('app.enabled')</option>
                                <option value="0" @if($model->status == 0 && !is_null($model->status)) selected @endif>@lang('app.disabled')</option>
                            </select>
                        </div>

                    </div>

                </div>

                <input type="hidden" name="id" value="{{ $model->id }}">
            </div>
        </div>
    </form>
    
</div>
@endsection
