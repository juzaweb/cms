<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 */

namespace Juzaweb\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

trait ResourceController
{
    public function index(...$params)
    {
        $this->checkPermission('index', $this->getModel(...$params));

        return view(
            $this->viewPrefix . '.index',
            $this->getDataForIndex(...$params)
        );
    }

    public function create(...$params)
    {
        $this->checkPermission('create', $this->getModel(...$params));

        $indexRoute = str_replace(
            '.create',
            '.index',
            Route::currentRouteName()
        );

        $this->addBreadcrumb([
            'title' => $this->getTitle(...$params),
            'url' => route($indexRoute, $params),
        ]);

        $model = $this->makeModel(...$params);

        return view($this->viewPrefix . '.form', array_merge([
            'title' => trans('cms::app.add_new'),
            'linkIndex' => action([static::class, 'index'], $params)
        ], $this->getDataForForm($model, ...$params)));
    }

    public function edit(...$params)
    {
        $indexRoute = str_replace(
            '.edit',
            '.index',
            Route::currentRouteName()
        );

        $indexParams = $params;
        unset($indexParams[$this->getPathIdIndex($indexParams)]);
        $indexParams = collect($indexParams)->values()->toArray();

        $this->addBreadcrumb([
            'title' => $this->getTitle(...$params),
            'url' => route($indexRoute, $indexParams),
        ]);

        $model = $this->makeModel(...$indexParams)->findOrFail($this->getPathId($params));
        $this->checkPermission('edit', $model);

        return view($this->viewPrefix . '.form', array_merge([
            'title' => $model->{$model->getFieldName()},
            'linkIndex' => action([static::class, 'index'], $indexParams)
        ], $this->getDataForForm($model, ...$params)));
    }

    public function store(Request $request, ...$params)
    {
        $this->checkPermission('create', $this->getModel(...$params));

        $validator = $this->validator($request->all(), ...$params);
        if (is_array($validator)) {
            $validator = Validator::make($request->all(), $validator);
        }

        $validator->validate();
        $data = $this->parseDataForSave($request->all(), ...$params);

        DB::beginTransaction();

        try {
            $this->beforeStore($request);
            $model = $this->makeModel(...$params);
            $slug = $request->input('slug');

            if ($slug && method_exists($model, 'generateSlug')) {
                $data['slug'] = $model->generateSlug($slug);
            }

            $model->fill($data);
            $this->beforeSave($data, $model, ...$params);
            $model->save();

            $this->afterStore($request, $model, ...$params);
            $this->afterSave($data, $model, ...$params);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->storeSuccessResponse(
            $model,
            $request,
            ...$params
        );
    }

    public function update(Request $request, ...$params)
    {
        $validator = $this->validator($request->all(), ...$params);
        if (is_array($validator)) {
            $validator = Validator::make($request->all(), $validator);
        }

        $validator->validate();
        $data = $this->parseDataForSave($request->all(), ...$params);

        $model = $this->makeModel(...$params)
            ->findOrFail($this->getPathId($params));
        $this->checkPermission('edit', $model);

        DB::beginTransaction();
        try {
            $this->beforeUpdate($request, $model, ...$params);
            $slug = $request->input('slug');
            if ($slug && method_exists($model, 'generateSlug')) {
                $data['slug'] = $model->generateSlug($slug);
            }

            $model->fill($data);
            $this->beforeSave($data, $model, ...$params);
            $model->save();

            $this->afterUpdate($request, $model, ...$params);
            $this->afterSave($data, $model, ...$params);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->updateSuccessResponse(
            $model,
            $request,
            ...$params
        );
    }

    public function getDataForSelect(Request $request, ...$params)
    {
        $queries = $request->query();
        $exceptIds = $request->get('except_ids');
        $model = $this->makeModel(...$params);
        $limit = $request->get('limit', 10);

        if ($limit > 100) {
            $limit = 100;
        }

        $query = $model::query();
        $query->select(
            [
                'id',
                $model->getFieldName() . ' AS text',
            ]
        );

        $query->whereFilter($queries);

        if ($exceptIds) {
            $query->whereNotIn('id', $exceptIds);
        }

        $paginate = $query->paginate($limit);
        $data['results'] = $query->get();
        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }

        return response()->json($data);
    }

    protected function beforeStore(Request $request, ...$params)
    {
        //
    }

    protected function afterStore(Request $request, $model, ...$params)
    {
        //
    }

    protected function beforeUpdate(Request $request, $model, ...$params)
    {
        //
    }

    protected function afterUpdate(Request $request, $model, ...$params)
    {
        //
    }

    protected function beforeSave(&$data, &$model, ...$params)
    {
        //
    }

    /**
     * After Save model
     *
     * @param array $data
     * @param \Juzaweb\Models\Model $model
     * @param mixed $params
     */
    protected function afterSave($data, $model, ...$params)
    {
        //
    }

    /**
     * @param $params
     * @return \Juzaweb\Models\ResourceModel
     */
    protected function makeModel(...$params)
    {
        return app($this->getModel(...$params));
    }

    protected function parseDataForSave(array $attributes, ...$params)
    {
        return $attributes;
    }

    /**
     * Get data for form
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return array
     */
    protected function getDataForForm($model, ...$params)
    {
        return [
            'model' => $model
        ];
    }

    protected function getDataForIndex(...$params)
    {
        $dataTable = $this->getDataTable(...$params);

        return [
            'title' => $this->getTitle(...$params),
            'dataTable' => $dataTable,
            'linkCreate' => action([static::class, 'create'], $params),
        ];
    }

    protected function getPathIdIndex($params)
    {
        return count($params) - 1;
    }

    protected function getPathId($params)
    {
        return $params[$this->getPathIdIndex($params)];
    }

    protected function storeSuccessResponse($model, $request, ...$params)
    {
        $indexRoute = str_replace(
            '.store',
            '.index',
            Route::currentRouteName()
        );

        return $this->success([
            'message' => trans('cms::app.created_successfully'),
            'redirect' => route($indexRoute, $params),
        ]);
    }

    protected function updateSuccessResponse($model, $request, ...$params)
    {
        $editRoute = str_replace(
            '.update',
            '.edit',
            Route::currentRouteName()
        );

        return $this->success([
            'message' => trans('cms::app.updated_successfully'),
            'redirect' => route($editRoute, $params),
        ]);
    }

    protected function isUpdateRoute()
    {
        return Route::getCurrentRoute()->getName() == 'admin.resource.update';
    }

    protected function checkPermission($ability, $arguments = [])
    {
        $this->authorize($ability, $arguments);
    }

    /**
     * Get data table resource
     *
     * @return \Juzaweb\Abstracts\DataTable
     */
    abstract protected function getDataTable(...$params);

    /**
     * Validator for store and update
     *
     * @param array $attributes
     * @return Validator|array
     */
    abstract protected function validator(array $attributes, ...$params);

    /**
     * Get model resource
     *
     * @param array $params
     * @return string // namespace model
     */
    abstract protected function getModel(...$params);

    /**
     * Get title resource
     *
     * @param array $params
     * @return string
     */
    abstract protected function getTitle(...$params);
}
