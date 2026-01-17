@php
    /** @var \Juzaweb\Modules\Core\Models\Pages\PageBlock $block */
    use Juzaweb\Modules\VideoSharing\Models\Video;use Juzaweb\Modules\VideoSharing\Models\VideoCategory;

    $categoryId = $block->data['category'] ?? null;
    $limit = $block->data['limit'] ?? 12;
    $label = $block->data['label'] ?? null;
    
    $videos = collect();
    $categoryName = null;
    
    if ($categoryId) {
        $category = VideoCategory::withTranslation()->find($categoryId);
        
        if ($category) {
            $categoryName = $category->name;
            $videos = Video::with(['media', 'channel'])
                ->withTranslation()
                ->whereFrontend()
                ->whereHas('categories', function($query) use ($categoryId) {
                    $query->where('video_categories.id', $categoryId);
                })
                ->orderBy('created_at', 'desc')
                ->take($limit)
                ->get();
        }
    }
    
    // Use custom label if provided, otherwise use category name
    $displayLabel = $label ?: ($categoryName ?: __('itube::translation.videos_by_category'));
@endphp

@if($videos->isNotEmpty())
    <section>
        <div class="mb-4">
            <div class="home-section">
                <header class="d-md-flex align-items-center justify-content-between mb-4 pb-1 w-100">
                    <h6 class="font-size-24 font-weight-medium m-0 text-gray-700">
                        {{ $displayLabel }}</h6>
                    <div class="border-top col p-0 ml-3 border-gray-3600"></div>
                </header>
            </div>
            <div class="row mx-n2">
                @foreach ($videos as $video)
                    @component('itube::components.video-item', ['video' => $video])
                    @endcomponent
                @endforeach
            </div>
        </div>
    </section>
@endif
