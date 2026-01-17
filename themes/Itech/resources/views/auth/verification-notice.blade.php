@extends('itech::layouts.main')

@section('title', __('itech::translation.email_verification'))

@section('head')
    <link rel="stylesheet" href="{{ mix('css/auth.min.css', 'themes/itech') }}">
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent px-0 py-2">
                <li class="breadcrumb-item"><a href="{{ home_url('/') }}">{{ __('itech::translation.home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('itech::translation.email_verification') }}</li>
            </ol>
        </nav>
        <!-- End Breadcrumb -->

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="auth-container" style="background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <!-- Title -->
                    <div class="text-center mb-4">
                        <h3 style="margin-bottom: 10px;">{{ __('itech::translation.verify_email') }}</h3>
                        <p style="color: #666;">{{ __('itech::translation.please_verify_your_email_address') }}</p>
                    </div>
                    <!-- End Title -->

                    <div class="text-center" style="margin-bottom: 20px;">
                        <p style="color: #666;">
                            {{ __('itech::translation.a_verification_email_has_been_sent_to_your_email_address_please_check_your_inbox_and_click_the_verification_link') }}
                        </p>
                    </div>

                    <form action="{{ route('login') }}" class="form-ajax" method="post" data-notify="false" data-jw-token="true">

                        <div style="margin-bottom: 15px;">
                            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px;">{{ __('itech::translation.re_send_email') }}</button>
                        </div>
                    </form>

                    <div class="text-center" style="margin-top: 20px;">
                        <a href="{{ route('login') }}" style="font-weight: bold; font-size: 14px;">{{ __('itech::translation.login_to_account') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
