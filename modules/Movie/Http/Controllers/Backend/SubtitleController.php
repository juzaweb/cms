<?php

namespace Modules\Movie\Http\Controllers\Backend;

use App\Core\Models\Movie\Movies;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Models\Video\VideoFiles;
use App\Core\Models\Subtitle;

class SubtitleController extends Controller
{
    public function index($page_type, $file_id) {
        $file = VideoFiles::findOrFail($file_id);
        $movie = Movies::findOrFail($file->server->movie_id);
        
        return view('backend.movie_upload.subtitle.index', [
            'page_type' => $page_type,
            'file' => $file,
            'file_id' => $file_id,
            'movie' => $movie,
        ]);
    }
    
    public function form($page_type, $file_id, $id = null) {
        $file = VideoFiles::findOrFail($file_id);
        $movie = Movies::findOrFail($file->server->movie_id);
        
        $model = Subtitle::firstOrNew(['id' => $id]);
        return view('backend.movie_upload.subtitle.form', [
            'model' => $model,
            'page_type' => $page_type,
            'file' => $file,
            'file_id' => $file_id,
            'movie' => $movie,
            'title' => $model->label ? $model->label : trans('app.add_new')
        ]);
    }
    
    public function getData($page_type, $file_id, Request $request) {
        VideoFiles::findOrFail($file_id);
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Subtitle::query();
        $query->where('file_id', '=', $file_id);
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('label', 'like', '%'. $search .'%');
                $subquery->orWhere('url', 'like', '%'. $search .'%');
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
            $row->edit_url = route('admin.movies.servers.upload.subtitle.edit', [$page_type, $file_id, $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save($page_type, $file_id, Request $request) {
        $file = VideoFiles::findOrFail($file_id);
        
        $this->validateRequest([
            'label' => 'required|string|max:250',
            'url' => 'required|string|max:300',
            'order' => 'required|numeric|max:300',
            'status' => 'required|in:0,1',
        ], $request, [
            'label' => trans('app.label'),
            'url' => trans('app.url'),
            'order' => trans('app.order'),
            'status' => trans('app.status'),
        ]);
        
        $model = Subtitle::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->file_id = $file_id;
        $model->movie_id = $file->movie_id;
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.movies.servers.upload.subtitle', [$page_type, $file_id]),
        ]);
    }
    
    public function remove($page_type, $file_id, Request $request) {
        VideoFiles::findOrFail($file_id);
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.subtitle')
        ]);
        
        Subtitle::destroy($request->post('ids'));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
        ]);
    }
}
