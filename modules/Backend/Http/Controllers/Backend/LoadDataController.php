<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Juzaweb\Backend\Models\Menu;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Resource;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Support\ArrayPagination;

class LoadDataController extends BackendController
{
    public function loadData($func, Request $request): \Illuminate\Http\JsonResponse
    {
        if (method_exists($this, $func)) {
            return $this->{$func}($request);
        }

        return response()->json(
            [
                'status' => 'error',
                'message' => 'Function not found',
            ]
        );
    }

    protected function generateSlug(Request $request): \Illuminate\Http\JsonResponse
    {
        $title = Str::words($request->input('title'), 15);

        return response()->json(
            [
                'status' => true,
                'slug' => Str::slug(seo_string($title, 70)),
            ]
        );
    }

    protected function loadTaxonomies(Request $request)
    {
        $search = $request->get('search');
        $explodes = $request->get('explodes');
        $postType = $request->get('post_type');
        $taxonomy = $request->get('taxonomy');

        $query = Taxonomy::query();
        $query->select(
            [
                'id',
                'name as text',
            ]
        );

        if ($postType) {
            $query->where('post_type', '=', $postType);
        }

        if ($taxonomy) {
            $query->where('taxonomy', '=', $taxonomy);
        }

        if ($search) {
            $query->where('name', JW_SQL_LIKE, '%'. $search .'%');
        }

        if ($explodes) {
            $query->whereNotIn('id', $explodes);
        }

        $paginate = $query->paginate(10);
        $data['results'] = $query->get();

        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }

        return response()->json($data);
    }

    protected function loadUsers(Request $request)
    {
        $search = $request->get('search');
        $explodes = $request->get('explodes');

        $query = User::query();
        $query->select(
            [
                'id',
                'name AS text',
            ]
        );

        if ($search) {
            $query->where(
                function (Builder $q) use ($search) {
                    $q->where('name', JW_SQL_LIKE, '%'. $search .'%');
                    $q->orWhere('email', JW_SQL_LIKE, '%'. $search .'%');
                }
            );
        }

        if ($explodes) {
            $query->whereNotIn('id', $explodes);
        }

        $paginate = $query->paginate(10);
        $data['results'] = $query->get();
        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }

        return response()->json($data);
    }

    protected function loadMenu(Request $request)
    {
        $search = $request->get('search');
        $explodes = $request->get('explodes');

        $query = Menu::query();
        $query->select(
            [
                'id',
                'name AS text',
            ]
        );

        if ($search) {
            $query->where(
                function (Builder $q) use ($search) {
                    $q->orWhere('name', JW_SQL_LIKE, '%'. $search .'%');
                }
            );
        }

        if ($explodes) {
            $query->whereNotIn('id', $explodes);
        }

        $paginate = $query->paginate(10);
        $data['results'] = $query->get();
        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }

        return response()->json($data);
    }

    protected function loadLocales(Request $request)
    {
        $search = strtolower($request->get('search', ''));

        $results = collect(config('locales'));

        if ($search) {
            $results = $results->filter(
                function ($item) use ($search) {
                    return strpos(strtolower($item['code']), $search) !== false ||
                        strpos(strtolower($item['name']), $search) !== false;
                }
            );
        }

        $results = $results->map(
            function ($item) {
                return [
                    'id' => $item['code'],
                    'text' => $item['name'],
                ];
            }
        )->values();

        $paginate = ArrayPagination::make($results);
        $paginate = $paginate->paginate(10);

        $data['results'] = $paginate->values();

        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }

        return response()->json($data);
    }

    protected function loadPages(Request $request)
    {
        $search = $request->get('search');
        $explodes = $request->get('explodes');

        $query = Post::where('type', '=', 'pages');
        $query->select(
            [
                'id',
                'title as text',
            ]
        );

        if ($search) {
            $query->where('title', JW_SQL_LIKE, '%'. $search .'%');
        }

        if ($explodes) {
            $query->whereNotIn('id', $explodes);
        }

        $paginate = $query->paginate(10);
        $data['results'] = $query->get();

        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }

        return response()->json($data);
    }

    protected function loadPosts(Request $request)
    {
        $type = $request->get('type');
        $search = $request->get('search');
        $explodes = $request->get('explodes');

        $query = Post::query();

        $query->select(
            [
                'id',
                'title as text',
            ]
        );

        if ($type) {
            $query->where('type', '=', $type);
        }

        if ($search) {
            $query->where('title', JW_SQL_LIKE, '%'. $search .'%');
        }

        if ($explodes) {
            $query->whereNotIn('id', $explodes);
        }

        $paginate = $query->paginate(10);

        $data['results'] = $query->get();

        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }

        return response()->json($data);
    }

    protected function loadPostType(Request $request)
    {
        $search = $request->get('search');
        $postType = $request->get('post_type');
        $perPage = $request->get('per_page', 10);
        if ($perPage > 100) {
            $perPage = 10;
        }

        $postType = HookAction::getPostTypes($postType);

        /**
         * @var Builder $query
         */
        $query = app($postType->get('model'))->query();
        $query->select(
            [
                'id',
                'title as text',
            ]
        );

        if ($search) {
            $query->where('title', JW_SQL_LIKE, '%'. $search .'%');
        }

        $paginate = $query->paginate($perPage);
        $data['results'] = $query->get();

        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }

        return response()->json($data);
    }

    protected function loadResource(Request $request)
    {
        $search = $request->get('search');
        $type = $request->get('type');
        $perPage = $request->get('per_page', 10);

        if ($perPage > 100) {
            $perPage = 10;
        }

        /**
         * @var Builder $query
         */
        $query = Resource::query();
        $query->select(
            [
                'id',
                'name as text',
            ]
        );

        $query->where('type', '=', $type);

        if ($search) {
            $query->where('name', JW_SQL_LIKE, '%'. $search .'%');
        }

        $paginate = $query->paginate($perPage);
        $data['results'] = $query->get();

        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }

        return response()->json($data);
    }

    protected function loadSubscriptionObjects(Request $request)
    {
        $search = $request->get('search');
        $module = $request->get('module');
        $perPage = $request->get('per_page', 10);

        if ($perPage > 100) {
            $perPage = 10;
        }

        $module = HookAction::getPackageModules($module);

        /**
         * @var Builder $query
         */
        $query = $module->get('model')::query();
        $query->select(
            [
                'id',
                'name as text',
            ]
        );

        if ($search) {
            $query->where('name', JW_SQL_LIKE, '%'. $search .'%');
        }

        $paginate = $query->paginate($perPage);
        $data['results'] = $query->get();

        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }

        return response()->json($data);
    }

    protected function loadThemeTemplate(Request $request)
    {
        $templates = HookAction::getThemeTemplates()->map(
            function ($item) {
                return [
                    'id' => $item->get('key'),
                    'text' => __($item->get('label')),
                ];
            }
        )
            ->values()
            ->toArray();

        $data['results'] = $templates;
        return response()->json($data);
    }
}
