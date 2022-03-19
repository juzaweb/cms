<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Support\Facades\Route;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Backend\Models\Post;

class ChildResourceController extends ResourceController
{
    public function index(...$params)
    {
        $type = $params[0];
        $postId = $params[1];
        $parentId = $params[2];

        $post = Post::findOrFail($postId);
        $postType = $this->getPostType($post->type);
        $parentResource = HookAction::getResource(
            $this->getSetting(
                $type,
                $postId,
                $parentId
            )->get('parent')
        );

        $this->addBreadcrumb([
            'title' => $postType->get('label'),
            'url' => route('admin.posts.index', [$post->type]),
        ]);

        $this->addBreadcrumb([
            'title' => $parentResource->get('label'),
            'url' => route(
                'admin.post_resource.index',
                [
                    $parentResource->get('key'),
                    $postId
                ]
            ),
        ]);

        return view(
            $this->viewPrefix . '.index',
            $this->getDataForIndex($type, $postId, $parentId)
        );
    }

    public function create(...$params)
    {
        $this->authorize('create', $this->getModel(...$params));

        $type = $params[0];
        $postId = $params[1];
        $parentId = $params[2];

        $post = Post::find($postId);
        $postType = $this->getPostType($post->type);
        $setting = $this->getSetting(
            $type,
            $postId,
            $parentId
        );
        $parentResource = HookAction::getResource(
            $setting->get('parent')
        );

        $this->addBreadcrumb([
            'title' => $postType->get('label'),
            'url' => route('admin.posts.index', [$post->type]),
        ]);

        $this->addBreadcrumb([
            'title' => $parentResource->get('label'),
            'url' => route(
                'admin.post_resource.index',
                [
                    $parentResource->get('key'),
                    $postId
                ]
            ),
        ]);

        $indexRoute = str_replace(
            '.create',
            '.index',
            Route::currentRouteName()
        );

        $this->addBreadcrumb([
            'title' => $this->getTitle($type, $postId, $parentId),
            'url' => route($indexRoute, [$type, $postId, $parentId]),
        ]);

        $model = $this->makeModel($type, $postId, $parentId);

        return view($this->viewPrefix . '.form', array_merge([
            'title' => trans('cms::app.add_new'),
        ], $this->getDataForForm($model, ...$params)));
    }

    public function edit(...$params)
    {
        $type = $params[0];
        $postId = $params[1];
        $parentId = $params[2];
        $id = $params[3];

        $post = Post::find($postId);
        $postType = $this->getPostType($post->type);
        $setting = $this->getSetting(
            $type,
            $postId,
            $parentId
        );

        $parentResource = HookAction::getResource(
            $setting->get('parent')
        );

        $this->addBreadcrumb([
            'title' => $postType->get('label'),
            'url' => route('admin.posts.index', [$post->type]),
        ]);

        $this->addBreadcrumb([
            'title' => $parentResource->get('label'),
            'url' => route(
                'admin.post_resource.index',
                [
                    $parentResource->get('key'),
                    $postId
                ]
            ),
        ]);

        $indexRoute = str_replace(
            '.edit',
            '.index',
            Route::currentRouteName()
        );

        $indexParams = [$type, $postId, $parentId, $id];
        unset($indexParams[$this->getPathIdIndex($indexParams)]);
        $indexParams = collect($indexParams)->values()->toArray();

        $this->addBreadcrumb([
            'title' => $this->getTitle($type, $postId, $parentId),
            'url' => route($indexRoute, $indexParams),
        ]);

        $model = $this->makeModel(...$indexParams)
            ->findOrFail($id);

        $this->authorize('update', $model);

        return view($this->viewPrefix . '.form', array_merge([
            'title' => $model->{$model->getFieldName()}
        ], $this->getDataForForm($model, ...$params)));
    }
}
