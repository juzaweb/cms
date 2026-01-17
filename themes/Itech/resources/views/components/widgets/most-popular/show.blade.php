@php
    /** @var \Juzaweb\Modules\Core\Support\Entities\Widget $widget */
    /** @var \Juzaweb\Modules\Core\Models\ThemeSidebar $sidebar */
    $posts = \Juzaweb\Modules\Blog\Models\Post::whereFrontend()
        ->whereMostPopular()
        ->limit($sidebar->limit ?? 5)
        ->get();
@endphp
<div class='widget PopularPosts' data-version='2' id='PopularPosts3'>
    <div class='widget-title'>
        <h3 class='title'>
            {{ $sidebar->label }}
        </h3>
    </div>
    <div class='widget-content'>
        @foreach($posts as $post)
            <div class='post'>
                <div class='post-content'>
                    <a class='post-image-link'
                       href='{{ $post->getUrl() }}'>
                        <img alt='{{ $post->title }}' class='post-thumb lazy-yard'
                             src='{{ proxy_image($post->thumbnail, 72, 72) }}'/>
                    </a>
                    <div class='post-info'>
                        <h2 class='post-title'>
                            <a href='{{ $post->getUrl() }}'>
                                {{ $post->title }}
                            </a>
                        </h2>

                        <div class='post-meta'>
                            <span class='post-date published' datetime='{{ $post->created_at->toIso8601String() }}'>
                                {{ $post->created_at->format('F d, Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
