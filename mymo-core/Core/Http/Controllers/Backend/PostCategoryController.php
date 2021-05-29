<?php

namespace Mymo\Core\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;
use Mymo\Core\Models\PostCategories;

class PostCategoryController extends BackendController
{
    public function index() {
        return view('mymo_core::backend.post_categories.index');
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = PostCategories::query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
                $subquery->orWhere('description', 'like', '%'. $search .'%');
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
            $row->edit_url = route('admin.post_categories.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null) {
        $model = PostCategories::firstOrNew(['id' => $id]);
        return view('mymo_core::backend.post_categories.form', [
            'model' => $model,
            'title' => $model->name ?: trans('mymo_core::app.add_new')
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250|unique:post_categories,name,' . $request->post('id'),
            'description' => 'nullable|string|max:300',
            'status' => 'required|in:0,1',
            'thumbnail' => 'nullable|string|max:250',
        ], $request, [
            'name' => trans('mymo_core::app.name'),
            'description' => trans('mymo_core::app.description'),
            'status' => trans('mymo_core::app.status'),
            'thumbnail' => trans('mymo_core::app.thumbnail'),
        ]);
        
        $addtype = $request->post('addtype');
        $model = PostCategories::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->save();
        
        if ($addtype == 2) {
            return response()->json($model->toArray());
        }
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.saved_successfully'),
            'redirect' => route('admin.post_categories'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('mymo_core::app.post_categories')
        ]);
        
        PostCategories::destroy($request->ids);
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.deleted_successfully'),
        ]);
    }
}
