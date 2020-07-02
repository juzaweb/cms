<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Movies;

class MoviesController extends Controller
{
    public function index() {
        return view('backend.genres.index');
    }
    
    public function getData(Request $request) {
        $search = $request->input('search');
        $sort = $request->input('sort', 'a.id');
        $order = $request->input('order', 'desc');
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 20);
        
        $query = Movies::query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
                $subquery->orWhere('description', 'like', '%'. $search .'%');
            });
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->thumb_url = $row->getThumbnail();
            $row->created = $row->created_at->format('H:i d/m/Y');
            $row->edit_url = route('admin.genres.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null) {
        $model = Movies::firstOrNew(['id' => $id]);
        return view('backend.genres.form', [
            'model' => $model,
            'title' => $model->name ?: trans('app.add_new')
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250',
            'description' => 'nullable|string|max:300',
            'status' => 'required|in:0,1',
            'thumbnail' => 'nullable|string|max:250',
        ], $request, [
            'name' => trans('app.name'),
            'description' => trans('app.description'),
            'status' => trans('app.status'),
            'thumbnail' => trans('app.thumbnail'),
        ]);
        
        $model = Movies::firstOrNew(['id' => $request->id]);
        $model->fill($request->all());
        $model->createSlug();
        
        if ($request->thumbnail) {
            $model->thumbnail = explode('storage', $request->thumbnail)[1];
        }
        
        $model->save();
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.genres'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.genres')
        ]);
        
        Movies::destroy($request->ids);
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
        ]);
    }
}
