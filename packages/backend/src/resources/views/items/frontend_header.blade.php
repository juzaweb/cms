@foreach($styles as $style)
    <link rel="stylesheet" type="text/css" href="{{ $style->get('src') }}?v={{ $style->get('ver') }}">
@endforeach

@foreach($scripts as $script)
    <script src="{{ $script->get('src') }}?v={{ $script->get('ver') }}"></script>
@endforeach

<script async src="https://www.googletagmanager.com/gtag/js"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    @if($gtag = config('app.site_gtag'))
    @php
    $domain = request()->getHost();
    @endphp
    gtag('config', '{{ $gtag }}', {
        @if($domain != config('app.domain'))
        'linker': {
            'domains': ['juzaweb.com']
        }
        @endif
    });

    gtag('event', 'jw_page_view', {'jw_domain': '{{ $domain }}'});
    @endif

    @if($googleAnalytics)
    gtag('config', '{{ $googleAnalytics }}');
    @endif
</script>

@if($fbAppId)
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&autoLogAppEvents=1&version=v8.0&appId={{ $fbAppId }}" nonce="ozkqznFT"></script>
@endif
