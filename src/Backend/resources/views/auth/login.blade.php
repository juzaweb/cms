@extends('mymo::layouts.auth')

@section('content')
    <div class="mymo__layout__content">
        <div class="mymo__utils__content">
            <div class="mymo__auth__authContainer">

                <div class="mymo__auth__containerInner">
                    <div class="text-center mb-5">
                        <h1 class="mb-5 px-3">
                            <strong>@lang('mymo::message.login_form.welcome', ['name' => get_config('sitename', 'MYMO CMS')])</strong>
                        </h1>

                        <p class="mb-4">
                            @lang('mymo::message.login_form.description')
                        </p>
                    </div>

                    <div class="card mymo__auth__boxContainer">
                        <div class="text-dark font-size-24 mb-4">
                            <strong>@lang('mymo::message.login_form.header')</strong>
                        </div>

                        <form action="{{ route('auth.login') }}" method="post" class="mb-4 form-ajax">

                            <div class="form-group mb-4">
                                <input type="email" name="email" class="form-control" placeholder="@lang('mymo::app.email_address')" />
                            </div>

                            <div class="form-group mb-4">
                                <input type="password" name="password" class="form-control" placeholder="@lang('mymo::app.password')" />
                            </div>

                            <button type="submit" class="btn btn-primary text-center w-100 mb-2" data-loading-text="@lang('mymo::app.please_wait')"><i class="fa fa-sign-in"></i> @lang('mymo::app.login')</button>

                            <input type="checkbox" name="remember" value="1" checked> @lang('mymo::app.remember_me')
                        </form>

                        <a href="{{ route('auth.forgot_password') }}" class="kit__utils__link font-size-16">
                            @lang('mymo::app.forgot_password')
                        </a>
                    </div>

                    @if(get_config('users_can_register'))
                    <div class="text-center pt-2 mb-auto">
                        <span class="mr-2">@lang('mymo::message.login_form.dont_have_an_account')</span>
                        <a href="{{ route('auth.register') }}" class="kit__utils__link font-size-16">
                            @lang('mymo::app.sign_up')
                        </a>
                    </div>
                    @endif
                </div>

                <div class="mt-auto pb-5 pt-5">
                    <div class="text-center">
                        Copyright © {{ date('Y') }} {{ get_config('sitename') }} - Provided by MYMO CMS
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection