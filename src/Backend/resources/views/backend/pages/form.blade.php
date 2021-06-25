@extends('mymo::layouts.backend')

@section('content')

    @component('mymo::components.form_resource', [
        'action' => route('admin.page.save')
    ])
        <div class="row">
            <div class="col-md-8">

                <div class="form-group">
                    <label class="col-form-label" for="baseName">@lang('mymo::app.name')</label>

                    <input type="text" name="name" class="form-control" id="baseName" value="{{ $model->name }}" autocomplete="off" required>
                </div>

                @component('mymo::components.form_ckeditor', [
                    'label' => trans('mymo::app.content'),
                    'name' => 'content',
                    'value' => $model->content
                ])
                @endcomponent

                <div class="form-group">
                    <label class="col-form-label" for="baseStatus">@lang('mymo::app.status')</label>
                    <select name="status" id="baseStatus" class="form-control">
                        <option value="1" @if($model->status == 1) selected @endif>@lang('mymo::app.enabled')</option>
                        <option value="0" @if($model->status == 0 && !is_null($model->status)) selected @endif>@lang('mymo::app.disabled')</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">

                @component('mymo::components.form_image', [
                    'label' => trans('mymo::app.thumbnail'),
                    'name' => 'thumbnail',
                    'value' => $model->thumbnail
                ])
                @endcomponent

            </div>
        </div>

        <input type="hidden" name="id" value="{{ $model->id }}">
    @endcomponent

@endsection
