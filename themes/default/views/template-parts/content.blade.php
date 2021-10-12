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
            <small><a href="" title="">{{ $post->getCreatedDate() }}</a></small>
            <small><a href="" title="">by {{ $post->getCreatedByName() }}</a></small>
            <small><a href="" title=""><i class="fa fa-eye"></i> {{ $post->getViews() }}</a></small>
        </div>
    </div>
</div>
