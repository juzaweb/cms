<?php

namespace Juzaweb\Notification\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Juzaweb\Backend\Http\Controllers\Backend\PageController;
use Juzaweb\Notification\Http\Datatable\NotificationDatatable;
use Juzaweb\Notification\Http\Requests\NotificationRequest;
use Juzaweb\CMS\Models\User;
use Juzaweb\Backend\Models\ManualNotification;
use Juzaweb\CMS\Traits\ResourceController;

class NotificationController extends PageController
{
    use ResourceController {
        getDataForForm as DataForForm;
    }

    protected $viewPrefix = 'juno::notification';

    protected function getDataTable(...$params)
    {
        $dataTable = new NotificationDatatable();
        return $dataTable;
    }
    
    public function create(...$params)
    {
        $this->addBreadcrumb([
            'title' => trans('cms::app.notification'),
            'url' => route('admin.notification.index')
        ]);

        $model = new ManualNotification();
        $vias = $this->getVias();
        return view('juno::notification.form', [
            'title' => trans('cms::app.add_new'),
            'model' => $model,
            'vias' => $vias,
        ]);
    }

    public function edit(...$params)
    {
        $this->addBreadcrumb([
            'title' => trans('cms::app.notifications'),
            'url' => route('admin.notification.index')
        ]);

        $id = $params[0];
        $vias = $this->getVias();
        $model = ManualNotification::findOrFail($id);
        $users = User::whereIn('id', explode(',', $model->users))
            ->get(['id', 'name']);

        return view('juno::notification.form', [
            'title' => $model->data['subject'] ?? '',
            'model' => $model,
            'users' => $users,
            'vias' => $vias,
        ]);
    }
    
    public function store(NotificationRequest $request, ...$params)
    {
        $via = $request->post('via');
        $via = implode(',', $via);

        $users = $request->post('users');
        $users = $users ? implode(',', $users) : -1;

        DB::beginTransaction();
        try {
            $model = new ManualNotification();
            $model->fill($request->all());
            $model->setAttribute('status', 4);
            $model->setAttribute('method', $via);
            $model->setAttribute('users', $users);
            $model->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success([
            'message' => trans('cms::app.saved_successfully'),
            'redirect' => action([static::class, 'index'])
        ]);
    }

    public function update(NotificationRequest $request, ...$params)
    {
        $id = $params[0];
        $via = $request->post('via');
        $via = implode(',', $via);

        $users = $request->post('users');
        $users = $users ? implode(',', $users) : -1;

        DB::beginTransaction();
        try {
            $model = ManualNotification::findOrFail($id);
            $model->fill($request->all());
            $model->setAttribute('method', $via);
            $model->setAttribute('users', $users);
            $model->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success([
            'message' => trans('cms::app.save_successfully'),
            'redirect' => action([static::class, 'index'])
        ]);
    }

    protected function getVias()
    {
        $vias = collect(config('notification.via', []));
        return $vias;
    }

    protected function validator(array $attributes, ...$params)
    {
        return [];
    }

    protected function getModel(...$params)
    {
        return ManualNotification::class;
    }

    protected function getTitle(...$params)
    {
        return trans('cms::app.notifications');
    }

    protected function getDataForForm($model, ...$params)
    {
        $data = $this->DataForForm($model);
        $data['vias'] = $this->getVias();
        return $data;
    }
}
