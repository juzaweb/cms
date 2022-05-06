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
                                <input type="password" name="password" class="form-control" placeholder="@lang('cms::app.password')" autocomplete="off"/>
                            </div>

                            <div class="form-group mb-4">
                                <input type="password" name="password" class="form-control" placeholder="@lang('cms::app.password')" autocomplete="off"/>
                            </div>

                            <button type="submit" class="btn btn-primary text-center w-100" data-loading-text="@lang('cms::app.please-wait')">
                                <i class="fa fa-refresh"></i> @lang('cms::app.reset-password')
                            </button>
                        </form>
                    </div>

                </div>
                <div class="mt-auto pb-5 pt-5">
                    <div class="text-center">
                        Copyright © {{ date('Y') }} {{ get_config('sitename') }} - Provided by JUZAWEB
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
