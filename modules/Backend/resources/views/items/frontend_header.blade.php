@if(request()->get('page'))
    <meta name="robots" content="noindex,follow">
@endif

@foreach($styles as $style)
    <link rel="stylesheet" type="text/css" href="{{ $style->get('src') }}{{ str_contains($style->get('src'), '?') ? '&v=' : '?v=' }}{{ $style->get('ver') }}" id="{{ $style->get('key') }}">
@endforeach

@foreach($scripts as $script)
    <script src="{{ $script->get('src') }}?v={{ $script->get('ver') }}" id="{{ $script->get('key') }}"></script>
@endforeach

<script>
    let jwdata = {
        base_url: "{{ url('/') }}"
    };
</script>

@if($googleAnalytics)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalytics }}"></script>
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
