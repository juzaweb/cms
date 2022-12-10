@extends('cms::layouts.auth')

@section('content')
    <div class="juzaweb__layout__content">
        <div class="juzaweb__utils__content">
            <div class="juzaweb__auth__authContainer">

                <div class="juzaweb__auth__containerInner">
                    <div class="text-center mb-5">
                        @if($logo = get_config('logo'))
                            <img src="{{ upload_url(get_config('logo')) }}" alt="{{ get_config('title', 'JUZAWEB') }}">
                        @else
                            <h1 class="mb-5 px-3">
                                <strong>{{ trans('cms::message.login_form.welcome', ['name' => get_config('title', 'JUZAWEB')]) }}</strong>
                            </h1>
                        @endif

                        <p class="mb-4">
                            {{ trans('cms::message.login_form.description') }}
                        </p>
                    </div>

                    <div class="card juzaweb__auth__boxContainer">
                        <div class="text-dark font-size-24 mb-4">
                            <strong>{{ trans('cms::message.login_form.header') }}</strong>
                        </div>

                        <form action="" method="post" class="mb-4 form-ajax">

                            @do_action('login_form')

                            <div class="form-group mb-4">
                                <input type="email" name="email" class="form-control" placeholder="{{ trans('cms::app.email_address') }}" required />
                            </div>

                            <div class="form-group mb-4">
                                <input type="password" name="password" class="form-control" placeholder="{{ trans('cms::app.password') }}" required />
                            </div>

                            <button type="submit" class="btn btn-primary text-center w-100 mb-2" data-loading-text="{{ trans('cms::app.please_wait') }}"><i class="fa fa-sign-in"></i> {{ trans('cms::app.login') }}</button>

                            <input type="checkbox" name="remember" value="1" checked> {{ trans('cms::app.remember_me') }}
                        </form>

                        <a href="{{ route('admin.forgot_password') }}" class="jw__utils__link font-size-16" data-turbolinks="false">
                            {{ trans('cms::app.forgot_password') }}
                        </a>

                        <div class="social-login mt-3">
                            @foreach($socialites as $key => $social)
                                @continue(($social['enable'] ?? 0) != 1)

                                <a class="btn btn-lg btn-{{ $key }} btn-block text-uppercase" href="{{ url("auth/{$key}/redirect") }}">
                                    <i class="fa fa-{{ $key }} mr-2"></i> {{ trans('cms::app.socials.login_with', ['name' => ucfirst($key)]) }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    @if(get_config('user_registration'))
                    <div class="text-center pt-2 mb-auto">
                        <span class="mr-2">{{ trans('cms::message.login_form.dont_have_an_account') }}</span>
                        <a href="{{ route('admin.register') }}" class="jw__utils__link font-size-16" data-turbolinks="false">
                            {{ __('Sign Up') }}
                        </a>
                    </div>
                    @endif
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
