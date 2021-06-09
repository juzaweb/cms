<?php

namespace Plugins\Movie\Http\Controllers\Backend;

use Plugins\Movie\Models\Movie\Movie;
use Plugins\Movie\Models\Video\VideoServers;
use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;

class MovieServesController extends BackendController
{
    public function index($page_type, $movie_id) {
        $movie = Movie::where('id', '=', $movie_id)->firstOrFail();
        return view('movie::movie_servers.index', [
            'movie' => $movie,
            'title' => trans('movie::app.servers_video'),
            'page_type' => $page_type,
        ]);
    }
    
    public function form($page_type, $movie_id, $server_id = null) {
        $movie = Movie::where('id', '=', $movie_id)->firstOrFail();
        $model = VideoServers::firstOrNew(['id' => $server_id]);
        return view('movie::movie_servers.form', [
            'title' => $model->name ? $model->name : trans('movie::app.add_new'),
            'movie' => $movie,
            'model' => $model,
            'page_type' => $page_type,
        ]);
    }
    
    public function getData($page_type, $movie_id, Request $request) {
        Movie::where('id', '=', $movie_id)
            ->firstOrFail();
        
        $search = $request->get('search');
        $status = $request->get('status');
        
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = VideoServers::query();
        $query->where('movie_id', '=', $movie_id);
        
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
            $row->created = $row->created_at->format('H:i Y-m-d');
            $row->upload_url = route('admin.movies.servers.upload', [$page_type, $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save($page_type, $movie_id, Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:100',
            'order' => 'required|numeric',
        ], $request, [
            'name' => trans('movie::app.name'),
            'order' => trans('movie::app.order'),
        ]);
        
        $model = VideoServers::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->movie_id = $movie_id;
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('movie::app.saved_successfully'),
            'redirect' => route('admin.movies.servers', [$page_type, $movie_id]),
        ]);
    }
    
    public function remove($page_type, $movie_id, Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('movie::app.servers'),
        ]);
        
        $movie_ids = VideoServers::where('movie_id', '=', $movie_id)
            ->whereIn('id', $request->post('ids'))
            ->pluck('id')
            ->toArray();
    
        VideoServers::destroy($movie_ids);
        
        return response()->json([
            'status' => 'success',
            'message' => trans('movie::app.saved_successfully'),
            'redirect' => route('admin.movies.servers', [$page_type, $movie_id]),
        ]);
    }
}
