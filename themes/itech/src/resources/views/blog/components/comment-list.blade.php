@foreach($comments as $comment)
<!-- Parent Comment -->
<div class="comment-item">
    <div class="comment-header">
        <span class="comment-author">{{ $comment->name }}</span>
        <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
    </div>
    <div class="comment-body">
        {!! nl2br(e($comment->content)) !!}
    </div>

    @foreach($comment->children as $childComment)
        <!-- Child Comment -->
        <div class="comment-children">
            <div class="comment-item">
                <div class="comment-header">
                    <span class="comment-author">{{ $childComment->name }}</span>
                    <span class="comment-date">{{ $childComment->created_at->diffForHumans() }}</span>
                </div>
                <div class="comment-body">
                    {!! nl2br(e($childComment->content)) !!}
                </div>
            </div>
        </div>
    @endforeach
</div>
@endforeach
