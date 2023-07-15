@extends('cms::layouts.frontend-blade')

@section('content')
    @php
        /**
        * @var \Juzaweb\Backend\Models\Post $post
        */
    @endphp

    @php $tags = get_post_taxonomies($post, 'tags', ['limit' => 5]) @endphp
    @php $categories = get_post_taxonomies($post, 'categories') @endphp

    @php $cat = $categories[0] ?? null @endphp
    @php $related = get_related_posts($post, 5, 'categories') @endphp

    <section class="pb-80">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- breaddcrumb -->
                    <!-- Breadcrumb -->
                    <ul class="breadcrumbs bg-light mb-4">
                        <li class="breadcrumbs__item">
                            <a href="{{ url('/') }}" class="breadcrumbs__url">
                                <i class="fa fa-home"></i> {{ __('Home') }}
                            </a>
                        </li>

                        @if($cat)
                        <li class="breadcrumbs__item breadcrumbs__item--current">
                            {{ $cat->name }}
                        </li>
                        @endif

                    </ul>
                    <!-- end breadcrumb -->
                </div>
                <div class="col-md-8">
                    <!-- content article detail -->
                    <!-- Article Detail -->
                    <div class="wrap__article-detail">
                        <div class="wrap__article-detail-title">
                            <h1>
                                {{ $post->title }}
                            </h1>
                            <h3>
                                {{ $post->description }}
                            </h3>
                        </div>
                        <hr>
                        <div class="wrap__article-detail-info">
                            <ul class="list-inline">
                                {{--<li class="list-inline-item">
                                    <figure class="image-profile">
                                        <img src="images/placeholder/logo.jpg" alt="">
                                    </figure>
                                </li>--}}

                                <li class="list-inline-item">
                                    <span>
                                        {{ __('by') }}
                                    </span>
                                    <a href="#">
                                        {{ $post->createdBy->name }},
                                    </a>
                                </li>

                                <li class="list-inline-item">
                                    <span class="text-dark text-capitalize ml-1">
                                        {{ $post->created_at }}
                                    </span>
                                </li>

                                <li class="list-inline-item">
                                    <span class="text-dark text-capitalize">
                                        {{ __('in') }}
                                    </span>
                                    @foreach($categories as $category)
                                    <a href="{{ $category->url }}">
                                        {{ $category->name }}
                                    </a>
                                    @endforeach
                                </li>

                            </ul>
                        </div>

                        <div class="wrap__article-detail-image mt-4">
                            <figure>
                                <img src="{{ $post->getThumbnail(false) }}" alt="{{ $post->title }}" class="img-fluid">
                            </figure>
                        </div>

                        <div class="wrap__article-detail-content">
                            <div class="total-views">
                                <div class="total-views-read">
                                    {{ $post->getViews() }}
                                    <span>
                                        {{ __('views') }}
                                    </span>
                                </div>

                                <ul class="list-inline">
                                    <span class="share">{{ __('share on') }}:</span>
                                    <li class="list-inline-item">
                                        <a class="btn btn-social-o facebook"
                                           href="https://www.facebook.com/sharer.php?u={{ url()->current() }}">
                                            <i class="fa fa-facebook-f"></i>
                                            <span>facebook</span>
                                        </a>
                                    </li>

                                    <li class="list-inline-item">
                                        <a class="btn btn-social-o twitter"
                                           href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $title }}">
                                            <i class="fa fa-twitter"></i>
                                            <span>twitter</span>
                                        </a>
                                    </li>

                                    <li class="list-inline-item">
                                        <a class="btn btn-social-o telegram"
                                           href="https://t.me/share/url?url={{ url()->current() }}&text={{ $title }}">
                                            <i class="fa fa-telegram"></i>
                                            <span>telegram</span>
                                        </a>
                                    </li>

                                    <li class="list-inline-item">
                                        <a class="btn btn-linkedin-o linkedin"
                                           href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}">
                                            <i class="fa fa-linkedin"></i>
                                            <span>linkedin</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>

                            {{ $post->content }}
                        </div>
                    </div>
                    <!-- end content article detail -->

                    <!-- tags -->
                    <div class="blog-tags">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <i class="fa fa-tags"></i>
                            </li>

                            @foreach($tags as $tag)
                                <li class="list-inline-item">
                                    <a href="{{ $tag->url }}">
                                        #{{ $tag->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- end tags-->

                    <!-- comment -->
                    {% if errors.any() %}
                        <div class="alert alert-danger">
                            <ul class="list-group">
                                {% for error in errors.all() %}
                                    <li class="list-group-item">{{ error }}</li>
                                {% endfor %}
                            </ul>
                        </div>
                    {% endif %}

                    {% if status == 'success' %}
                        <div class="alert alert-success">
                            {{ message }}
                        </div>
                    {% endif %}

                    <!-- Comment  -->
                    <div id="comments" class="comments-area">
                        {{ comment_template($post, 'theme::components.comments') }}

                        <div class="comment-respond">
                            <h3 class="comment-reply-title">{{ __('Leave a Reply') }}</h3>
                            {{ comment_form($post) }}
                        </div>
                    </div>

                    <!-- Comment -->
                    <!-- end comment -->

                    <div class="row">
                        <div class="col-md-6">
                            @php $previousPost = get_previous_post($post) @endphp

                            @if($previousPost)
                            <div class="single_navigation-prev">
                                <a href="{{ $previousPost->url }}">
                                    <span>{{ __('previous post') }}</span>
                                    {{ $previousPost->title }}
                                </a>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            @php $nextPost = get_next_post($post) @endphp

                            @if($nextPost)
                            <div class="single_navigation-next text-left text-md-right">
                                <a href="{{ $nextPost->url }}">
                                    <span>{{ __('next post') }}</span>
                                    {{ $nextPost->title }}
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    @if($related)
                    <div class="related-article">
                        <h4>
                            {{ __('you may also like') }}
                        </h4>

                        <div class="article__entry-carousel-three">
                            @foreach($related as $item)
                            <div class="item">
                                <div class="article__entry">
                                    <div class="article__image">
                                        <a href="{{ item.url }}">
                                            <img src="{{ item.thumbnail }}" alt="{{ item.title }}" class="img-fluid">
                                        </a>
                                    </div>

                                    <div class="article__content">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <span class="text-primary">
                                                    {{ __('by') }} {{ item.author.name }}
                                                </span>
                                            </li>

                                            <li class="list-inline-item">
                                                <span class="text-dark text-capitalize">
                                                    {{ item.created_at }}
                                                </span>
                                            </li>
                                        </ul>
                                        <h5>
                                            <a href="{{ item.url }}">
                                                {{ item.title }}
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="sticky-top">
                        {{ dynamic_sidebar('sidebar') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
