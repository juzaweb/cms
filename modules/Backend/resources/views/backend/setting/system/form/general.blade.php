@php
    $registration = get_config('user_registration');
    $verification = get_config('user_verification');
    $timezones = timezone_identifiers_list();
    $sitetimezone = get_config('timezone', 'UTC');
    $dateFormat = get_config('date_format', 'F j, Y');
    $timeFormat = get_config('time_format', 'g:i a');
    $captcha = get_config('captcha');

    $dateFormats = [
        'F j, Y' => now()->format('F j, Y'),
        'Y-m-d' => now()->format('Y-m-d'),
        'm/d/Y' => now()->format('m/d/Y'),
        'd/m/Y' => now()->format('d/m/Y'),
    ];

    $timeFormats = [
        'g:i a' => now()->format('g:i a'),
        'g:i A' => now()->format('g:i A'),
        'H:i' => now()->format('H:i'),
    ]
@endphp
<form action="{{ route('admin.setting.save') }}" method="post" class="form-ajax">
    <input type="hidden" name="form" value="{{ $component }}">

<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="btn-group float-right">
                    <button type="submit" class="btn btn-success"> {{ trans('cms::app.save') }} </button>
                    <button type="reset" class="btn btn-default"> {{ trans('cms::app.reset') }} </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
    <div class="col-md-8">
        <h5>{{ trans('cms::app.general') }}</h5>

        {{ Field::text(trans('cms::app.site_title'), 'title', [
            'value' => get_config('title')
        ]) }}

        <div class="form-group">
            <label class="col-form-label" for="description">{{ trans('cms::app.tagline') }}</label>
            <textarea class="form-control" name="description" id="description" rows="4">{{ get_config('description') }}</textarea>
            <p class="description">{{ trans('cms::app.site_description_note') }}</p>
        </div>

        {{ Field::text(trans('cms::app.sitename'), 'sitename', [
            'value' => get_config('sitename')
        ]) }}

        <div class="row">
            <div class="col-md-6">
                {{ Field::image(trans('cms::app.logo'), 'logo', [
                    'value' => get_config('logo')
                ]) }}
            </div>

            <div class="col-md-6">
                {{ Field::image(trans('cms::app.icon'), 'icon', [
                    'value' => get_config('icon')
                ]) }}
            </div>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="timezone">{{ trans('cms::app.timezone') }}</label>
            <select name="timezone" id="timezone" class="form-control select2">
                @foreach($timezones as $timezone)
                    <option value="{{ $timezone }}" @if($sitetimezone == $timezone) selected @endif>{{ $timezone }}</option>
                @endforeach
            </select>
            <p class="description">{{ trans('cms::app.timezone_description') }}</p>
            <p class="description">{{ trans('cms::app.current_time') }} {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="language">{{ trans('cms::app.site_language') }}</label>
            <select name="language" id="language" class="form-control load-locales">
                @if($locale = get_config('language'))
                    <option value="{{ $locale }}" selected>{{ config("locales.{$locale}.name") }}</option>
                @endif
            </select>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="date_format">{{ trans('cms::app.date_format') }}</label>
            <fieldset>
                @foreach($dateFormats as $key => $item)
                    <label class="mb-2">
                        <input type="radio" name="date_format" value="{{ $key }}" @if($key == $dateFormat) checked="checked" @endif>
                        <span class="date-time-text format-i18n mr-2">{{ $item }}</span><code>{{ $key }}</code>
                    </label><br>
                @endforeach

                <label>
                    <input type="radio" name="date_format" id="date_format_custom_radio" value="custom">
                    <span class="date-time-text date-time-custom-text">{{ trans('cms::app.custom') }}:
                        <span class="screen-reader-text ml-1"> {{ trans('cms::app.general_settings.enter_a_custom_date') }}</span>
                    </span>
                </label>

                <label for="date_format_custom" class="screen-reader-text">{{ trans('cms::app.general_settings.custom_date_format') }}:</label>
                <input type="text" name="date_format_custom" id="date_format_custom" value="{{ get_config('date_format_custom', 'F j, Y') }}" class="form-control w-25">
                <br>
                    {{--
                    <p><strong>Preview:</strong>
                        <span class="example">September 2, 2021</span><span class="spinner"></span>
                    </p>--}}
            </fieldset>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="time_format">{{ trans('cms::app.time_format') }}</label>
            <fieldset>
                @foreach($timeFormats as $key => $item)
                    <label>
                        <input type="radio" name="time_format" value="{{ $key }}" @if($key == $timeFormat) checked="checked" @endif />
                        <span class="date-time-text format-i18n mr-2">{{ $item }}</span>
                        <code>{{ $key }}</code>
                    </label>
                    <br />
                @endforeach

                    <label class="screen-reader-text">
                        <input type="radio" name="time_format" value="custom" @if($timeFormat == 'custom') checked="checked" @endif />
                        {{ trans('cms::app.general_settings.custom_time_format') }}:
                    </label>

                    <input type="text" name="time_format_custom" id="time_format_custom" value="{{ get_config('time_format_custom', 'g:i a') }}" class="form-control w-25"/>

                    <br />

                {{--<p>
                    <strong>Preview:</strong>
                    <span class="example">6:47 am</span><span class="spinner"></span>
                </p>--}}

                <p class="date-time-doc"><a href="https://wordpress.org/support/article/formatting-date-and-time/" target="_blank" rel="nofollow">{{ trans('cms::app.general_settings.time_formatting_documentation') }}</a>.</p>

            </fieldset>
        </div>

    </div>

    <div class="col-md-4">
        <h5>{{ trans('cms::app.analytics') }}</h5>

        <div class="form-group">
            <label class="col-form-label" for="fb_app_id">{{ trans('cms::app.fb_app_id') }}</label>
            <input type="text" name="fb_app_id" class="form-control" id="fb_app_id" value="{{ get_config('fb_app_id') }}" autocomplete="off">
        </div>

        <div class="form-group">
            <label class="col-form-label" for="google_analytics">{{ trans('cms::app.google_analytics_id') }}</label>
            <input type="text" name="google_analytics" class="form-control" id="google_analytics" value="{{ get_config('google_analytics') }}" autocomplete="off">
        </div>

        <h5>{{ trans('cms::app.registration') }}</h5>

        <div class="form-group">
            <label class="col-form-label" for="user_registration">{{ trans('cms::app.user_registration') }}</label>
            <select name="user_registration" id="user_registration" class="form-control">
                <option value="1" @if($registration == 1) selected @endif>{{ trans('cms::app.enabled') }}</option>
                <option value="0" @if($registration == 0) selected @endif>{{ trans('cms::app.disabled') }}</option>
            </select>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="user_verification">{{ trans('cms::app.user_e_mail_verification') }}</label>
            <select name="user_verification" id="user_verification" class="form-control">
                <option value="1" @if($verification == 1) selected @endif>{{ trans('cms::app.enabled') }}</option>
                <option value="0" @if($verification == 0) selected @endif>{{ trans('cms::app.disabled') }}</option>
            </select>
        </div>

        <h5>{{ trans('cms::app.captcha') }}</h5>
        <div class="form-group">
            <label class="col-form-label" for="captcha">{{ trans('cms::app.captcha') }}</label>
            <select name="captcha" id="captcha" class="form-control">
                <option value="">{{ trans('cms::app.disabled') }}</option>
                <option value="google_captcha_v2_invisible" @if($captcha == 'google_captcha_v2_invisible') selected @endif>{{ trans('cms::app.google_captcha.google_captcha_v2_invisible') }}</option>
            </select>
        </div>

        {{ Field::text(
            trans('cms::app.google_captcha.site_key'),
            'google_captcha[site_key]',
            [
                'value' => get_config('google_captcha')['site_key'] ?? ''
            ]
        ) }}

        {{ Field::security(
            trans('cms::app.google_captcha.secret_key'),
            'google_captcha[secret_key]',
            [
                'value' => get_config('google_captcha')['secret_key'] ?? ''
            ]
        ) }}

    </div>
</div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-md-6"></div>

            <div class="col-md-6">
                <div class="btn-group float-right">
                    <button type="submit" class="btn btn-success">
                        {{ trans('cms::app.save') }}
                    </button>

                    <button type="reset" class="btn btn-default">
                        {{ trans('cms::app.reset') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

</form>
