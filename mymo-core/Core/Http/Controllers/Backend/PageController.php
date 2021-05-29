<?php

namespace Mymo\Core\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;
use Mymo\Core\Models\Pages;

class PageController extends BackendController
{
    public function index()
    {
        return view('mymo_core::backend.pages.index', [
            'title' => trans('mymo_core::app.pages')
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
        
        $query = Pages::query();
        
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
            $row->thumb_url = $row->getThumbnail();
            $row->created = $row->created_at->format('H:i Y-m-d');
            $row->edit_url = route('admin.pages.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null)
    {
        $model = Pages::firstOrNew(['id' => $id]);
        return view('mymo_core::backend.pages.form', [
            'model' => $model,
            'title' => $model->name ?: trans('mymo_core::app.add_new')
        ]);
    }
    
    public function save(Request $request)
    {
        $this->validateRequest([
            'name' => 'required|string|max:250|unique:pages,name',
            'status' => 'required|in:0,1',
            'thumbnail' => 'nullable|string|max:250',
        ], $request, [
            'name' => trans('mymo_core::app.name'),
            'status' => trans('mymo_core::app.status'),
            'thumbnail' => trans('mymo_core::app.thumbnail'),
        ]);
        
        $model = Pages::firstOrNew(['id' => $request->id]);
        $model->fill($request->all());
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.saved_successfully'),
            'redirect' => route('admin.pages'),
        ]);
    }
    
    public function remove(Request $request)
    {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('mymo_core::app.pages')
        ]);
        
        Pages::destroy($request->ids);
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.deleted_successfully'),
        ]);
    }
}
