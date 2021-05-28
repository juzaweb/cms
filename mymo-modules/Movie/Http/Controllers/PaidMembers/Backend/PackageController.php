<?php

namespace App\Core\Http\Controllers\PaidMembers\Backend;

use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;
use Modules\Movie\Models\PaidMembers\Package;

class PackageController extends BackendController
{
    public function index() {
        return view('paid-members.backend.package.index');
    }
    
    public function form($id = null) {
        $model = Package::firstOrNew(['id' => $id]);
        return view('paid-members.backend.package.form', [
            'model' => $model,
            'title' => $model->name ?: trans('app.add_new')
        ]);
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Package::query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
                $subquery->orWhere('days', 'like', '%'. $search .'%');
                $subquery->orWhere('price', 'like', '%'. $search .'%');
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
            $row->edit_url = route('admin.package.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250|unique:package,name',
            'days' => 'required|integer',
            'price' => 'required|float',
            'status' => 'required|in:0,1',
        ], $request, [
            'name' => trans('app.name'),
            'status' => trans('app.status'),
        ]);
        
        $model = Package::firstOrNew(['id' => $request->id]);
        $model->fill($request->all());
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.package'),
        ]);
    }
    
    public function status(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
            'status' => 'required|in:0,1',
        ], $request, [
            'ids' => trans('app.package'),
            'status' => trans('app.status'),
        ]);
        
        $status = $request->post('status');
        
        Package::whereIn('id', $request->post('ids'))
            ->update([
                'status' => $status,
            ]);
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.package')
        ]);
        
        Package::destroy($request->post('ids'));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
        ]);
    }
}
