<?php

namespace Juzaweb\Modules\Blog\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Juzaweb\Modules\Blog\Models\Category;
use Juzaweb\Modules\Blog\Models\Post;
use Juzaweb\Modules\Core\Facades\Breadcrumb;
use Juzaweb\Modules\Core\Http\Controllers\AdminController;
use Juzaweb\Modules\Core\Http\DataTables\PostsDataTable;
use Juzaweb\Modules\Core\Http\Requests\BulkActionsRequest;
use Juzaweb\Modules\Core\Http\Requests\PostRequest;

class PostController extends AdminController
{
    public function index(PostsDataTable $dataTable)
    {
        Breadcrumb::add(__('core::translation.blog'));

        return $dataTable->render(
            'core::admin.post.index',
            [
                'translateModel' => Post::class,
            ]
        );
    }

    public function create()
    {
        Breadcrumb::add(__('core::translation.blog'), action([self::class, 'index']));

        Breadcrumb::add(__('core::translation.create_new_post'));

        $locale = $this->getFormLanguage();
        $categories = Category::withTranslation()
            ->with('children')
            ->whereNull('parent_id')
            ->get();

        return view(
            'core::admin.post.form',
            [
                'model' => new Post(),
                'action' => action([self::class, 'store']),
                'locale' => $locale,
                'categories' => $categories,
            ]
        );
    }

    public function edit(string $id)
    {
        $locale = $this->getFormLanguage();
        $model = Post::findOrFail($id);
        $model->setDefaultLocale($locale);

        Breadcrumb::add(__('core::translation.blog'), action([self::class, 'index']));

        Breadcrumb::add(__('core::translation.edit_post_name', ['name' => $model->title]));

        $categories = Category::withTranslation()
            ->with('children')
            ->whereNull('parent_id')
            ->get();

        return view(
            'core::admin.post.form',
            [
                'model' => $model,
                'action' => action([self::class, 'update'], [$id]),
                'locale' => $locale,
                'categories' => $categories,
            ]
        );
    }

    public function store(PostRequest $request)
    {
        $locale = $this->getFormLanguage();

        DB::transaction(
            function () use ($request, $locale) {
                $data = $request->validated();
                $post = new Post($data);
                $post->setDefaultLocale($locale);
                $post->save();

                $post->categories()->sync($request->input('categories', []));
                $post->syncTags($request->input('tags', []));

                $post->setThumbnail($request->input('thumbnail'));

                return $post;
            }
        );

        return $this->success(
            [
                'message' => __('core::translation.post_created_successfully'),
                'redirect' => action([self::class, 'index']),
            ]
        );
    }

    public function update(PostRequest $request, string $id)
    {
        $post = Post::findOrFail($id);
        $locale = $this->getFormLanguage();
        $post->setDefaultLocale($locale);
        $tags = $request->input('tags', []);

        DB::transaction(
            function () use ($post, $request, $tags) {
                $post->update($request->validated());
                $post->categories()->sync($request->input('categories', []));

                $post->setThumbnail($request->input('thumbnail'));

                $post->syncTags($tags);

                if (! $post->wasChanged()) {
                    $post->touch();
                }

                return $post;
            }
        );

        return $this->success(
            [
                'message' => __('core::translation.post_updated_successfully'),
                'redirect' => action([self::class, 'index']),
            ]
        );
    }

    public function bulk(BulkActionsRequest $request): JsonResponse|RedirectResponse
    {
        $action = $request->input('action');
        $ids = $request->input('ids', []);

        switch ($action) {
            case 'delete':
                Post::whereIn('id', $ids)
                    ->get()
                    ->each
                    ->delete();
                return $this->success(__('core::translation.deleted_successfully'));
            default:
                return $this->error(__('core::translation.invalid_action'));
        }
    }
}
