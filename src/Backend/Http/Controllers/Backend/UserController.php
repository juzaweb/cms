<?php

namespace Mymo\Backend\Http\Controllers\Backend;

use Illuminate\Support\Facades\Hash;
use Mymo\Backend\Http\Controllers\BackendController;
use Mymo\Core\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends BackendController
{
    public function index()
    {
        $allStatus = User::getAllStatus();
        return view('mymo::backend.users.index', [
            'title' => trans('mymo::app.users'),
            'allStatus' => $allStatus
        ]);
    }
    
    public function getData(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = User::query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
            });
        }
        
        if ($status) {
            $query->where('status', '=', $status);
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->thumb_url = $row->getAvatar();
            $row->created = $row->created_at->format('H:i Y-m-d');
            $row->edit_url = route('admin.users.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null)
    {
        $model = User::firstOrNew(['id' => $id]);
        $allStatus = User::getAllStatus();
        $titlePage = $model->name ?? trans('mymo::app.add_new');
        $this->addBreadcrumb([
            'title' => trans('mymo::app.users'),
            'url' => route('admin.users.index')
        ]);

        return view('mymo::backend.users.form', [
            'model' => $model,
            'title' => $titlePage,
            'allStatus' => $allStatus
        ]);
    }
    
    public function save(Request $request)
    {
        $allStatus = array_keys(User::getAllStatus());

        $request->validate([
            'name' => 'required|string|max:250',
            'password' => 'required_if:id,',
            'avatar' => 'nullable|string|max:150',
            'email' => 'required_if:id,|unique:users,email',
            'status' => 'required|in:' . implode(',', $allStatus),
        ], [], [
            'name' => trans('mymo::app.name'),
            'email' => trans('mymo::app.email'),
            'password' => trans('mymo::app.password'),
            'avatar' => trans('mymo::app.avatar'),
            'status' => trans('mymo::app.status'),
        ]);
        
        $model = User::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->is_admin = $request->post('is_admin');
        
        if (empty($model->id)) {
            $model->setAttribute('email', $request->post('email'));
        }
        
        if ($request->post('password')) {
            $request->validate([
                'password' => 'required|string|max:32|min:8|confirmed',
                'password_confirmation' => 'required|string|max:32|min:8'
            ], [], [
                'password' => trans('mymo::app.password'),
                'password_confirmation' => trans('mymo::app.confirm_password')
            ]);
            
            $model->setAttribute('password', Hash::make($request->post('password')));
        }
        
        $model->save();
        
        return $this->success([
            'message' => trans('mymo::app.save_successfully')
        ]);
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required',
            'action' => 'required',
        ], [], [
            'ids' => trans('mymo::app.users')
        ]);

        $ids = $request->post('ids');
        $action = $request->post('action');

        try {
            DB::beginTransaction();
            switch ($action) {
                case 'delete':
                    User::destroy($ids);
                    break;
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->error([
                'message' => $exception->getMessage()
            ]);
        }

        return $this->success([
            'message' => trans('mymo::app.successfully')
        ]);
    }
}
