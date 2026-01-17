<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <button type="button" class="close position-absolute top-0 right-0 z-index-2 mt-3 mr-3" data-dismiss="modal"
                    aria-label="Close">
                <svg aria-hidden="true" class="mb-0" width="14" height="14" viewBox="0 0 18 18"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill="currentColor"
                          d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
                </svg>
            </button>
            @php
                $socialLogins = social_login_providers();
            @endphp
            <!-- Body -->
            <div class="modal-body">

                <!-- Login -->
                <div id="login">
                    <!-- Title -->
                    <div class="text-center mb-7">
                        <h3 class="mb-0">{{ __('itube::translation.sign_in_to_name', ['name' => setting('sitename')]) }}</h3>
                        <p>@lang('Login to manage your account.')</p>
                    </div>
                    <!-- End Title -->
                    <form method="post" action="{{ route('login') }}" class="form-ajax" data-notify="false" data-jw-token="true">
                        <div class="jquery-message mb-2"></div>

                        <!-- Input Group -->
                        <div class="js-form-message mb-4">
                            <label class="input-label">Email</label>
                            <div class="input-group input-group-sm mb-2">
                                <input type="email" class="form-control" name="email" id="signinEmail"
                                       placeholder="Email" aria-label="Email" required
                                       data-msg="Please enter a valid email address.">
                            </div>
                        </div>
                        <!-- End Input Group -->

                        <!-- Input Group -->
                        <div class="js-form-message mb-3">
                            <label class="input-label">Password</label>
                            <div class="input-group input-group-sm mb-2">
                                <input type="password" class="form-control" name="password" id="signinPassword"
                                       placeholder="Password" aria-label="Password" required
                                       data-msg="Your password is invalid. Please try again.">
                            </div>
                        </div>
                        <!-- End Input Group -->

                        <div class="d-flex justify-content-end mb-4">
                            <a class="js-animation-link small link-underline" href="javascript:;"
                               data-hs-show-animation-options='{
                                        "targetSelector": "#forgotPassword",
                                        "groupName": "idForm"
                                    }'>@lang('Forgot Password?')
                            </a>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-sm btn-primary btn-block" data-loading-text="{{ __('itube::translation.please_wait') }}">@lang('Sign In')</button>
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

                    <div class="text-center">
                        <span class="small text-muted">@lang('Do not have an account?')</span>
                        <a class="js-animation-link small font-weight-bold" href="javascript:;"
                           data-hs-show-animation-options='{
                                        "targetSelector": "#signup",
                                        "groupName": "idForm"
                                    }'>Sign Up
                        </a>
                    </div>
                </div>

                <!-- Signup -->
                <div id="signup" style="display: none; opacity: 0;">
                    <!-- Title -->
                    <div class="text-center mb-7">
                        <h3 class="mb-0">Create your account</h3>
                        <p>Fill out the form to get started.</p>
                    </div>
                    <!-- End Title -->

                    <form method="post" action="{{ route('register') }}" class="form-ajax" data-notify="false" data-jw-token="true">
                        <div class="jquery-message mb-2"></div>

                        <!-- Input Group -->
                        <div class="js-form-message mb-4">
                            <label class="input-label">Email</label>
                            <div class="input-group input-group-sm mb-2">
                                <input type="email" class="form-control" name="email" id="signupEmail"
                                       placeholder="Email" aria-label="Email" required
                                       data-msg="Please enter a valid email address.">
                            </div>
                        </div>
                        <!-- End Input Group -->

                        <!-- Input Group -->
                        <div class="js-form-message mb-4">
                            <label class="input-label">Password</label>
                            <div class="input-group input-group-sm mb-2">
                                <input type="password" class="form-control" name="password" id="signupPassword"
                                       placeholder="Password" aria-label="Password" required
                                       data-msg="Your password is invalid. Please try again.">
                            </div>
                        </div>
                        <!-- End Input Group -->

                        <!-- Input Group -->
                        <div class="js-form-message mb-4">
                            <label class="input-label">Confirm Password</label>
                            <div class="input-group input-group-sm mb-2">
                                <input type="password" class="form-control" name="confirmPassword"
                                       id="signupConfirmPassword" placeholder="Confirm Password"
                                       aria-label="Confirm Password" required
                                       data-msg="Password does not match the confirm password.">
                            </div>
                        </div>
                        <!-- End Input Group -->

                        <div class="mb-3">
                            <button type="submit" class="btn btn-sm btn-primary btn-block" data-loading-text="{{ __('itube::translation.please_wait') }}">Sign Up</button>
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

                </div>
                <!-- End Signup -->

                <!-- Forgot Password -->
                <div id="forgotPassword" style="display: none; opacity: 0;">
                    <!-- Title -->
                    <div class="text-center mb-7">
                        <h3 class="mb-0">@lang('Recover password')</h3>
                        <p>@lang('Instructions will be sent to you.')</p>
                    </div>
                    <!-- End Title -->

                    <form action="" class="js-validate">
                        <!-- Input Group -->
                        <div class="js-form-message">
                            <label class="sr-only" for="recoverEmail">Your email</label>
                            <div class="input-group input-group-sm mb-2">
                                <input type="email" class="form-control" name="email" id="recoverEmail"
                                       placeholder="Your email" aria-label="Your email" required
                                       data-msg="Please enter a valid email address.">
                            </div>
                        </div>
                        <!-- End Input Group -->

                        <div class="mb-3">
                            <button type="submit"
                                    class="btn btn-sm btn-primary btn-block">@lang('Recover Password')</button>
                        </div>
                    </form>

                    <div class="text-center mb-4">
                        <span class="small text-muted">@lang('Remember your password?')</span>
                        <a class="js-animation-link small font-weight-bold" href="javascript:;"
                           data-hs-show-animation-options='{
                                        "targetSelector": "#login",
                                        "groupName": "idForm"
                                    }'>@lang('Login')
                        </a>
                    </div>
                </div>
                <!-- End Forgot Password -->

            </div>
            <!-- End Body -->
        </div>
    </div>
</div>
<!-- End Login Modal -->
