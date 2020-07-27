<script>
    var resumeId = encodeURI('5d1d90fdec293317a9cd9bb7c444ead9');
    var playerInstance = jwplayer('ajax-player');
    var files = JSON.parse('{!! json_encode($files) !!}');

    if(typeof playerInstance != 'undefined'){

        playerInstance.setup({
            key: "ITWMv7t88JGzI0xPwW8I0+LveiXX9SWbfdmt0ArUSyc=",
            primary: "html5",
            playlist: [{
                title: "{{ $movie->name }}",
                image: "{{ $movie->getPoster() }}",
                sources: files,
                tracks: [],
                captions: {
                    color: "#fff",
                    fontSize: 14,
                    backgroundOpacity: 0,
                    edgeStyle: "raised"
                }
            }],
            @if(get_config('player_watermark'))
            logo: {
                file: "{{ image_url(get_config('player_watermark_logo')) }}",
                link: "{{ url('/') }}",
                hide: "true",
                target: "_blank",
                position: "top-right",
            },
            @endif
            floating: {
                dismissible: true
            },
            autoPause: {
                viewability: true,
                pauseAds: true
            },
            base: ".",
            width: "100%",
            height: "100%",
            hlshtml: true,
            autostart: true,
            fullscreen: true,
            playbackRateControls: true,
            displayPlaybackLabel: true,
            aspectratio: "16:9",
            sharing: {
                sites: [
                    "reddit",
                    "facebook",
                    "twitter",
                    "email",
                    "linkedin"
                ]
            },
            advertising: {
                client: 'vast',
                admessage: 'Quảng cáo còn XX giây.',
                skiptext: 'Bỏ qua quảng cáo',
                skipmessage: 'Bỏ qua sau xxs',
                schedule: {
                    'qc1': {
                        'offset': '1',
                        'skipoffset': '5',
                        'tag': 'http://xemphimplus.net/link/ads.xml'
                    },

                }

            }
        });

        halimResumeVideo(resumeId, playerInstance);

        halimJwConfig(playerInstance);

    }

</script>

{{--
<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://drive.google.com/file/d/1Itae9uwt7G7tRgFFCq0IhMTwib8j4ijg/preview" allowfullscreen></iframe></div>--}}
