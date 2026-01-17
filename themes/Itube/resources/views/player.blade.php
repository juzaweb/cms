@php
    /** @var \Juzaweb\Modules\VideoSharing\Models\Video $video */
    /** @var array $vastAds */
@endphp

<div id="video-ad-container" style="position: relative;">
    <video id="player" preload="none" style="max-width: 100%;" controls="" poster="{{ $video->thumbnail }}"
        autoplay>
        <!-- Add multiple <source>-tags and set text per `data-quality`-attribute -->
        @foreach ($video->files as $file)
            <source type="{{ $file->mime_type }}" src="{{ $file->getVideoUrl() }}"
                data-quality="{{ strtoupper($file->quality) }}">
        @endforeach
        <!-- Just add multiple <track> files, they get integrated automatically -->
        {{-- <track src="dist/mediaelement.vtt" srclang="en" label="English" kind="captions" type="text/vtt"> --}}
    </video>
</div>

<script>
    $(function() {
        const videoElement = document.getElementById('player');

        const player = new MediaElementPlayer('player', {
            iconSprite: '/themes/itube/images/mejs-controls.svg',
            features: [
                'playpause',
                'current',
                'progress',
                'duration',
                'volume',
                // 'tracks',
                // 'quality',
                'fullscreen',
                @if($hasAds)
                    'ads',
                    'vast',
                @endif
            ],
            vastAdTagUrl: '{{ route('ads.video.show', ['position' => 'video-player']) }}',
            vastAdsType: 'vast',
            adsPrerollAdEnableSkip: true,
            adsPrerollAdSkipSeconds: 5,
            success: function(media) {
                media.addEventListener('ended', function(e) {
                    // $('#adContainer').slideUp();

                    // src = $('video').attr('src');
                    // sources = $('video').find('source');
                    // for (var i = sources.length - 1; i >= 0; i--) {
                    //     if ($(sources[i]).attr('src') == src) {
                    //         AfterEndVideo(true);
                    //     }
                    // }
                }, false);

                media.addEventListener('playing', function(e) {
                    player.setPlayerSize('100%', '100%');
                });
            },
        });

        player.setPlayerSize('100%', '100%');
    });
</script>
