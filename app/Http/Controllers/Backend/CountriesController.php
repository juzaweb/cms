<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Countries;

class CountriesController extends Controller
{
    public function index() {
        return view('backend.countries.index');
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
    
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Countries::query();
        
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
            $row->edit_url = route('admin.countries.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null) {
        $model = Countries::firstOrNew(['id' => $id]);
        return view('backend.countries.form', [
            'model' => $model,
            'title' => $model->name ?: trans('app.add_new')
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250|unique:countries,name,' . $request->post('id'),
            'description' => 'nullable|string|max:300',
            'status' => 'required|in:0,1',
            'thumbnail' => 'nullable|string|max:250',
        ], $request, [
            'name' => trans('app.name'),
            'description' => trans('app.description'),
            'status' => trans('app.status'),
            'thumbnail' => trans('app.thumbnail'),
        ]);
    
        $addtype = $request->post('addtype');
        $model = Countries::firstOrNew(['id' => $request->id]);
        $model->fill($request->all());
        $model->save();
    
        if ($addtype == 2) {
            return response()->json($model->toArray());
        }
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.countries'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.countries')
        ]);
        
        Countries::destroy($request->ids);
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
        ]);
    }
}
