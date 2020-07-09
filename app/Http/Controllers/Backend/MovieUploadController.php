<?php

namespace App\Http\Controllers\Backend;

use App\Models\Movies;
use App\Models\Servers;
use App\Models\VideoFiles;
use Dilab\Network\SimpleRequest;
use Dilab\Network\SimpleResponse;
use Dilab\Resumable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovieUploadController extends Controller
{
    public function index($server_id) {
        $server = Servers::where('id', '=', $server_id)->firstOrFail();
        $movie = Movies::where('id', '=', $server->movie_id)->firstOrFail();
        
        return view('backend.movie_upload.index', [
            'id' => $server_id,
            'server' => $server,
            'movie' => $movie,
        ]);
    }
    
    public function getData($server_id, Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Servers::query();
        $query->where('movie_id', '=', $server_id);
        
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
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save($server_id, Request $request) {
        $this->validateRequest([
            'label' => 'required|string|max:250',
            'source' => 'required|string|max:100',
            'url' => 'required|max:250',
            'order' => 'required|numeric',
        ], $request, [
            'label' => trans('app.label'),
            'source' => trans('app.source'),
            'url' => trans('app.video_url'),
            'order' => trans('app.order'),
        ]);
        
        $model = VideoFiles::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->server_id = $server_id;
        $model->movie_id = $server_id;
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
        ]);
    }
    
    public function remove($server_id, Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.servers'),
        ]);
    
        VideoFiles::destroy($request->post('ids', []));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.movies.servers.upload', [
                'server_id' => $server_id
            ]),
        ]);
    }
    
    public function upload() {
        $request = new SimpleRequest();
        $response = new SimpleResponse();
    
        $resumable = new Resumable($request, $response);
        $extension = $resumable->getExtension();
    
        $originalName = $resumable->getOriginalFilename(Resumable::WITHOUT_EXTENSION);
        $slugifiedname = time().'_'.create_link($originalName);
        $resumable->setFilename($slugifiedname);
    
        $resumable->tempFolder = storage_path() . '/tmps';
        $resumable->uploadFolder = storage_path() . '/videos';
        $resumable->process();
    
        if ($resumable->isUploadComplete()) {
        
        }
    }
}
