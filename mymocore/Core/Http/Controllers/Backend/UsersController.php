<?php

namespace Mymo\Core\Http\Controllers\Backend;

use Illuminate\Support\Facades\Hash;
use Mymo\Core\Http\Controllers\BackendController;
use Mymo\Core\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends BackendController
{
    public function index()
    {
        return view('mymo_core::backend.users.index', [
            'title' => trans('mymo_core::app.users'),
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
        
        if (!is_null($status)) {
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
        $titlePage = $model->name ?? trans('mymo_core::app.add_new');
        $this->addBreadcrumb([
            'title' => trans('mymo_core::app.users'),
            'url' => route('admin.users.index')
        ]);

        return view('mymo_core::backend.users.form', [
            'model' => $model,
            'title' => $titlePage
        ]);
    }
    
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'password' => 'required_if:id,',
            'avatar' => 'nullable|string|max:150',
            'email' => 'required_if:id,|unique:users,email',
            'status' => 'required|in:0,1',
        ], [], [
            'name' => trans('mymo_core::app.name'),
            'email' => trans('mymo_core::app.email'),
            'password' => trans('mymo_core::app.password'),
            'avatar' => trans('mymo_core::app.avatar'),
            'status' => trans('mymo_core::app.status'),
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
                'password' => trans('mymo_core::app.password'),
                'password_confirmation' => trans('mymo_core::app.confirm_password')
            ]);
            
            $model->setAttribute('password', Hash::make($request->post('password')));
        }
        
        $model->save();
        
        return $this->success([
            'message' => trans('mymo_core::app.save_successfully')
        ]);
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required',
            'action' => 'required',
        ], [], [
            'ids' => trans('mymo_core::app.users')
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
            'message' => trans('mymo_core::app.successfully')
        ]);
    }
}
