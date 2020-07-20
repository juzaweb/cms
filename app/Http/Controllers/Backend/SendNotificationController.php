<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MyNotification;

class SendNotificationController extends Controller
{
    public function index() {
        return view('backend.notification.index');
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
        return view('backend.notification.form', [
            'model' => $model,
            'title' => $model->name ?: trans('app.add_new')
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250',
            'subject' => 'required|string|max:300',
            'content' => 'required',
            'type' => 'required|in:1,2,3',
        ], $request, [
            'name' => trans('app.name'),
            'subject' => trans('app.subject'),
            'content' => trans('app.content'),
            'type' => trans('app.type'),
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
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.notification'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.notification')
        ]);
        
        MyNotification::destroy($request->post('ids'));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
        ]);
    }
}
