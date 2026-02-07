@extends('itech::layouts.main')

@section('title', $page->title)

@section('content')
    <div class='row' id='content-wrapper'>
        <div class='container'>
            <!-- Main Wrapper -->
            <div id='main-wrapper'>
                <div class='main section' id='main' name='Main Posts'>
                    <div class='widget Blog' data-version='2' id='Blog1'>
                        <div class='blog-posts hfeed container item-post-wrap'>
                            <div class='blog-post hentry item-post'>
                                <div class='post-item-inner'>
                                    <h1 class='post-title'>{{ $page->title }}</h1>
                                    <div class='post-body post-content' id='post-body'>
                                        {!! $page->renderContent() !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script type='text/javascript'>
                            var messages = {
                                showMore: "Show more"
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
@endsection
