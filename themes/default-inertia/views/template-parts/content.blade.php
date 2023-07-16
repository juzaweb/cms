<div class="article__entry">
    @php
        /**
        * @var \Juzaweb\Backend\Models\Post $post
        */
    @endphp

    @php $categories = get_post_taxonomies($post, 'categories', ['limit' => 1]) @endphp

    <div class="article__image">
        <a href="{{ $post->getLink() }}" title="{{ $post->title }}">
            <img src="{{ $post->getThumbnail() }}" alt="{{ $post->title }}" class="img-fluid">
        </a>
    </div>

    <div class="article__content">
        @foreach($categories as $category)
            <div class="article__category">
                {{ $category->name }}
            </div>
        @endforeach

        <ul class="list-inline">
            <li class="list-inline-item">
                <span class="text-primary">
                    {{ __('by') }} {{ $post->createdBy->name }}
                </span>
            </li>

            <li class="list-inline-item">
                <span class="text-dark text-capitalize">
                    {{ $post->getCreatedDate() }}
                </span>
            </li>
        </ul>

        <h5>
            <a href="{{ $post->getLink() }}" title="{{ $post->title }}">
                {{ $post->title }}
            </a>
        </h5>

        <p>{{ $post->getDescription() }}</p>

        <a href="{{ $post->getLink() }}" class="btn btn-outline-primary mb-4 text-capitalize"> {{ __('read more') }}</a>
    </div>
</div>
