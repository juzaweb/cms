<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Juzaweb\CMS\Contracts\HookActionContract;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Repositories\BaseRepository;

class ResourceManagementController extends BackendController
{
    protected HookActionContract $hookAction;

    protected Collection $setting;

    protected string $modelClass;

    public function __construct(HookActionContract $hookAction)
    {
        $this->hookAction = $hookAction;
    }

    public function index(string $key): Factory|View
    {
        $this->checkPermission('index', $this->getModel($key), $key);

        $setting = $this->getSetting($key);

        $title = $setting->get('label');

        return view(
            'cms::backend.resource_management.index',
            compact('setting', 'title')
        );
    }

    public function create(string $key): Factory|View
    {
        $this->checkPermission('create', $this->getModel($key), $key);

        $this->addBreadcrumb(
            [
                'title' => $this->getSetting($key)->get('label'),
                'url' => action([static::class, 'index'], [$key]),
            ]
        );

        $model = $this->getRepository($key)->makeModel();

        return view(
            'cms::backend.resource_management.form',
            [
                'title' => trans('cms::app.add_new'),
                'linkIndex' => action([static::class, 'index'], [$key])
            ]
        );
    }

    public function edit(string $key, int $id): Factory|View
    {
        $this->addBreadcrumb(
            [
                'title' => $this->getSetting($key)->get('label'),
                'url' => action([static::class, 'index'], [$key]),
            ]
        );

        $model = $this->getRepository($key)->find($id);

        $this->checkPermission('edit', $model, $key);

        return view(
            'cms::backend.resource_management.form',
            [
                'title' => $model->{$model->getFieldName()},
                'linkIndex' => action([static::class, 'index'], [$key])
            ]
        );
    }

    public function store(Request $request, string $key)
    {
        $this->checkPermission('create', $this->getModel($key), $key);

        $validator = $this->validator($request->all(), $key);
        if (is_array($validator)) {
            $validator = Validator::make($request->all(), $validator);
        }

        $validator->validate();
        $data = $request->all();

        DB::beginTransaction();

        try {
            $model = $this->getRepository($key)->getModel();
            $slug = $request->input('slug');

            if ($slug && method_exists($model, 'generateSlug')) {
                $data['slug'] = $model->generateSlug($slug);
            }

            $model->fill($data);
            $model->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->storeSuccessResponse(
            $model,
            $request,
            $key
        );
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validator($request->all(), $key);
        if (is_array($validator)) {
            $validator = Validator::make($request->all(), $validator);
        }

        $validator->validate();
        $data = $this->parseDataForSave($request->all(), $key);

        $model = $this->makeModel($key)
            ->findOrFail($this->getPathId($params));
        $this->checkPermission('edit', $model, $key);

        DB::beginTransaction();
        try {
            $slug = $request->input('slug');
            if ($slug && method_exists($model, 'generateSlug')) {
                $data['slug'] = $model->generateSlug($slug);
            }

            $model->fill($data);
            $model->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        if (method_exists($this, 'updateSuccess')) {
            $this->updateSuccess($request, $model, $key);
        }

        if (method_exists($this, 'saveSuccess')) {
            $this->saveSuccess($request, $model, $key);
        }

        return $this->updateSuccessResponse(
            $model,
            $request,
            $key
        );
    }

    public function datatable(Request $request, string $key)
    {
        $this->checkPermission(
            'index',
            $this->getModel($key),
            $key
        );

        $table = $this->getDataTable($key);
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

                if (!empty($column['detailFormater'])) {
                    $results[$index]['detailFormater'] = $column['detailFormater'](
                        $index,
                        $row
                    );
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

    public function bulkActions(Request $request, string $key)
    {
        $request->validate(
            [
                'ids' => 'required|array',
                'action' => 'required',
            ]
        );

        $action = $request->post('action');
        $ids = $request->post('ids');

        $table = $this->getDataTable($key);
        $results = [];

        foreach ($ids as $id) {
            $model = $this->makeModel($key)->find($id);
            $permission = $action != 'delete' ? 'edit' : 'delete';

            if (!$this->hasPermission($permission, $model, $key)) {
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

    protected function checkPermission($ability, $arguments, $key)
    {
        $this->authorize($ability, $arguments);
    }

    protected function hasPermission($ability, $arguments, $key): bool
    {
        $response = Gate::inspect($ability, $arguments);

        return $response->allowed();
    }

    protected function getModel(string $key): string
    {
        if (isset($this->modelClass)) {
            return $this->modelClass;
        }

        $this->modelClass =  get_class($this->getRepository($key)->getModel());

        return $this->modelClass;
    }

    protected function getRepository(string $key): BaseRepository
    {
        return app($this->getSetting($key)->get('repository'));
    }

    protected function getSetting(string $key): Collection
    {
        if (isset($this->setting)) {
            return $this->setting;
        }

        $this->setting = $this->hookAction->getResourceManagements($key);

        return $this->setting;
    }
}
