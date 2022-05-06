@extends('cms::layouts.auth')

@section('content')
    <div class="juzaweb__layout__content">
        <div class="juzaweb__utils__content">
            <div class="juzaweb__auth__authContainer">
                <div class="juzaweb__auth__containerInner">
                    <div class="card juzaweb__auth__boxContainer">
                        <div class="text-dark font-size-24 mb-4">
                            <strong>{{ trans('cms::app.forgot_password') }}</strong>
                        </div>


                        <form action="{{ route('admin.forgot_password') }}" method="post" class="mb-4 form-ajax">
                            <div class="form-group mb-4">
                                <input type="text" name="email" class="form-control" placeholder="@lang('cms::app.email_address')" autocomplete="off"/>
                            </div>

                            <button type="submit" class="btn btn-primary text-center w-100" data-loading-text="@lang('cms::app.please_wait')">
                                <i class="fa fa-refresh"></i> @lang('cms::app.forgot_password')
                            </button>
                        </form>
                    </div>
                    <div class="text-center pt-2 mb-auto">
                        <span class="mr-2">Already have an account?</span>
                        <a href="{{ route('admin.login') }}" class="jw__utils__link font-size-16" data-turbolinks="false">
                            {{ trans('cms::app.login') }}
                        </a>
                    </div>
                </div>
                <div class="mt-auto pb-5 pt-5">
                    <div class="text-center">
                        Copyright © {{ date('Y') }} {{ get_config('title') }} - Provided by JUZAWEB
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
