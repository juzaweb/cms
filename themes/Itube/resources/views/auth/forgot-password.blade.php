@extends('itube::layouts.main')

@section('title', __('itube::translation.forgot_password'))

@section('content')
    <div class="container mt-5 mb-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent px-0 py-2">
                <li class="breadcrumb-item"><a href="{{ home_url('/') }}">{{ __('itube::translation.home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('itube::translation.forgot_password') }}</li>
            </ol>
        </nav>
        <!-- End Breadcrumb -->

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <!-- Title -->
                        <div class="text-center mb-7">
                            <h3 class="mb-0">{{ __('itube::translation.recover_password') }}</h3>
                            <p>{{ __('itube::translation.instructions_will_be_sent_to_you') }}</p>
                        </div>
                        <!-- End Title -->

                        <form method="post" action="" class="form-ajax" data-notify="false" data-jw-token="true">

                            <!-- Input Group -->
                            <div class="js-form-message mb-4">
                                <label class="input-label" for="recoverEmail">{{ __('itube::translation.your_email') }}</label>
                                <div class="input-group mb-2">
                                    <input type="email" class="form-control" name="email" id="recoverEmail"
                                           placeholder="{{ __('itube::translation.your_email') }}" aria-label="{{ __('itube::translation.your_email') }}" required
                                           data-msg="{{ __('itube::translation.please_enter_a_valid_email_address') }}">
                                </div>
                            </div>
                            <!-- End Input Group -->

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('itube::translation.recover_password') }}
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <span class="small text-muted">{{ __('itube::translation.remember_your_password') }}</span>
                            <a class="small font-weight-bold" href="{{ route('login') }}">
                                {{ __('itube::translation.login') }}
                            </a>
                        </div>

                        <div class="text-center mt-2">
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
