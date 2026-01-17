@extends('itube::layouts.main')

@section('title', __('itube::translation.sign_in'))

@section('content')
    <div class="container mt-5 mb-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent px-0 py-2">
                <li class="breadcrumb-item"><a href="{{ home_url('/') }}">{{ __('itube::translation.home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('itube::translation.sign_in') }}</li>
            </ol>
        </nav>
        <!-- End Breadcrumb -->

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <!-- Title -->
                        <div class="text-center mb-7">
                            <h3 class="mb-0">{{ __('itube::translation.sign_in_to_name', ['name' => setting('sitename')]) }}</h3>
                            <p>{{ __('itube::translation.login_to_manage_your_account') }}</p>
                        </div>
                        <!-- End Title -->

                        <form method="post" action="{{ route('login') }}" class="form-ajax" data-notify="false" data-jw-token="true">

                            <!-- Input Group -->
                            <div class="js-form-message mb-4">
                                <label class="input-label">{{ __('itube::translation.email') }}</label>
                                <div class="input-group mb-2">
                                    <input type="email" class="form-control" name="email" id="loginEmail"
                                           placeholder="{{ __('itube::translation.email') }}" aria-label="{{ __('itube::translation.email') }}" required
                                           data-msg="{{ __('itube::translation.please_enter_a_valid_email_address') }}">
                                </div>
                            </div>
                            <!-- End Input Group -->

                            <!-- Input Group -->
                            <div class="js-form-message mb-3">
                                <label class="input-label">{{ __('itube::translation.password') }}</label>
                                <div class="input-group mb-2">
                                    <input type="password" class="form-control" name="password" id="loginPassword"
                                           placeholder="{{ __('itube::translation.password') }}" aria-label="{{ __('itube::translation.password') }}" required
                                           data-msg="{{ __('itube::translation.your_password_is_invalid_please_try_again') }}">
                                </div>
                            </div>
                            <!-- End Input Group -->

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rememberMe" name="remember">
                                    <label class="custom-control-label" for="rememberMe">{{ __('itube::translation.remember_me') }}</label>
                                </div>
                                <a class="small link-underline" href="{{ route('forgot-password') }}">
                                    {{ __('itube::translation.forgot_password') }}
                                </a>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('itube::translation.sign_in') }}</button>
                            </div>
                        </form>

                        @if($socialLogins->isNotEmpty())
                        <div class="text-center mb-3">
                            <span class="divider divider-xs divider-text">{{ __('itube::translation.or') }}</span>
                        </div>

                            @foreach($socialLogins as $key => $name)
                                <a class="btn btn-ghost-secondary btn-block mb-2" href="{{ route('auth.social.redirect', [$key]) }}">
                                    <span class="d-flex justify-content-center align-items-center">
                                        <i class="fab fa-{{ $key }} mr-2"></i>
                                        {{ __('itube::translation.sign_in_with_name', ['name' => $name]) }}
                                    </span>
                                </a>
                            @endforeach
                        @endif

                        <div class="text-center mt-4">
                            <span class="small text-muted">{{ __('itube::translation.do_not_have_an_account') }}</span>
                            <a class="small font-weight-bold" href="{{ route('register') }}">
                                {{ __('itube::translation.sign_up') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
