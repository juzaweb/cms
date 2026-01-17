<div class="media mb-4">
    <div class="media-body">
        <div class="d-flex">
            <h6 class="mt-0 mb-0">{{ $comment->name ?? '{user}' }}</h6>
            <small class="text-muted ml-2">{{ isset($comment) ? $comment->created_at->diffForHumans() : '{time}' }}</small>
        </div>
        <p class="mb-1 mt-1">{!! nl2br(e($comment->content ?? '{content}')) !!}</p>
    </div>
</div>
