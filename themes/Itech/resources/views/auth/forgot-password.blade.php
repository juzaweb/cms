@extends('itech::layouts.main')

@section('title', __('itech::translation.forgot_password'))

@section('head')
    <link rel="stylesheet" href="{{ mix('css/auth.min.css', 'themes/itech') }}">
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent px-0 py-2">
                <li class="breadcrumb-item"><a href="{{ home_url('/') }}">{{ __('itech::translation.home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('itech::translation.forgot_password') }}</li>
            </ol>
        </nav>
        <!-- End Breadcrumb -->

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="auth-container" style="background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <!-- Title -->
                    <div class="text-center mb-4">
                        <h3 style="margin-bottom: 10px;">{{ __('itech::translation.recover_password') }}</h3>
                        <p style="color: #666;">{{ __('itech::translation.instructions_will_be_sent_to_you') }}</p>
                    </div>
                    <!-- End Title -->

                        <form method="post" action="{{ route('forgot-password') }}" class="form-ajax" data-notify="false" data-jw-token="true">

                            <!-- Input Group -->
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="recoverEmail">{{ __('itech::translation.your_email') }}</label>
                                <input type="email" name="email" id="recoverEmail"
                                       placeholder="{{ __('itech::translation.your_email') }}" aria-label="{{ __('itech::translation.your_email') }}" required
                                       data-msg="{{ __('itech::translation.please_enter_a_valid_email_address') }}">
                            </div>
                            <!-- End Input Group -->

                            <div style="margin-bottom: 15px;">
                                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px;">
                                    {{ __('itech::translation.recover_password') }}
                                </button>
                            </div>
                        </form>

                        <div class="text-center" style="margin-top: 20px;">
                            <span style="color: #666; font-size: 14px;">{{ __('itech::translation.remember_your_password') }}</span>
                            <a style="font-weight: bold; font-size: 14px;" href="{{ route('login') }}">
                                {{ __('itech::translation.login') }}
                            </a>
                        </div>

                        <div class="text-center" style="margin-top: 10px;">
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
