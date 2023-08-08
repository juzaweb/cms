<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Juzaweb\Backend\Models\Post;

class PostResourceController extends ResourceController
{
    public function index(...$params): View
    {
        $type = $params[0];
        $postId = $params[1];

        $post = Post::findOrFail($postId);
        $postType = $this->getPostType($post->type);

        $this->addBreadcrumb(
            [
                'title' => $postType->get('label'),
                'url' => route('admin.posts.index', [$post->type]),
            ]
        );

        $this->addBreadcrumb(
            [
                'title' => $post->title,
                'url' => route('admin.posts.edit', [$post->type, $post->id]),
            ]
        );

        return view(
            "{$this->viewPrefix}.index",
            $this->getDataForIndex($type, $postId)
        );
    }

    public function create(...$params): View
    {
        $this->authorize('create', $this->getModel(...$params));

        $type = $params[0];
        $postId = $params[1];

        $post = Post::findOrFail($postId);
        $postType = $this->getPostType($post->type);

        $this->addBreadcrumb(
            [
                'title' => $postType->get('label'),
                'url' => route('admin.posts.index', [$post->type]),
            ]
        );

        $this->addBreadcrumb(
            [
                'title' => $post->title,
                'url' => route('admin.posts.edit', [$post->type, $post->id]),
            ]
        );

        $indexRoute = str_replace(
            '.create',
            '.index',
            Route::currentRouteName()
        );

        $this->addBreadcrumb(
            [
                'title' => $this->getTitle($type, $postId),
                'url' => route($indexRoute, [$type, $postId]),
            ]
        );

        $model = $this->makeModel($type, $postId);

        return view(
            "{$this->viewPrefix}.form",
            array_merge(
                [
                    'title' => trans('cms::app.add_new'),
                ],
                $this->getDataForForm($model, $type, $postId)
            )
        );
    }

    public function edit(...$params): View
    {
        $type = $params[0];
        $postId = $params[1];
        $id = $params[2];

        $post = Post::find($postId);
        $postType = $this->getPostType($post->type);

        $this->addBreadcrumb(
            [
                'title' => $postType->get('label'),
                'url' => route('admin.posts.index', [$post->type]),
            ]
        );

        $this->addBreadcrumb(
            [
                'title' => $post->title,
                'url' => route('admin.posts.edit', [$post->type, $post->id]),
            ]
        );

        $indexRoute = str_replace(
            '.edit',
            '.index',
            Route::currentRouteName()
        );

        $indexParams = [$type, $postId, $id];
        unset($indexParams[$this->getPathIdIndex($indexParams)]);
        $indexParams = collect($indexParams)->values()->toArray();

        $this->addBreadcrumb(
            [
                'title' => $this->getTitle($type, $postId),
                'url' => route($indexRoute, $indexParams),
            ]
        );

        $model = $this->makeModel(...$indexParams)
            ->findOrFail($this->getPathId([$type, $postId, $id]));
        $this->authorize('update', $model);

        return view(
            $this->viewPrefix . '.form',
            array_merge(
                [
                    'title' => $model->{$model->getFieldName()},
                ],
                $this->getDataForForm($model, $type, $postId)
            )
        );
    }
}
