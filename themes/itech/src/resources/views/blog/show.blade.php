@extends('itech::layouts.main')

@section('title', $post->title)

@section('content')
    <!-- Content Wrapper -->
    <div class='row' id='content-wrapper'>
        <div class='container'>
            <!-- Main Wrapper -->
            <div id='main-wrapper'>
                <div class='main section' id='main' name='Main Posts'>
                    <div class='widget Blog' data-version='2' id='Blog1'>
                        <div class='blog-posts hfeed container item-post-wrap'>
                            <div class='blog-post hentry item-post'>
                                <div class='post-item-inner'>
                                    <nav id='breadcrumb'>
                                        <a href="{{ home_url() }}">{{ __('itech::translation.home') }}</a>
                                        <em class='delimiter'></em>
                                        @foreach($post->categories as $category)
                                            <a class='b-label' href="{{ $category->getUrl() }}">{{ $category->name }}</a>
                                            <em class='delimiter'></em>
                                        @endforeach

                                        <span class='current'>{{ $post->title }}</span>
                                    </nav>
                                    <h1 class='post-title'>
                                        {{ $post->title }}
                                    </h1>
                                    <div class='post-meta'>
                                        <span class='post-date published'
                                              datetime='{{ $post->created_at->toIso8601String() }}'
                                        >
                                            {{ $post->created_at->format('F d, Y') }}
                                        </span>
                                    </div>

                                    <div class='post-body post-content' id='post-body'>
                                        <div class="separator">
                                            <a href="" style="margin-left: 1em; margin-right: 1em;">
                                                <img alt="{{ $post->title }}" class="lazy-yard" loading="lazy" src="{{ proxy_image($post->thumbnail) }}" srcset="{{ proxy_image($post->thumbnail, 728) }} 728w, {{ proxy_image($post->thumbnail, 336, 189) }} 336w" sizes="(max-width: 728px) 100vw, 728px">
                                            </a>
                                        </div>
                                        <br>
                                        {!! $post->renderContent() !!}
                                    </div>
                                    <div class='post-labels'>
                                        <div class='label-head Label'>
                                        @foreach($post->tags as $tag)
                                            <a class='label-link' href="{{ $tag->getUrl() }}" rel='tag'>{{ $tag->name }}</a>
                                        @endforeach
                                        </div>
                                    </div>
                                    <div class='post-share'>
                                        <ul class='share-links social social-color'>
                                            <li class='facebook'><a class='facebook' href='https://www.facebook.com/sharer.php?u={{ urlencode(url()->current()) }}' onclick='window.open(this.href, &#39;windowName&#39;, &#39;width=550, height=650, left=24, top=24, scrollbars, resizable&#39;); return false;' rel='nofollow'></a></li>
                                            <li class='x-twitter'><a class='x-twitter' href='https://twitter.com/share?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}' onclick='window.open(this.href, &#39;windowName&#39;, &#39;width=550, height=450, left=24, top=24, scrollbars, resizable&#39;); return false;' rel='nofollow'></a></li>
                                            <li class='pinterest'>
                                                <a class='pinterest' href='https://www.pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&media={{ $post->thumbnail }}&description={{ urlencode($post->title) }}' onclick='window.open(this.href, &#39;windowName&#39;, &#39;width=735, height=750, left=24, top=24, scrollbars, resizable&#39;); return false;' rel='nofollow'></a></li>
                                            <li class='linkedin'><a class='linkedin' href='https://www.linkedin.com/shareArticle?url={{ urlencode(url()->current()) }}' onclick='window.open(this.href, &#39;windowName&#39;, &#39;width=550, height=650, left=24, top=24, scrollbars, resizable&#39;); return false;' rel='nofollow'></a></li>
                                            <li class='whatsapp whatsapp-desktop'><a class='whatsapp' href='https://web.whatsapp.com/send?text={{ urlencode($post->title) }} | {{ urlencode(url()->current()) }}' onclick='window.open(this.href, &#39;windowName&#39;, &#39;width=900, height=550, left=24, top=24, scrollbars, resizable&#39;); return false;' rel='nofollow'></a></li>
                                            <li class='email'><a class='email' href='mailto:?subject={{ urlencode($post->title) }}&body={{ urlencode(url()->current()) }}' onclick='window.open(this.href, &#39;windowName&#39;, &#39;width=500, height=400, left=24, top=24, scrollbars, resizable&#39;); return false;' rel='nofollow'></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class='post-footer'>
                                    <ul class='post-nav'>

                                        <li class='post-next'>
                                            <a rel='next' href="{{ $nextPost?->getUrl() }}">
                                                <div class='post-nav-inner'>
                                                    <span>{{ __('Newer') }}</span>
                                                    <p>{{ $nextPost?->title }}</p>
                                                </div>
                                            </a>
                                        </li>

                                        <li class='post-prev'>
                                            <a class='prev-post-link' href="{{ $prevPost?->getUrl() }}" id='Blog1_blog-pager-older-link' rel='previous'>
                                                <div class='post-nav-inner'>
                                                    <span>{{ __('Older') }}</span>
                                                    <p>{{ $prevPost?->title }}</p>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>

                                    <div id='related-wrap'>
                                        <div class='title-wrap'>
                                            <h3>{{ __('You may like these posts') }}</h3>
                                        </div>
                                        <div class='related-ready'>
                                            <div class='related-tag' data-label='{{ $post->category->first()?->id }}' data-current-id="{{ $post->id }}"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='blog-post-comments'>
                                <div class='title-wrap comments-title'>
                                    <h3>{{ __('itech::translation.post_a_comment') }}</h3>
                                </div>
                                <section class='comments embed' data-num-comments='0' id='comments'>
                                    <h3 class='title'>{{ __('itech::translation.num_comments', ['num' => $post->getTotalComments()]) }}</h3>
                                    <div id='Blog1_comments-block-wrapper'>
                                        @include('itech::blog.components.comment-list', ['comments' => $comments])
                                    </div>
                                    <div class='footer'>
                                        <div class="comment-form">
                                            <h4>{{ __('itech::translation.leave_a_comment') }}</h4>
                                            <form method="post" id="commentForm">
                                                @csrf

                                                @if(auth()->guest())
                                                <div class="form-row">
                                                    <div class="form-group half">
                                                        <label for="name">{{ __('Name') }}</label>
                                                        <input id="name" name="name" type="text" required value="{{ request()->cookie('guest_name') }}">
                                                    </div>

                                                    <div class="form-group half">
                                                        <label for="email">{{ __('Email') }}</label>
                                                        <input id="email" name="email" type="email" required value="{{ request()->cookie('guest_email') }}">
                                                    </div>
                                                </div>
                                                @endif

                                                <div class="form-group">
                                                    <label for="content">{{ __('itech::translation.comment') }}</label>
                                                    <textarea id="content" name="content" rows="4" required></textarea>
                                                </div>

                                                <button type="submit">{{ __('itech::translation.submit') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <script type='text/javascript'>
                            var messages = {
                                showMore: "{{ __('itech::translation.show_more') }}"
                            }
                        </script>
                    </div>
                </div>
            </div>
            <!-- Sidebar Wrapper -->
            @include('itech::components.sidebar')
        </div>
    </div>
@endsection