@php
    /** @var \Juzaweb\Modules\VideoSharing\Models\Video $video */
@endphp
<div class="col-md-4 col-lg-3 px-2">
    <div class="product mb-4">
        <div class="product-image mb-2">
            <a class="d-block position-relative stretched-link" href="{{ $video->getUrl() }}">
                <img class="img-fluid lazyload" src="{{ asset('themes/itube/images/video-loading.jpg') }}"
                     data-src="{{ $video->thumbnail }}" alt="Image-Desc"
                     title="{{ $video->title }}"
                >
            </a>
        </div>
        <h6 class="font-size-1 font-weight-bold mb-0 product-title d-inline-block">
            <a href="{{ $video->getUrl() }}" title="{{ $video->title }}">
                {{ $video->title }}
            </a>
        </h6>
        <div class="font-size-12 text-gray-1300">
            <span>{{ $video->views }} @lang('views')</span>
            <span class="product-comment">{{ $video->created_at?->diffForHumans() }}</span>
        </div>
    </div>
</div>
