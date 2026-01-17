<?php

namespace Juzaweb\Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Juzaweb\Modules\Blog\Models\Category;
use Juzaweb\Modules\Core\Facades\Breadcrumb;
use Juzaweb\Modules\Core\Http\Controllers\AdminController;
use Juzaweb\Modules\Core\Http\DataTables\CategoriesDataTable;
use Juzaweb\Modules\Core\Http\Requests\CategoryRequest;

class CategoryController extends AdminController
{
    public function index(CategoriesDataTable $dataTable)
    {
        Breadcrumb::add(__('core::translation.categories'));

        return $dataTable->render('core::admin.category.index');
    }

    public function create()
    {
        Breadcrumb::add(__('core::translation.categories'), action([self::class, 'index']));

        Breadcrumb::add(__('core::translation.create_new_category'));

        $categories = Category::withTranslation()
            ->with(['children'])
            ->whereNull('parent_id')
            ->get();
        $locale = $this->getFormLanguage();

        $parentCategories = [];
        $this->mapCategories($categories, $parentCategories);

        return view(
            'core::admin.category.form',
            [
                'model' => new Category(),
                'action' => action([self::class, 'store']),
                'parentCategories' => $parentCategories,
                'locale' => $locale,
            ]
        );
    }

    public function edit(string $id)
    {
        $locale = $this->getFormLanguage();
        $model = Category::findOrFail($id);
        $model->setDefaultLocale($locale);

        Breadcrumb::add(__('core::translation.categories'), action([self::class, 'index']));

        Breadcrumb::add(__('core::translation.edit_category_name', ['name' => $model->name]));

        $categories = Category::withTranslation()
            ->with(['children'])
            ->whereNull('parent_id')
            ->where('id', '!=', $id)
            ->get();

        $parentCategories = [];
        $this->mapCategories($categories, $parentCategories, '', $id);

        return view(
            'core::admin.category.form',
            [
                'model' => $model,
                'action' => action([self::class, 'update'], [$id]),
                'parentCategories' => $parentCategories,
                'locale' => $locale,
            ]
        );
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $locale = $this->getFormLanguage();

        $category = DB::transaction(function () use ($data, $locale) {
            $model = new Category($data);
            $model->setDefaultLocale($locale);
            $model->save();
            return $model;
        });

        return $this->success(
            [
                'message' => __('core::translation.category_created_successfully'),
                // 'redirect' => action([self::class, 'index']),
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                ],
            ]
        );
    }

    public function update(CategoryRequest $request, string $id)
    {
        $data = $request->validated();
        $locale = $this->getFormLanguage();
        $category = Category::findOrFail($id);
        $category->setDefaultLocale($locale);

        if ($data['parent_id'] == $id) {
            unset($data['parent_id']);
        }

        DB::transaction(fn() => $category->update($data));

        return $this->success(
            [
                'message' => __('core::translation.category_updated_successfully'),
                'redirect' => action([self::class, 'index']),
            ]
        );
    }

    public function bulk(Request $request)
    {
        $action = $request->input('action');
        $ids = $request->input('ids', []);

        if ($action == 'delete') {
            Category::whereIn('id', $ids)
                ->get()
                ->each
                ->delete();
        }

        return $this->success(
            [
                'message' => __('core::translation.category_updated_successfully'),
            ]
        );
    }

    public function quickStore(CategoryRequest $request)
    {
        $data = $request->validated();
        $locale = $this->getFormLanguage();

        $category = DB::transaction(fn() => Category::create($data));

        return $this->success(
            [
                'message' => __('core::translation.category_created_successfully'),
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                ],
            ]
        );
    }

    protected function mapCategories($categories, &$result, $prefix = '', $excludeId = null)
    {
        foreach ($categories as $category) {
            if ($excludeId && $category->id == $excludeId) {
                continue;
            }

            $result[$category->id] = $prefix . ' ' . $category->name;

            if ($category->children && $category->children->isNotEmpty()) {
                $this->mapCategories($category->children, $result, $prefix . '--', $excludeId);
            }
        }
    }
}
