@extends('itech::layouts.main')

@section('title', __('itech::translation.sign_in'))

@section('head')
    <link rel="stylesheet" href="{{ mix('css/auth.min.css', 'themes/itech') }}">
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8">
                <div class="auth-container"
                     style="background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <!-- Title -->
                    <div class="text-center mb-4">
                        <h3 style="margin-bottom: 10px;">{{ __('itech::translation.sign_in_to_name', ['name' => setting('sitename')]) }}</h3>
                        <p style="color: #666;">{{ __('itech::translation.login_to_manage_your_account') }}</p>
                    </div>
                    <!-- End Title -->

                    @if (session('success'))
                        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 5px; margin-bottom: 20px;">
                            {{ session('message') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 5px; margin-bottom: 20px;">
                                <button type="button"
                                        style="float: right; background: none; border: none; font-size: 20px; cursor: pointer;"
                                        onclick="this.parentElement.style.display='none'">&times;
                                </button>
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif

                    <form method="post" action="{{ route('login') }}" class="form-ajax" data-notify="false"
                          data-jw-token="true">
                        @csrf

                        <!-- Input Group -->
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="loginEmail">{{ __('itech::translation.email') }}</label>
                            <input type="email" name="email" id="loginEmail"
                                   placeholder="{{ __('itech::translation.email') }}"
                                   aria-label="{{ __('itech::translation.email') }}" required
                                   data-msg="{{ __('itech::translation.please_enter_a_valid_email_address') }}">
                        </div>
                        <!-- End Input Group -->

                        <!-- Input Group -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="loginPassword">{{ __('itech::translation.password') }}</label>
                            <input type="password" name="password" id="loginPassword"
                                   placeholder="{{ __('itech::translation.password') }}"
                                   aria-label="{{ __('itech::translation.password') }}" required
                                   data-msg="{{ __('itech::translation.your_password_is_invalid_please_try_again') }}">
                        </div>
                        <!-- End Input Group -->

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <div>
                                <input type="checkbox" id="rememberMe" name="remember">
                                <label for="rememberMe"
                                       style="margin-left: 5px;">{{ __('itech::translation.remember_me') }}</label>
                            </div>
                            <a style="font-size: 14px;" href="{{ route('forgot-password') }}">
                                {{ __('itech::translation.forgot_password') }}
                            </a>
                        </div>

                        <div style="margin-bottom: 15px;">
                            <button type="submit" class="btn btn-primary"
                                    style="width: 100%; padding: 10px;">{{ __('itech::translation.sign_in') }}</button>
                        </div>
                    </form>

                    <div class="text-center" style="margin-top: 20px;">
                        <span style="color: #666; font-size: 14px;">{{ __('itech::translation.do_not_have_an_account') }}</span>
                        <a style="font-weight: bold; font-size: 14px;" href="{{ route('register') }}">
                            {{ __('itech::translation.sign_up') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
