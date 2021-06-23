<?php

namespace Mymo\Backend\Http\Controllers\Backend;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mymo\Notification\Http\Requests\NotificationRequest;
use Mymo\Backend\Http\Controllers\BackendController;
use Mymo\Core\Models\User;
use Mymo\Notification\Models\ManualNotification;
use Mymo\Notification\SendNotification;
use Mymo\Notification\Jobs\SendNotification as SendNotificationJob;

class NotificationController extends BackendController
{
    public function index()
    {
        return view('mymo_core::backend.notification.index', [
            'title' => trans('mymo_core::app.notifications')
        ]);
    }
    
    public function getDataTable(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = ManualNotification::query();
        if ($search) {
            $query->where(function (Builder $subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
                $subquery->orWhere('subject', 'like', '%'. $search .'%');
            });
        }
        
        if (!is_null($status)) {
            $query->where('status', '=', $status);
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->created = (string) $row->created_at;
            $row->edit_url = route('admin.notification.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function create()
    {
        $this->addBreadcrumb([
            'title' => trans('mymo_core::app.notification'),
            'url' => route('admin.notification.index')
        ]);

        $model = new ManualNotification();
        $vias = $this->getVias();
        return view('mymo_core::backend.notification.form', [
            'title' => trans('mymo_core::app.add_new'),
            'model' => $model,
            'vias' => $vias,
        ]);
    }

    public function edit($id)
    {
        $this->addBreadcrumb([
            'title' => trans('mymo_core::app.notifications'),
            'url' => route('admin.notification.index')
        ]);

        $vias = $this->getVias();
        $model = ManualNotification::findOrFail($id);
        $users = User::whereIn('id', explode(',', $model->users))
            ->get(['id', 'name']);

        return view('mymo_core::backend.notification.form', [
            'title' => $model->data['subject'] ?? '',
            'model' => $model,
            'users' => $users,
            'vias' => $vias,
        ]);
    }
    
    public function store(NotificationRequest $request)
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
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->error($exception->getMessage());
        }

        return $this->success(
            trans('mymo_core::app.saved_successfully')
        );
    }

    public function update(NotificationRequest $request, $id)
    {
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
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->error($exception->getMessage());
        }

        return $this->success(
            trans('mymo_core::app.save_successfully')
        );
    }
    
    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required',
            'action' => 'required',
        ], [], [
            'ids' => trans('mymo_core::app.notifications')
        ]);

        $ids = $request->post('ids');
        $action = $request->post('action');

        try {
            DB::beginTransaction();
            switch ($action) {
                case 'delete':
                    ManualNotification::destroy($ids);
                    break;
                case 'send':
                    ManualNotification::whereIn('id', $ids)
                        ->update([
                            'status' => 2
                        ]);

                    $useMethod = config('mymo.notification.method');
                    if (in_array($useMethod, ['sync', 'queue'])) {
                        foreach ($ids as $id) {
                            $notification = ManualNotification::find($id);
                            if (empty($notification)) {
                                continue;
                            }

                            switch ($useMethod) {
                                case 'sync':
                                    (new SendNotification($notification))->send();
                                    break;
                                case 'queue':
                                    SendNotificationJob::dispatch($notification);
                                    break;
                            }
                        }
                    }
                    break;
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->error(
                $exception->getMessage()
            );
        }

        return $this->success([
            'message' => trans('mymo_core::app.successfully')
        ]);
    }

    protected function getVias()
    {
        $vias = collect(config('mymo.notification.via'));
        return $vias->where('enable', true);
    }
}
