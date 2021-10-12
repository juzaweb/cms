<div class="custombox clearfix">
    <h4 class="small-title">{{ $comments->total() }} Comments</h4>
    <div class="row">
        <div class="col-lg-12">
            <div class="comments-list">
                @foreach($comments as $comment)
                    <div class="media">
                        <a class="media-left" href="#">
                            <img src="upload/author.jpg" alt="" class="rounded-circle">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading user_name">{{ $comment->getUserName() }} <small>{{ $comment->getCreatedDate() }}</small></h4>
                            <p>{{ $comment->content }}</p>
                            <a href="#" class="btn btn-primary btn-sm">Reply</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div><!-- end col -->
    </div><!-- end row -->
</div><!-- end custom-box -->


