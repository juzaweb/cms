<?php

namespace Mymo\Core\Http\Controllers\Backend;

use Mymo\Core\Models\User;
use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;
use Mymo\Core\Models\MyNotification;

class SendNotificationController extends BackendController
{
    public function index() {
        return view('mymo_core::backend.notification.index');
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = MyNotification::query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
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
            $row->created = $row->created_at->format('H:i Y-m-d');
            $row->edit_url = route('admin.notification.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null) {
        $model = MyNotification::firstOrNew(['id' => $id]);
        $users = User::whereIn('id', explode(',', $model->users))
            ->get(['id', 'name']);
        return view('mymo_core::backend.notification.form', [
            'title' => $model->name ?: trans('mymo_core::app.add_new'),
            'model' => $model,
            'users' => $users,
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250',
            'subject' => 'required|string|max:300',
            'content' => 'required',
            'type' => 'required|in:1,2,3',
        ], $request, [
            'name' => trans('mymo_core::app.name'),
            'subject' => trans('mymo_core::app.subject'),
            'content' => trans('mymo_core::app.content'),
            'type' => trans('mymo_core::app.type'),
        ]);
        
        $users = $request->post('users');
        $model = MyNotification::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        
        if (empty($users)) {
            $model->users = null;
        }
        else {
            $model->users = implode(',', $users);
        }
        
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.saved_successfully'),
            'redirect' => route('admin.notification'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('mymo_core::app.notification')
        ]);
        
        MyNotification::destroy($request->post('ids'));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.deleted_successfully'),
        ]);
    }
}
