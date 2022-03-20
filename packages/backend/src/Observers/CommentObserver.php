<?php

namespace Juzaweb\Backend\Observers;

use Juzaweb\Backend\Models\Comment;

class CommentObserver
{
    public function saved(Comment $comment)
    {
        $this->changeTotalCommand($comment);
    }

    protected function changeTotalCommand(Comment $comment)
    {
        $count = Comment::where('object_id', '=', $comment->object_id)->whereApproved()->count();

        $comment->post()->update(
            [
                'total_comment' => $count,
            ]
        );
    }

    public function deleted(Comment $comment)
    {
        $this->changeTotalCommand($comment);
    }
}
