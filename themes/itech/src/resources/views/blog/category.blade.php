@extends('itech::layouts.main')

@section('title', __('itech::translation.posts_in_name', ['name' => $category->name]))

@section('content')
    <!-- Content Wrapper -->
    <div class='row' id='content-wrapper'>
        <div class='container'>
            <!-- Main Wrapper -->
            <div id='main-wrapper'>
                <div class='main section' id='main' name='Main Posts'>
                    <div class='widget Blog' data-version='2' id='Blog1'>
                        <div class='home-posts-headline title-wrap Label'>
                            <h3 class='title'>{{ __('itech::translation.posts_in_name', ['name' => $category->name]) }}</h3>
                        </div>

                        <div class='clearfix'></div>
                        <div class='blog-posts hfeed container index-post-wrap'>
                            <div class='grid-posts'>
                                @foreach ($posts as $post)
                                    @component('itech::components.post-item', ['post' => $post])

                                    @endcomponent
                                @endforeach
                            </div>
                        </div>

                        <div class='blog-pager container' id='blog-pager'>
                            <a class='blog-pager-older-link load-more'
                               data-load='{{ $posts->hasMorePages() ? route('home.load-more', ['page' => 2]) : '' }}'
                               href='javascript:void(0);' id='load-more-link'>
                                {{ __('itech::translation.load_more') }}
                            </a>
                            <span class='loading'><span class='loader'></span></span>
                            <span class='no-more load-more'>{{ __('itech::translation.that_is_all') }}</span>
                        </div>
                        <script type='text/javascript'>
                            var messages = {
                                showMore: "{{ __('itech::translation.show_more') }}",
                            }
                        </script>
                    </div>
                </div>
            </div>
            <!-- Sidebar Wrapper -->

            @include('itech::components.sidebar')

            <div class='clearfix'></div>
        </div>
    </div>
    <div class='clearfix'></div>
@endsection
