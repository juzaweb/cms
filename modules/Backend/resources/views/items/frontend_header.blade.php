@if(request()->get('page'))
    <meta name="robots" content="noindex,follow">
@endif

@foreach($styles as $style)
    <link rel="stylesheet" type="text/css" href="{{ $style->get('src') }}?v={{ $style->get('ver') }}" id="{{ $style->get('key') }}">
@endforeach

@if(get_config('captcha'))
    <script>const recaptchaSiteKey = "{{ get_config("google_captcha.site_key") }}";</script>
    <script src="https://www.google.com/recaptcha/api.js?onload=recaptchaLoadCallback&render=explicit" async defer></script>
@endif

@foreach($scripts as $script)
    <script src="{{ $script->get('src') }}?v={{ $script->get('ver') }}" id="{{ $script->get('key') }}"></script>
@endforeach

<script>
    let jwdata = {
        base_url: "{{ url('/') }}"
    };
</script>

@if($googleAnalytics)
    <script async src="https://www.googletagmanager.com/gtag/js"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{ $googleAnalytics }}');
    </script>
@endif

@if($fbAppId)
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&autoLogAppEvents=1&version=v8.0&appId={{ $fbAppId }}" nonce="ozkqznFT"></script>
@endif

@if($bingKey)
<meta name="msvalidate.01" content="{{ $bingKey }}" />
@endif

@if($googleKey)
    <meta name="google-site-verification" content="{{ $googleKey }}" />
@endif
