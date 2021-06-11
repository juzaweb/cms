@if($file->isSourceEmbed())
    <div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="{{ @$files[0]->file }}" allowfullscreen></iframe></div>
@else
<script type="text/javascript">

    var resumeId = encodeURI('{{ md5(json_encode($files)) }}');
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
            @if($ads_exists)
            advertising: {
                client: 'vast',
                admessage: '@lang('mymo::app.ads_have_xx_seconds_left')',
                skiptext: '@lang('mymo::app.skip_ad')',
                skipmessage: '@lang('mymo::app.skip_later_xxs')',
                schedule: {
                    'ad1': {
                        'offset': '1',
                        'skipoffset': '5',
                        'tag': '{{ route('ads.videos') }}'
                    },

                }
            }
            @endif
        });

        mymoResumeVideo(resumeId, playerInstance);

        mymoJwConfig(playerInstance);

    }

</script>
@endif