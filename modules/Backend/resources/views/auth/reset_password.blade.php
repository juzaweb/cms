@extends('cms::layouts.auth')

@section('content')
    <div class="juzaweb__layout__content">
        <div class="juzaweb__utils__content">
            <div class="juzaweb__auth__authContainer">
                <div class="juzaweb__auth__containerInner">
                    <div class="card juzaweb__auth__boxContainer">
                        <div class="text-dark font-size-24 mb-4">
                            <strong>{{ trans('cms::app.reset_password') }}</strong>
                        </div>

                        <form action="{{ route('admin.reset_password', [$email, $token]) }}" method="post" class="mb-4 form-ajax">
                            <div class="form-group mb-4">
                                <input type="password" name="password" class="form-control" placeholder="{{ trans('cms::app.password') }}" autocomplete="off" required />
                            </div>

                            <div class="form-group mb-4">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="{{ trans('cms::app.password_confirmation') }}" autocomplete="off" required />
                            </div>

                            <button type="submit" class="btn btn-primary text-center w-100" data-loading-text="{{ trans('cms::app.please_wait') }}">
                                <i class="fa fa-refresh"></i> {{ trans('cms::app.reset_password') }}
                            </button>
                        </form>
                    </div>

                </div>
                <div class="mt-auto pb-5 pt-5">
                    <div class="text-center">
                        Copyright © {{ date('Y') }} {{ get_config('sitename') }} - Provided by Juzaweb
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
