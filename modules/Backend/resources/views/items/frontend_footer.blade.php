@if(get_config('captcha') && get_config('auto_init_recaptcha'))
    <script>const recaptchaSiteKey = "{{ get_config("google_captcha.site_key") }}";</script>
    <script src="https://www.google.com/recaptcha/api.js?onload=recaptchaLoadCallback&render=explicit" async defer></script>

    <div id="recaptcha-render" style="display: none;"></div>
@endif

@foreach($scripts as $script)
    <script src="{{ $script->get('src') }}?v={{ $script->get('ver') }}" id="{{ $script->get('key') }}" @if($script->get('options')['async'] ?? false) async @endif></script>
@endforeach

@foreach($styles as $style)
    <link rel="stylesheet" type="text/css" href="{!! $style->get('src') !!}{!! str_contains($style->get('src'), '?') ? '&v=' : '?v=' !!}{{ $style->get('ver') }}" id="{{ $style->get('key') }}">
@endforeach
