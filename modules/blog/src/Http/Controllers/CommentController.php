<?php

namespace Juzaweb\Modules\Blog\Http\Controllers;

use Juzaweb\Modules\Blog\Models\Post;
use Juzaweb\Modules\Core\Http\Controllers\Admin\CommentController as CoreCommentController;
use Juzaweb\Modules\Core\Models\Comment;

class CommentController extends CoreCommentController
{
    protected string $commentableType = Post::class;

    public function destroy($id)
    {
        $model = Comment::where('id', $id)
            ->where('commentable_type', $this->commentableType)
            ->firstOrFail();

        $model->delete();

        return $this->success([
            'message' => trans('core::app.deleted_successfully'),
        ]);
    }
}
