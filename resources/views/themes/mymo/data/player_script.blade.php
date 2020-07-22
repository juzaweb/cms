<script>
    var resumeId = encodeURI('5d1d90fdec293317a9cd9bb7c444ead9'),
        playerInstance = jwplayer('ajax-player');

    if(typeof playerInstance != 'undefined'){

        playerInstance.setup({
            key: "ITWMv7t88JGzI0xPwW8I0+LveiXX9SWbfdmt0ArUSyc=",
            primary: "html5",
            playlist: [{
                title: "Đẹp Trai Là Số 1",
                image: "/wp-content/uploads/2020/05/dep-trai-la-so-1-15425-poster.jpg",
                sources: [
                    {
                    "label":"720p",
                    "type":"mp4",
                    "file":"http:\/\/api.3s.live\/api\/redirect?file=0a6ea0021431d9de3f57c7dc86e51af2c715e3af0b005643a13535d44abf20412a3e15fe4732dbc1be3b195470d8b048&label=720p"},
                    {
                        "label":"360p",
                        "type":"mp4",
                        "file":"http:\/\/api.3s.live\/api\/redirect?file=0a6ea0021431d9de3f57c7dc86e51af2c715e3af0b005643a13535d44abf20412a3e15fe4732dbc1be3b195470d8b048&label=360p"}
                ],

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
                sites: ["reddit","facebook","twitter","googleplus","email","linkedin"]
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
