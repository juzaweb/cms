<div class="col-md-6">
    <div class="blog-box">
        <div class="post-media">
            <a href="{{ $post->getLink() }}" title="{{ $post->getTitle() }}">
                <img src="{{ $post->getThumbnail() }}" alt="{{ $post->getTitle() }}" class="img-fluid">
                <div class="hovereffect">
                    <span></span>
                </div><!-- end hover -->
            </a>
        </div><!-- end media -->
        <div class="blog-meta big-meta">
            <span class="color-orange"><a href="" title="">Gadgets</a></span>
            <h4><a title="{{ $post->getTitle() }}" href="{{ $post->getLink() }}">{{ $post->getTitle() }}</a></h4>
            <p>{{ $post->getDescription() }}</p>
            <small><a href="" title="">14 July, 2017</a></small>
            <small><a href="" title="">by Jack</a></small>
            <small><a href="" title=""><i class="fa fa-eye"></i> 2887</a></small>
        </div><!-- end meta -->
    </div><!-- end blog-box -->
</div><!-- end col -->
