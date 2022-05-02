<?php

namespace Juzaweb\Backend\Observers;

use Juzaweb\Backend\Models\Comment;

class CommentObserver
{
    public function saved(Comment $comment): void
    {
        $this->changeTotalComment($comment);
    }

    protected function changeTotalComment(Comment $comment): void
    {
        $count = Comment::where('object_id', '=', $comment->object_id)->whereApproved()->count();

        $comment->post()->update(
            [
                'total_comment' => $count,
            ]
        );
    }

    public function deleted(Comment $comment): void
    {
        $this->changeTotalComment($comment);
    }
}
