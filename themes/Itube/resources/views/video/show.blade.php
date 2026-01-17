@extends('itube::layouts.main')

@section('title', $video->title)

@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mediaelement@7.0.5/build/mediaelementplayer.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mediaelement-plugins@5.0.0/dist/ads/ads.css">

    <style>
        #video-container .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #video-container .centered-loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
@endsection

@section('content')
    <div class="container px-md-5">
        <div class="row mt-3 mb-4">
            <div class="col-md-8 col-xl-9 mb-4">
                <div id="video-container"
                    class="position-relative min-h-270rem mb-2d mr-xl-3 text-center d-flex align-items-center justify-content-center player">
                    <div class="centered-loader loader"></div>
                </div>
                <div class="mr-xl-3">
                    <div class="mb-2">
                        <h5 class="font-size-21 text-dark font-weight-medium">
                            {{ $video->title }}
                        </h5>
                    </div>

                    <div class="font-size-12 mb-4">
                        <span class="d-inline-flex text-gray-1300 align-items-center mr-3">
                            {{ __('Published on') }} {{ $video->created_at->format('F j, Y') }}
                        </span>
                        <span class="d-inline-flex text-gray-1300 align-items-center mr-3"><i class="far fa-eye mr-1d"></i>
                            {{ number_human_format($video->views) }} {{ __('views') }}</span>
                    </div>

                    <div class="bg-gray-1000 rounded d-flex py-2d px-3 align-items-center mb-4">
                        @auth('member')
                            @php
                                $userReaction = $video->getUserReaction(auth('member')->user());
                                $hasLiked = $userReaction && $userReaction->type === 'like';
                                $hasDisliked = $userReaction && $userReaction->type === 'dislike';
                            @endphp
                            <div class="d-flex align-items-center text-gray-1300 font-size-12">
                                <button type="button"
                                    class="btn btn-link text-decoration-none reaction-btn {{ $hasLiked ? 'text-primary' : 'text-gray-1300' }}"
                                    data-type="like">
                                    <i class="{{ $hasLiked ? 'fas' : 'far' }} fa-thumbs-up mr-1d font-size-18"></i>
                                </button>
                                <span id="likes-count" class="mr-3">{{ number_human_format($video->likes_count) }}</span>

                                <button type="button"
                                    class="btn btn-link text-decoration-none reaction-btn {{ $hasDisliked ? 'text-danger' : 'text-gray-1300' }}"
                                    data-type="dislike">
                                    <i class="{{ $hasDisliked ? 'fas' : 'far' }} fa-thumbs-down mr-1d font-size-18"></i>
                                </button>
                                <span id="dislikes-count">{{ number_human_format($video->dislikes_count) }}</span>
                            </div>
                        @else
                            <div class="d-flex align-items-center text-gray-1300 font-size-12">
                                <a href="{{ route('login') }}" class="text-decoration-none text-gray-1300">
                                    <i class="far fa-thumbs-up mr-1d font-size-18"></i>
                                    <span class="mr-3">{{ number_human_format($video->likes_count) }}</span>
                                </a>
                                <a href="{{ route('login') }}" class="text-decoration-none text-gray-1300">
                                    <i class="far fa-thumbs-down mr-1d font-size-18"></i>
                                    <span>{{ number_human_format($video->dislikes_count) }}</span>
                                </a>
                            </div>
                        @endauth
                    </div>

                    <div class="collapse" id="collapse-description">
                        <div class="card card-body shadow-none p-0 mb-2">
                            {!! nl2br($video->description) !!}
                        </div>
                    </div>

                    @if ($video->description)
                        <div>
                            <a class="show-more-arrow font-size-14" data-toggle="collapse" href="#collapse-description"
                                role="button" aria-expanded="false" aria-controls="collapse-description">
                                {{ __('itube::translation.show_more') }} <i
                                    class="ml-1d fas fa-chevron-down font-size-10"></i>
                            </a>
                        </div>
                    @endif

                    <nav class="js-scroll-nav">
                        <div class="space-1 position-relative d-flex">
                            <div class="border-top content-centered w-100 border-gray-3600"></div>
                        </div>
                    </nav>

                    <div class="space-1">
                        <form action="{{ route('video.comment', [$video->code]) }}" method="post" id="commentform"
                            class="comment-form mb-6 form-ajax" data-success="commentSuccessHandle">
                            <div class="form-group">
                                <div class="row align-items-start">
                                    <div class="col-md-12 d-flex">
                                        <textarea name="content" class="form-control mr-2" rows="2"
                                            placeholder="{{ __('itube::translation.your_comment') }}"></textarea>
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-paper-plane"></i> {{ __('itube::translation.post') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="d-flex align-items-center mb-3">
                            <h5 class="text-gray-700 font-size-18 font-weight-medium mb-0">
                                @lang('Comments')
                            </h5>
                            <span class="ml-auto text-gray-1300 font-size-12">{{ $video->comments_count }}
                                @lang('Comments')</span>
                        </div>

                        <div id="comments">
                            @forelse($video->comments as $comment)
                                @component('itube::components.comment-item', ['comment' => $comment])
                                @endcomponent
                            @empty
                                <p class="text-muted small no-comments-text">@lang('There are no comments yet.')</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">

                @if ($ad = ads_position('sidebar-video'))
                    <div class="d-block mb-3d">
                        {!! $ad !!}
                    </div>
                @endif

                <div class="mb-4" id="next-videos-container">
                    <h5 class="text-gray-700 font-size-18 font-weight-medium">
                        @lang('Up Next')
                    </h5>

                    @foreach ($nextVideos as $nextVideo)
                        @component('itube::components.video-sidebar-item', ['video' => $nextVideo])
                        @endcomponent
                    @endforeach
                </div>

                <div class="text-center py-3" id="loading-spinner" style="display:none;">
                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/mediaelement@7.0.5/build/mediaelement-and-player.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mediaelement-plugins@5.0.0/dist/ads/ads.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mediaelement-plugins@5.0.0/dist/ads-vast-vpaid/ads-vast-vpaid.min.js">
    </script>

    <script type="text/html" id="comment-template">
        @component('itube::components.comment-item')
        @endcomponent
    </script>

    <script>
        function commentSuccessHandle(form, res) {
            let comment = document.getElementById('comment-template').innerHTML;

            comment = comment.replace('{user}', res.comment.commented.name);

            comment = comment.replace('{time}', res.comment.created_time);

            comment = comment.replace('{content}', res.comment.content);

            $('#comments').prepend(comment);

            form.find('textarea[name="content"]').val('');

            $('.no-comments-text').remove();
        }

        $(function() {
            $.ajax({
                url: '{{ route('video.player', ['code' => $video->code]) }}',
                type: 'POST',
                success: function(res) {
                    $('#video-container').html(res.html);
                },
                error: function() {
                    $('#video-container').html('<div class="text-danger">Video not available.</div>');
                }
            });

            let page = 2;
            let isLoading = false;
            let hasMore = true;

            window.addEventListener('scroll', function() {
                if (isLoading || !hasMore) return;

                if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 200) {
                    loadMoreVideos();
                }
            });

            function loadMoreVideos() {
                isLoading = true;
                document.getElementById('loading-spinner').style.display = 'block';

                if (page > 5) {
                    hasMore = false;
                    isLoading = false;
                    document.getElementById('loading-spinner').style.display = 'none';
                    return;
                }

                fetch(`{{ route('video.next', [$video->slug]) }}?page=${page}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.html.trim() === '') {
                            hasMore = false;
                        } else {
                            document.querySelector('#next-videos-container').insertAdjacentHTML('beforeend',
                                data.html);
                            page++;

                            lazyload();
                        }
                    })
                    .finally(() => {
                        isLoading = false;
                        document.getElementById('loading-spinner').style.display = 'none';
                    });
            }

            {{-- let playlistLoaded = false;

            $('#playlistDropdown').on('click', function () {
                const dropdown = $('#basicDropdownClick-1');

                if (playlistLoaded) {
                    return;
                }

                dropdown.html('<div class="dropdown-item disabled">Loading...</div>');

                $.ajax({
                    url: '{{ route('video.playlists.json', [$video->slug]) }}',
                    method: 'GET',
                    success: function (response) {
                        dropdown.empty();

                        if (response.data.length === 0) {
                            dropdown.append('<div class="dropdown-item disabled">No playlists found</div>');
                        } else {
                            response.data.forEach(function (playlist) {
                                dropdown.append(`
                                    <a class="dropdown-item" href="/playlists/${playlist.id}">
                                        ${playlist.name}
                                    </a>
                                `);
                            });
                        }

                        dropdown.append(`
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-primary" href="/playlists/create">
                                + Create a new playlist
                            </a>
                        `);

                        playlistLoaded = true;
                    },
                    error: function () {
                        dropdown.html('<div class="dropdown-item text-danger">Error loading playlists</div>');
                    }
                });
            }); --}}

            // Handle like/dislike reactions
            $('.reaction-btn').on('click', function(e) {
                e.preventDefault();
                const btn = $(this);
                const type = btn.data('type');

                $.ajax({
                    url: '{{ route('video.reaction', ['code' => $video->code]) }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        type: type
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update counts
                            $('#likes-count').text(numberHumanFormat(response.likes_count));
                            $('#dislikes-count').text(numberHumanFormat(response
                                .dislikes_count));

                            // Update button states
                            $('.reaction-btn[data-type="like"]').removeClass('text-primary');
                            $('.reaction-btn[data-type="like"] i').removeClass('fas').addClass(
                                'far');
                            $('.reaction-btn[data-type="dislike"]').removeClass('text-danger');
                            $('.reaction-btn[data-type="dislike"] i').removeClass('fas')
                                .addClass('far');

                            if (response.user_reaction === 'like') {
                                $('.reaction-btn[data-type="like"]').addClass('text-primary');
                                $('.reaction-btn[data-type="like"] i').removeClass('far')
                                    .addClass('fas');
                            } else if (response.user_reaction === 'dislike') {
                                $('.reaction-btn[data-type="dislike"]').addClass('text-danger');
                                $('.reaction-btn[data-type="dislike"] i').removeClass('far')
                                    .addClass('fas');
                            }
                        }
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON?.message || 'An error occurred');
                    }
                });
            });

            function numberHumanFormat(num) {
                if (num >= 1000000) {
                    return (num / 1000000).toFixed(1) + 'M';
                }
                if (num >= 1000) {
                    return (num / 1000).toFixed(1) + 'K';
                }
                return num.toString();
            }
        });
    </script>
@endsection
