<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/juzacms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

trait ResourceController
{
    public function index(...$params)
    {
        $this->checkPermission(
            'index',
            $this->getModel(...$params),
            ...$params
        );

        return view(
            $this->viewPrefix . '.index',
            $this->getDataForIndex(...$params)
        );
    }

    public function create(...$params)
    {
        $this->checkPermission('create', $this->getModel(...$params), ...$params);

        $indexRoute = str_replace(
            '.create',
            '.index',
            Route::currentRouteName()
        );

        $this->addBreadcrumb(
            [
                'title' => $this->getTitle(...$params),
                'url' => route($indexRoute, $params),
            ]
        );

        $model = $this->makeModel(...$params);

        return view(
            $this->viewPrefix . '.form',
            array_merge(
                [
                    'title' => trans('cms::app.add_new'),
                    'linkIndex' => action([static::class, 'index'], $params)
                ],
                $this->getDataForForm($model, ...$params)
            )
        );
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

        $this->addBreadcrumb(
            [
                'title' => $this->getTitle(...$params),
                'url' => route($indexRoute, $indexParams),
            ]
        );

        $model = $this->makeModel(...$indexParams)->findOrFail($this->getPathId($params));
        $this->checkPermission('edit', $model, ...$params);

        return view(
            $this->viewPrefix . '.form',
            array_merge(
                [
                    'title' => $model->{$model->getFieldName()},
                    'linkIndex' => action([static::class, 'index'], $indexParams)
                ],
                $this->getDataForForm($model, ...$params)
            )
        );
    }

    public function store(Request $request, ...$params)
    {
        $this->checkPermission('create', $this->getModel(...$params), ...$params);

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
        $this->checkPermission('edit', $model, ...$params);

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

    public function datatable(Request $request, ...$params)
    {
        $this->checkPermission(
            'index',
            $this->getModel(...$params),
            ...$params
        );

        $table = $this->getDataTable(...$params);
        $table->setCurrentUrl(action([static::class, 'index'], $params, false));

        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = (int) $request->get('limit', 20);

        $query = $table->query($request->all());
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();

        $results = [];
        $columns = $table->columns();

        foreach ($rows as $index => $row) {
            $columns['id'] = $row->id;
            foreach ($columns as $col => $column) {
                if (! empty($column['formatter'])) {
                    $results[$index][$col] = $column['formatter'](
                        $row->{$col} ?? null,
                        $row,
                        $index
                    );
                } else {
                    $results[$index][$col] = $row->{$col};
                }
            }
        }

        return response()->json(
            [
                'total' => $count,
                'rows' => $results,
            ]
        );
    }

    public function bulkActions(Request $request, ...$params)
    {
        $request->validate(
            [
                'ids' => 'required|array',
                'action' => 'required',
            ]
        );

        $action = $request->post('action');
        $ids = $request->post('ids');

        $table = $this->getDataTable(...$params);
        $results = [];

        foreach ($ids as $id) {
            $model = $this->makeModel(...$params)->find($id);
            $permission = $action != 'delete' ? 'edit' : 'delete';

            if (!$this->getPermission($permission, $model, ...$params)) {
                continue;
            }

            $results[] = $id;
        }

        $table->bulkActions($action, $results);

        return $this->success(
            [
                'message' => trans('cms::app.successfully'),
            ]
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
     * @param \Juzaweb\CMS\Models\Model $model
     * @param mixed $params
     */
    protected function afterSave($data, $model, ...$params)
    {
        //
    }

    /**
     * @param $params
     * @return \Juzaweb\CMS\Models\ResourceModel
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
        $dataTable->setDataUrl(action([static::class, 'datatable'], $params));
        $dataTable->setActionUrl(action([static::class, 'bulkActions'], $params));
        $dataTable->setCurrentUrl(action([static::class, 'index'], $params, false));

        $canCreate = $this->getPermission(
            'create',
            $this->getModel(...$params),
            ...$params
        );

        return [
            'title' => $this->getTitle(...$params),
            'dataTable' => $dataTable,
            'canCreate' => $canCreate,
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

        return $this->success(
            [
                'message' => trans('cms::app.created_successfully'),
                'redirect' => route($indexRoute, $params),
            ]
        );
    }

    protected function updateSuccessResponse($model, $request, ...$params)
    {
        $editRoute = str_replace(
            '.update',
            '.edit',
            Route::currentRouteName()
        );

        return $this->success(
            [
                'message' => trans('cms::app.updated_successfully'),
                'redirect' => route($editRoute, $params),
            ]
        );
    }

    protected function isUpdateRoute()
    {
        return Route::getCurrentRoute()->getName() == 'admin.resource.update';
    }

    protected function checkPermission($ability, $arguments = [], ...$params)
    {
        $this->authorize($ability, $arguments);
    }

    protected function getPermission($ability, $arguments = [], ...$params)
    {
        $response = Gate::inspect($ability, $arguments);
        return $response->allowed();
    }

    /**
     * Get data table resource
     *
     * @return \Juzaweb\CMS\Abstracts\DataTable
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
