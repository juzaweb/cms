@extends('mymo_core::layouts.backend')

@section('content')

    @component('mymo_core::components.form_resource', [
        'action' => route('admin.users.save')
    ])
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="col-form-label" for="name">@lang('mymo_core::app.name')</label>

                    <input type="text" name="name" class="form-control" id="name" value="{{ $model->name }}" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="email">@lang('mymo_core::app.email')</label>
                    <input type="text" class="form-control" id="email" value="{{ $model->email }}" autocomplete="off" @if($model->id) disabled @else name="email" required @endif>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="is_admin">@lang('mymo_core::app.permission')</label>
                    <select name="is_admin" id="is_admin" class="form-control" required>
                        <option value="0" @if($model->is_admin == 0) selected @endif>@lang('mymo_core::app.user')</option>
                        <option value="1" @if($model->is_admin == 1) selected @endif>@lang('mymo_core::app.admin')</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="status">@lang('mymo_core::app.status')</label>
                    <select name="status" id="status" class="form-control" required>
                        @foreach($allStatus as $key => $name)
                        <option value="{{ $key }}" @if($model->status == $key) selected @endif>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <hr>

                <div class="form-group">
                    <label class="col-form-label" for="password">@lang('mymo_core::app.password')</label>

                    <input type="password" name="password" class="form-control" id="password" autocomplete="off" @if(empty($model->id)) required @endif>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="password_confirmation">@lang('mymo_core::app.confirm_password')</label>

                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" autocomplete="off" @if(empty($model->id)) required @endif>
                </div>
            </div>

            <div class="col-md-4">
                @component('mymo_core::components.form_image', [
                    'label' => trans('mymo_core::app.avatar'),
                    'name' => 'avatar',
                    'value' => $model->avatar
                ])
                @endcomponent

            </div>
        </div>

        <input type="hidden" name="id" value="{{ $model->id }}">
    @endcomponent

@endsection
