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
                    </div>

                    <div class="card juzaweb__auth__boxContainer">
                        <div class="text-dark font-size-24 mb-4">
                            <strong>{{ __('Create your account') }}</strong>
                        </div>

                        <div class="mb-4">
                            <p>
                                {{ __('And start spending more time on your projects and less time managing your infrastructure.') }}
                            </p>
                        </div>

                        <form action="{{ route('register') }}" method="post" class="mb-4 form-ajax">
                            @do_action('register_form')

                            <div class="form-group mb-4">
                                <input type="text" name="name" class="form-control" placeholder="{{ trans('cms::app.full_name') }}" autocomplete="off" required/>
                            </div>

                            <div class="form-group mb-4">
                                <input type="text" name="email" class="form-control" placeholder="{{ trans('cms::app.email_address') }}" autocomplete="off" required/>
                            </div>

                            <div class="form-group mb-4">
                                <input type="password" name="password" class="form-control" placeholder="{{ trans('cms::app.password') }}" autocomplete="off" required/>
                            </div>

                            <div class="form-group mb-4">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="{{ trans('cms::app.password_confirmation') }}" autocomplete="off" required/>
                            </div>

                            <button type="submit" class="btn btn-primary text-center w-100" data-loading-text="{{ trans('cms::app.please_wait') }}">
                                <strong>{{ __('Sign Up') }}</strong>
                            </button>
                        </form>

                        <div class="social-login mt-3">
                            @foreach($socialites as $key => $social)
                                @continue(($social['enable'] ?? 0) != 1)

                                <a class="btn btn-lg btn-{{ $key }} btn-block text-uppercase" href="{{ url("auth/{$key}/redirect") }}">
                                    <i class="fa fa-{{ $key }} mr-2"></i> {{ trans('cms::app.socials.login_with', ['name' => ucfirst($key)]) }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="text-center pt-2 mb-auto">
                        <span class="mr-2">{{ __('Already have an account?') }}</span>
                        <a href="{{ route('admin.login') }}" class="jw__utils__link font-size-16" data-turbolinks="false">
                            {{ __('Sign in') }}
                        </a>
                    </div>

                </div>
                <div class="mt-auto pb-5 pt-5">
                    <div class="text-center">
                        Copyright © {{ date('Y') }} {{ get_config('title') }} - Provided by Juzaweb
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
