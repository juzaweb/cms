<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 6/9/2021
 * Time: 2:05 PM
 */

namespace Mymo\Core\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait ResourceController
{
    public function index()
    {
        return view($this->viewPrefix . '.index', [
            'title' => $this->getTitle()
        ]);
    }

    public function create()
    {
        $this->addBreadcrumb([
            'title' => $this->getTitle(),
            'url' => action([static::class, 'index']),
        ]);

        $model = $this->makeModel();
        return view($this->viewPrefix . '.form', array_merge([
            'title' => trans('mymo_core::app.add_new')
        ], $this->getDataDataForForm($model)));
    }

    public function edit($id)
    {
        $this->addBreadcrumb([
            'title' => $this->getTitle(),
            'url' => action([static::class, 'index']),
        ]);

        $model = $this->makeModel()->findOrFail($id);
        return view($this->viewPrefix . '.form', array_merge([
            'title' => $model->{$model->getFieldName()}
        ], $this->getDataDataForForm($model)));
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        DB::beginTransaction();
        try {
            $this->beforeStore($request);
            $model = $this->getModel()::create($request->all());
            $this->afterStore($request, $model);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success([
            'message' => trans('mymo_core::app.created_successfully')
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validator($request->all())->validate();
        $model = $this->makeModel()->findOrFail($id);
        DB::beginTransaction();
        try {
            $this->beforeUpdate($request, $model);
            $model->update($request->all());
            $this->afterUpdate($request, $model);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success([
            'message' => trans('mymo_core::app.updated_successfully')
        ]);
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'action' => 'required',
        ]);

        $action = $request->post('action');
        $ids = $request->post('ids');

        foreach ($ids as $id) {
            switch ($action) {
                case 'delete':
                    $this->makeModel()->find($id)->delete($id);
                    break;
                default:
                    $this->makeModel()->find($id)->update([
                        'status' => $action
                    ]);
                    break;
            }
        }

        return $this->success([
            'message' => trans('mymo_core::app.successfully')
        ]);
    }

    public function getDataTable(Request $request)
    {
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $query = $this->makeModel()->newQuery();
        $query->filter($request->all());

        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();

        foreach ($rows as $row) {
            $row->edit_url = route('admin.design.sliders.edit', [$row->id]);
        }

        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }

    protected function beforeStore(Request $request)
    {
        //
    }

    protected function afterStore(Request $request, $model)
    {
        //
    }

    protected function beforeUpdate(Request $request, $model)
    {
        //
    }

    protected function afterUpdate(Request $request, $model)
    {
        //
    }

    protected function makeModel()
    {
        return app($this->getModel());
    }

    protected function parseDataForSave(array $attributes)
    {
        return $attributes;
    }

    /**
     * Get data for form
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return array
     * */
    protected function getDataDataForForm($model)
    {
        return [
            'model' => $model
        ];
    }

    /**
     * Validator for store and update
     *
     * @param array $attributes
     * @return \Illuminate\Support\Facades\Validator
     * */
    abstract protected function validator(array $attributes);

    /**
     * Get model resource
     *
     * @return \Illuminate\Database\Eloquent\Model
     * */
    abstract protected function getModel();

    /**
     * Get title resource
     *
     * @return string
     **/
    abstract protected function getTitle();
}