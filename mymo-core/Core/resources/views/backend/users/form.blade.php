@extends('mymo_core::layouts.backend')

@section('content')
    <form method="post" action="{{ route('admin.users.save') }}" class="form-ajax">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('mymo_core::app.save')</button>
                            <a href="{{ route('admin.users') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('mymo_core::app.cancel')</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

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
                                <option value="1" @if($model->status == 1) selected @endif>@lang('mymo_core::app.enabled')</option>
                                <option value="0" @if($model->status == 0 && !is_null($model->status)) selected @endif>@lang('mymo_core::app.disabled')</option>
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

                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-thumbnail text-center">
                            <input id="avatar" type="file" name="avatar" class="d-none" accept="image/jpeg,image/png,image/gif">
                            <div id="holder">
                                <img src="{{ $model->getAvatar() }}" class="w-100">
                            </div>

                            <a href="javascript:void(0)" class="btn btn-primary text-capitalize choose-avatar">
                                <i class="fa fa-picture-o"></i> @lang('mymo_core::app.choose_avatar')
                            </a>
                        </div>

                    </div>
                </div>

                <input type="hidden" name="id" value="{{ $model->id }}">
            </div>
        </div>
    </form>

    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#holder img').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#avatar").change(function() {
            readURL(this);
        });

        $('.choose-avatar').on('click', function () {
            $("#avatar").trigger('click');
        });
    </script>
@endsection
