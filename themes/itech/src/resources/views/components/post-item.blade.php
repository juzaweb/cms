<div class='blog-post hentry index-post post-0'>
    <div class='index-post-inside-wrap'>
        <div class='post-image-wrap'>
            <a class='post-image-link' href="{{ $post->getUrl() }}">
                <img alt='{{ $post->title }}'
                    src='{{ proxy_image($post->thumbnail, 280, 210) }}'
                    srcset="{{ proxy_image($post->thumbnail, 280, 210) }} 280w, {{ proxy_image($post->thumbnail, 560, 420) }} 560w"
                    class="lazy-yard"
                />
            </a>
        </div>
        <div class='post-info'>
            @php
                $category = $post->categories->first();
            @endphp
            @if($category)
                <a class='post-tag' href='{{ $category->getUrl() }}'>
                    {{ $category->name }}
                </a>
            @endif
            
            <h2 class='post-title'>
                <a href='{{ $post->getUrl() }}'>{{ $post->title }}</a>
            </h2>
            <div class='index-post-footer'>
                <p class='post-snippet'>{{ $post->title }}</p>
                <div class='post-meta'>
                    <span class='post-date published' datetime='{{ $post->created_at->toIso8601String() }}'>
                        {{ $post->created_at->format('F d, Y') }}
                    </span>
                </div>
                <a class='read-more' href='{{ $post->getUrl() }}'>
                    <span>{{ __('itech::translation.read_more') }}</span>
                </a>
            </div>
        </div>
    </div>
</div>
