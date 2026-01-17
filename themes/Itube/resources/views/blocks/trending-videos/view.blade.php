@php
    /** @var \Juzaweb\Modules\Core\Models\Pages\PageBlock $block */
    use Juzaweb\Modules\VideoSharing\Models\Video;
    
    $limit = $block->data['limit'] ?? 8;
    $label = $block->label ?? __('itube::translation.trending_videos');
    
    $trendingVideos = Video::with(['media', 'channel'])
        ->withTranslation()
        ->whereFrontend()
        ->orderBy('views', 'desc')
        ->take($limit)
        ->get();
@endphp

<section>
    <div class="mb-4">
        <div class="home-section">
            <header class="d-md-flex align-items-center justify-content-between mb-4 pb-1 w-100">
                <h6 class="font-size-24 font-weight-medium m-0 text-gray-700">
                    {{ $label }}</h6>
                <div class="border-top col p-0 ml-3 border-gray-3600"></div>
            </header>
        </div>
        <div class="row mx-n2">
            @foreach ($trendingVideos as $video)
                @component('itube::components.video-item', ['video' => $video])
                @endcomponent
            @endforeach
        </div>
    </div>
</section>
