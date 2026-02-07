@extends('itech::layouts.main')

@section('title', __('itech::translation.sign_up'))

@section('head')
    <link rel="stylesheet" href="{{ mix('css/auth.min.css', 'themes/itech') }}">
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent px-0 py-2">
                <li class="breadcrumb-item"><a href="{{ home_url('/') }}">{{ __('itech::translation.home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('itech::translation.sign_up') }}</li>
            </ol>
        </nav>
        <!-- End Breadcrumb -->

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="auth-container" style="background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <!-- Title -->
                    <div class="text-center mb-4">
                        <h3 style="margin-bottom: 10px;">{{ __('itech::translation.create_your_account') }}</h3>
                        <p style="color: #666;">{{ __('itech::translation.fill_out_the_form_to_get_started') }}</p>
                    </div>
                    <!-- End Title -->

                        <form method="post" action="{{ route('register') }}" class="form-ajax" data-notify="false" data-jw-token="true">
                            <!-- Input Group -->
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="registerName">{{ __('itech::translation.name') }}</label>
                                <input type="text" name="name" id="registerName"
                                       placeholder="{{ __('itech::translation.name') }}" aria-label="{{ __('itech::translation.name') }}" required
                                       data-msg="{{ __('itech::translation.please_enter_your_name') }}">
                            </div>
                            <!-- End Input Group -->

                            <!-- Input Group -->
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="registerEmail">{{ __('itech::translation.email') }}</label>
                                <input type="email" name="email" id="registerEmail"
                                       placeholder="{{ __('itech::translation.email') }}" aria-label="{{ __('itech::translation.email') }}" required
                                       data-msg="{{ __('itech::translation.please_enter_a_valid_email_address') }}">
                            </div>
                            <!-- End Input Group -->

                            <!-- Input Group -->
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="registerPassword">{{ __('itech::translation.password') }}</label>
                                <input type="password" name="password" id="registerPassword"
                                       placeholder="{{ __('itech::translation.password') }}" aria-label="{{ __('itech::translation.password') }}" required
                                       data-msg="{{ __('itech::translation.your_password_is_invalid_please_try_again') }}">
                            </div>
                            <!-- End Input Group -->

                            <!-- Input Group -->
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="registerConfirmPassword">{{ __('itech::translation.confirm_password') }}</label>
                                <input type="password" name="password_confirmation"
                                       id="registerConfirmPassword" placeholder="{{ __('itech::translation.confirm_password') }}"
                                       aria-label="{{ __('itech::translation.confirm_password') }}" required
                                       data-msg="{{ __('itech::translation.password_does_not_match_the_confirm_password') }}">
                            </div>
                            <!-- End Input Group -->

                            <div style="margin-bottom: 15px;">
                                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px;">{{ __('itech::translation.sign_up') }}</button>
                            </div>
                        </form>

                        <div class="text-center" style="margin-top: 20px;">
                            <span style="color: #666; font-size: 14px;">{{ __('itech::translation.already_have_an_account') }}</span>
                            <a style="font-weight: bold; font-size: 14px;" href="{{ route('login') }}">
                                {{ __('itech::translation.sign_in') }}
                            </a>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
