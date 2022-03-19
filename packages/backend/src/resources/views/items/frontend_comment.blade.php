<div class="comments-list">
    @foreach($comments as $comment)
    <div class="media">
        <a class="media-left" href="#">
            <img src="upload/author.jpg" alt="" class="rounded-circle">
        </a>
        <div class="media-body">
            <h4 class="media-heading user_name">{{ $comment->user->name }} <small>5 days ago</small></h4>
            <p>{{ $comment->content }}</p>
            <a href="#" class="btn btn-primary btn-sm">Reply</a>
        </div>
    </div>
    @endforeach
</div>
