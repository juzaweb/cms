<?php

namespace App\Http\Controllers\Backend;

use App\Models\Movies;
use App\Models\Servers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovieUploadController extends Controller
{
    public function index($id) {
        $movie = Movies::where('id', '=', $id)->firstOrFail();
        return view('backend.movie_upload.index', [
            'id' => $id,
            'movie' => $movie
        ]);
    }
    
    public function getData($id, Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Servers::query();
        $query->where('movie_id', '=', $id);
    
        if ($search) {
            $query->orWhere('name', 'like', '%'. $search .'%');
        }
    
        if (!is_null($status)) {
            $query->where('status', '=', $status);
        }
    
        $count = $query->count();
        $query->orderBy('order', 'asc');
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
    
        foreach ($rows as $row) {
            $row->created = $row->created_at->format('H:i d/m/Y');
            $row->edit_url = route('admin.genres.edit', ['id' => $row->id]);
        }
    
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save($id, Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:100',
            'order' => 'required|numeric',
        ], $request, [
            'name' => trans('app.name'),
            'order' => trans('app.order'),
        ]);
    
        $model = Servers::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->movie_id = $id;
        $model->save();
    
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
        ]);
    }
    
    public function remove($id, Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.servers'),
        ]);
        
        $ids = Servers::where('movie_id', '=', $id)
            ->whereIn('id', $request->post('ids'))
            ->pluck('id')
            ->toArray();
        
        Servers::destroy($ids);
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.genres'),
        ]);
    }
}
