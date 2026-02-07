@extends('itech::layouts.main')

@section('title', __('itech::translation.reset_password'))

@section('head')
    <link rel="stylesheet" href="{{ mix('css/auth.min.css', 'themes/itech') }}">
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent px-0 py-2">
                <li class="breadcrumb-item"><a href="{{ home_url('/') }}">{{ __('itech::translation.home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('itech::translation.reset_password') }}</li>
            </ol>
        </nav>
        <!-- End Breadcrumb -->

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="auth-container" style="background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <!-- Title -->
                    <div class="text-center mb-4">
                        <h3 style="margin-bottom: 10px;">{{ __('itech::translation.reset_password') }}</h3>
                        <p style="color: #666;">{{ __('itech::translation.enter_your_new_password_below') }}</p>
                    </div>
                    <!-- End Title -->



                        <form action="{{ route('password.reset', [$email, $token]) }}" class="form-ajax" method="post" data-notify="false" data-jw-token="true">
                            <!-- Input Group -->
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="newPassword">{{ __('itech::translation.new_password') }}</label>
                                <input type="password" name="password" id="newPassword"
                                       placeholder="{{ __('itech::translation.new_password') }}" required>
                            </div>
                            <!-- End Input Group -->

                            <!-- Input Group -->
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="confirmPassword">{{ __('itech::translation.confirm_password') }}</label>
                                <input type="password" name="password_confirmation"
                                       id="confirmPassword" placeholder="{{ __('itech::translation.confirm_password') }}" required>
                            </div>
                            <!-- End Input Group -->

                            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px;">{{ __('itech::translation.reset_password') }}</button>

                        </form>

                        <div class="text-center" style="margin-top: 20px;">
                            <span style="color: #666; font-size: 14px;">{{ __('itech::translation.remember_your_password') }}</span>
                            <a style="font-weight: bold; font-size: 14px;" href="{{ route('login') }}">
                                {{ __('itech::translation.sign_in') }}
                            </a>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
