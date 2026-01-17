@extends('itube::layouts.main')

@section('title', __('itube::translation.contact_us'))

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-lg-auto d-none d-xl-block">
                @include('itube::components.sidebar', ['active' => 'contact'])
            </div>
            <div class="col-lg">
                <div class="max-w-md-1160 ml-auto my-6 mb-lg-8 pb-lg-1">
                    <!-- Contact Header -->
                    <div class="mb-4">
                        <h2 class="font-weight-medium text-gray-700">
                            {{ __('itube::translation.contact_us') }}
                        </h2>
                        <p class="text-gray-600">
                            {{ __('itube::translation.contact_description') }}
                        </p>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Contact Form -->
                            <form data-form="contact_form" action="{{ route('contact.store') }}" method="POST">
                                @csrf

                                <div class="alert" role="alert" data-alert="result" style="display: none;"></div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="contactName"
                                                class="form-label">{{ __('itube::translation.your_name') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" id="contactName"
                                                placeholder="{{ __('itube::translation.your_name') }}" required
                                                data-msg="{{ __('itube::translation.please_enter_name') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="contactEmail"
                                                class="form-label">{{ __('itube::translation.email_address') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" id="contactEmail"
                                                placeholder="{{ __('itube::translation.email_address') }}" required
                                                data-msg="{{ __('itube::translation.please_enter_valid_email') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="contactPhone"
                                                class="form-label">{{ __('itube::translation.phone_number') }}</label>
                                            <input type="text" class="form-control" name="phone" id="contactPhone"
                                                placeholder="{{ __('itube::translation.phone_number') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="contactSubject"
                                                class="form-label">{{ __('itube::translation.subject') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="subject" id="contactSubject"
                                                placeholder="{{ __('itube::translation.subject') }}" required
                                                data-msg="{{ __('itube::translation.please_enter_subject') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="contactMessage"
                                            class="form-label">{{ __('itube::translation.message') }} <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="6" name="message" id="contactMessage"
                                            placeholder="{{ __('itube::translation.your_message') }}" required
                                            data-msg="{{ __('itube::translation.please_enter_message') }}"></textarea>
                                    </div>
                                </div>

                                <div class="text-left">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('itube::translation.send_message') }}
                                    </button>
                                </div>
                            </form>
                            <!-- End Contact Form -->
                        </div>

                        <div class="col-lg-4 mt-4 mt-lg-0">
                            <!-- Contact Information -->
                            <h5 class="mb-3">{{ __('itube::translation.contact_information') }}</h5>

                            @if (theme_setting('contact_address'))
                                <div class="mb-3">
                                    <div class="d-flex">
                                        <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                                        <div>
                                            <strong>{{ __('itube::translation.address') }}</strong>
                                            <p class="mb-0">{{ theme_setting('contact_address') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (theme_setting('contact_phone'))
                                <div class="mb-3">
                                    <div class="d-flex">
                                        <i class="fas fa-phone mt-1 mr-3"></i>
                                        <div>
                                            <strong>{{ __('itube::translation.phone') }}</strong>
                                            <p class="mb-0">{{ theme_setting('contact_phone') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (theme_setting('contact_email'))
                                <div class="mb-3">
                                    <div class="d-flex">
                                        <i class="fas fa-envelope mt-1 mr-3"></i>
                                        <div>
                                            <strong>{{ __('itube::translation.email') }}</strong>
                                            <p class="mb-0">{{ theme_setting('contact_email') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!-- End Contact Information -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function($) {
            'use strict';

            // Contact form AJAX handling
            if ($('[data-form="contact_form"]').length) {
                var form = $('[data-form="contact_form"]'),
                    alert_message = form.find('[data-alert="result"]'),
                    form_data,
                    submitButton = form.find('button[type="submit"]');

                // Success function
                function sending_done(response) {
                    alert_message.fadeIn().removeClass('alert-danger').addClass('alert-success');
                    alert_message.text(response.message || '{{ __('itube::translation.message_sent_success') }}');
                    form.find('input:not([type="submit"]), textarea').val('');
                    submitButton.prop('disabled', false).text('{{ __('itube::translation.send_message') }}');

                    // Hide message after 5 seconds
                    setTimeout(function() {
                        alert_message.fadeOut();
                    }, 5000);

                    return false;
                }

                // Fail function
                function sending_fail(data) {
                    alert_message.fadeIn().removeClass('alert-success').addClass('alert-danger');

                    if (data.responseJSON && data.responseJSON.errors) {
                        var errors = data.responseJSON.errors;
                        var errorMessages = [];

                        for (var field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                errorMessages.push(errors[field].join(' '));
                            }
                        }

                        alert_message.html(errorMessages.join('<br>'));
                    } else if (data.responseJSON && data.responseJSON.message) {
                        alert_message.text(data.responseJSON.message);
                    } else {
                        alert_message.text(data.responseText || '{{ __('itube::translation.error_occurred') }}');
                    }

                    submitButton.prop('disabled', false).text('{{ __('itube::translation.send_message') }}');

                    // Hide message after 10 seconds
                    setTimeout(function() {
                        alert_message.fadeOut();
                    }, 10000);

                    return false;
                }

                form.submit(async function(e) {
                    if (e.isDefaultPrevented()) {
                        return false;
                    }

                    e.preventDefault();

                    // Disable submit button to prevent double submission
                    submitButton.prop('disabled', true).text('{{ __('itube::translation.sending') }}');

                    let token = await loadReCaptcha();
                    form_data = $(this).serialize();
                    form_data += '&jw-token=' + token;
                    $.ajax({
                            type: 'POST',
                            url: form.attr('action'),
                            data: form_data,
                        })
                        .done(sending_done)
                        .fail(sending_fail);
                });
            }
        })(jQuery);
    </script>
@endsection
