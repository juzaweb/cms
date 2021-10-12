<div class="widget">
    <h2 class="widget-title">{{ $data['title'] }}</h2>
    <div class="blog-list-widget">
        <div class="list-group">
            @foreach($items as $item)
            <a href="" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="w-100 justify-content-between">
                    <img src="upload/tech_blog_08.jpg" alt="" class="img-fluid float-left">
                    <h5 class="mb-1">5 Beautiful buildings you need..</h5>
                    <small>12 Jan, 2016</small>
                </div>
            </a>
            @endforeach
        </div>
    </div><!-- end blog-list -->
</div><!-- end widget -->