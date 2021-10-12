@extends('juzaweb::layouts.frontend')

@section('content')
    @php
        $tags = $post->getTaxonomies('tags', 5);
        $categories = $post->getTaxonomies('categories', 1);
        $related = $post->getRelatedPosts(2, 'categories');
    @endphp

    <section class="section single-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-wrapper">
                        <div class="blog-title-area text-center">
                            <ol class="breadcrumb hidden-xs-down">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active">{{ $post->getTitle() }}</li>
                            </ol>

                            @foreach($categories as $category)
                            <span class="color-orange"><a href="{{ $category->getLink() }}" title="">{{ $category->getName() }}</a></span>
                            @endforeach

                            <h3>{{ $post->getTitle() }}</h3>

                            <div class="blog-meta big-meta">
                                <small>
                                    <a href="" title="">{{ $post->getCreatedDate() }}</a>
                                </small>

                                <small>
                                    <a href="" title="">by {{ $post->getCreatedByName() }}</a>
                                </small>

                                <small>
                                    <a href="" title=""><i class="fa fa-eye"></i> {{ $post->views }}</a>
                                </small>

                            </div><!-- end meta -->

                            <div class="post-sharing">
                                <ul class="list-inline">
                                    <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i>
                                            <span class="down-mobile">Share on Facebook</span></a>
                                    </li>

                                    <li>
                                        <a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i>
                                            <span class="down-mobile">Tweet on Twitter</span></a>
                                    </li>
                                    <li>
                                        <a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i></a>
                                    </li>
                                </ul>
                            </div><!-- end post-sharing -->
                        </div><!-- end title -->

                        <div class="single-post-media">
                            <img src="upload/tech_menu_08.jpg" alt="" class="img-fluid">
                        </div><!-- end media -->

                        <div class="blog-content">
                            {!! $post->getContent() !!}
                        </div><!-- end content -->

                        <div class="blog-title-area">
                            <div class="tag-cloud-single">
                                @if($tags->isNotEmpty())
                                    <span>Tags</span>
                                @endif

                                @foreach($tags as $tag)
                                <small><a href="#" title="">{{ $tag->getName() }}</a></small>
                                @endforeach
                            </div><!-- end meta -->

                            <div class="post-sharing">
                                <ul class="list-inline">
                                    <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="down-mobile">Share on Facebook</span></a></li>
                                    <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="down-mobile">Tweet on Twitter</span></a></li>
                                    <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div><!-- end post-sharing -->
                        </div><!-- end title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="banner-spot clearfix">
                                    <div class="banner-img">
                                        <img src="upload/banner_01.jpg" alt="" class="img-fluid">
                                    </div><!-- end banner-img -->
                                </div><!-- end banner -->
                            </div><!-- end col -->
                        </div><!-- end row -->

                        <hr class="invis1">

                        <div class="custombox prevnextpost clearfix">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="blog-list-widget">
                                        <div class="list-group">
                                            <a href="tech-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="w-100 justify-content-between text-right">
                                                    <img src="upload/tech_menu_19.jpg" alt="" class="img-fluid float-right">
                                                    <h5 class="mb-1">5 Beautiful buildings you need to before dying</h5>
                                                    <small>Prev Post</small>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div><!-- end col -->

                                <div class="col-lg-6">
                                    <div class="blog-list-widget">
                                        <div class="list-group">
                                            <a href="tech-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="w-100 justify-content-between">
                                                    <img src="upload/tech_menu_20.jpg" alt="" class="img-fluid float-left">
                                                    <h5 class="mb-1">Let's make an introduction to the glorious world of history</h5>
                                                    <small>Next Post</small>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div><!-- end col -->
                            </div><!-- end row -->
                        </div><!-- end author-box -->

                        <hr class="invis1">

                        <div class="custombox authorbox clearfix">
                            <h4 class="small-title">About author</h4>
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <img src="upload/author.jpg" alt="" class="img-fluid rounded-circle">
                                </div><!-- end col -->

                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                    <h4><a href="#">Jessica</a></h4>
                                    <p>Quisque sed tristique felis. Lorem <a href="#">visit my website</a> amet, consectetur adipiscing elit. Phasellus quis mi auctor, tincidunt nisl eget, finibus odio. Duis tempus elit quis risus congue feugiat. Thanks for stop Tech Blog!</p>

                                    <div class="topsocial">
                                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="Facebook"><i class="fa fa-facebook"></i></a>
                                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="Youtube"><i class="fa fa-youtube"></i></a>
                                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="Pinterest"><i class="fa fa-pinterest"></i></a>
                                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="Twitter"><i class="fa fa-twitter"></i></a>
                                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="Instagram"><i class="fa fa-instagram"></i></a>
                                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="Website"><i class="fa fa-link"></i></a>
                                    </div><!-- end social -->

                                </div><!-- end col -->
                            </div><!-- end row -->
                        </div><!-- end author-box -->

                        @if($related->isNotEmpty())
                        <hr class="invis1">

                        <div class="custombox clearfix">
                            <h4 class="small-title">You may also like</h4>
                            <div class="row">
                            @foreach($related as $item)
                                <div class="col-lg-6">
                                    <div class="blog-box">
                                        <div class="post-media">
                                            <a href="{{ $item->getLink() }}" title="">
                                                <img src="{{ $item->getThumbnail() }}" alt="" class="img-fluid">
                                                <div class="hovereffect">
                                                    <span class=""></span>
                                                </div><!-- end hover -->
                                            </a>
                                        </div><!-- end media -->
                                        <div class="blog-meta">
                                            <h4>
                                                <a href="{{ $item->getLink() }}" title="">{{ $item->getTitle() }}</a>
                                            </h4>

                                            <small><a href="" title="">Trends</a></small>
                                            <small><a href="" title="">{{ $item->getCreatedDate() }}</a></small>
                                        </div>
                                        <!-- end meta -->
                                    </div><!-- end blog-box -->
                                </div><!-- end col -->
                            @endforeach
                            </div><!-- end row -->
                        </div><!-- end custom-box -->
                        @endif

                        <hr class="invis1">

                        {{ comment_template($post, 'theme::components.comments') }}


                        <hr class="invis1">

                        <div class="custombox clearfix">
                            <h4 class="small-title">Leave a Reply</h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form action="" class="form-wrapper" method="post">
                                        @csrf

                                        <input type="text" name="name" class="form-control" placeholder="Your name">
                                        <input type="text" name="email" class="form-control" placeholder="Email address">
                                        <input type="text" name="website" class="form-control" placeholder="Website">
                                        <textarea class="form-control" name="content" placeholder="Your comment"></textarea>
                                        <button type="submit" class="btn btn-primary">Submit Comment</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- end page-wrapper -->
                </div><!-- end col -->

                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                    <div class="sidebar">
                        {!! dynamic_sidebar('sidebar') !!}
                    </div><!-- end sidebar -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </section>

@endsection