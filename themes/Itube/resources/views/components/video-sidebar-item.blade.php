@php
    /** @var \Juzaweb\Modules\VideoSharing\Models\Video $video */
@endphp
<div class="row d-block d-xl-flex align-items-center no-gutters mb-2d">
    <div class="col product-image mb-2d mb-xl-0">
        <a href="{{ $video->getUrl() }}" class="d-block  stretched-link">
            <img class="img-fluid lazyload" src="{{ asset('themes/itube/images/video-loading.jpg') }}"
                 data-src="{{ $video->thumbnail }}" alt="{{ $video->title }}"/>
        </a>
    </div>
    <div class="col">
        <div class="mx-xl-2d">
            <div class="product_title font-size-13 font-weight-semi-bold mb-1d">
                <a href="{{ $video->getUrl() }}" class="max-3-lines" title="{{ $video->title }}">
                    {{ $video->title }}
                </a>
            </div>

            <div class="product-meta dot font-size-12 mb-1">
                <span class="d-inline-flex text-gray-1300">{{ $video->views }} @lang('views')</span>
                <span class="d-inline-flex text-gray-1300">{{ $video->created_at?->diffForHumans() }}</span>
            </div>
        </div>
    </div>
</div>
