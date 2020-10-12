<?php

namespace App\Http\Controllers\Backend\LiveTV;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LiveTV\LiveTv;
use Illuminate\Support\Str;

class LiveTvController extends Controller
{
    public function index() {
        return view('backend.live-tv.index');
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = LiveTv::query();
        $query->where('tv_series', '=', 0);
        
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
            $row->description = Str::words(strip_tags($row->description), 15);
            $row->edit_url = route('admin.movies.edit', [$row->id]);
            $row->preview_url = route('watch', [$row->slug]);
            $row->upload_url = route('admin.movies.servers', ['movies', $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null) {
        $model = LiveTv::firstOrNew(['id' => $id]);
        
        return view('backend.live-tv.form', [
            'model' => $model,
            'title' => $model->name ?: trans('app.add_new'),
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250',
            'description' => 'nullable',
            'status' => 'required|in:0,1',
            'thumbnail' => 'nullable|string|max:250',
            
        ], $request, [
            'name' => trans('app.name'),
            'description' => trans('app.description'),
            'status' => trans('app.status'),
            'thumbnail' => trans('app.thumbnail'),
            
        ]);
        
        $model = LiveTv::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.movies'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.movies')
        ]);
        
        LiveTv::destroy($request->post('ids'));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
        ]);
    }
}
