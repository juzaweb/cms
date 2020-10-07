<?php

namespace App\Http\Controllers\Backend\Movie;

use App\Models\Movie\Movies;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DownloadLink;

class DownloadController extends Controller
{
    public function index($file_id) {
        Movies::findOrFail($file_id);
        return view('backend.movie_upload.subtitle.index', [
            'file_id' => $file_id,
        ]);
    }
    
    public function form($file_id, $id = null) {
        Movies::findOrFail($file_id);
        $model = DownloadLink::firstOrNew(['id' => $id]);
        return view('backend.movie_upload.subtitle.form', [
            'model' => $model,
            'file_id' => $file_id,
            'title' => $model->label ?: trans('app.add_new')
        ]);
    }
    
    public function getData($file_id, Request $request) {
        Movies::findOrFail($file_id);
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = DownloadLink::query();
        
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
            $row->edit_url = route('admin.subtitle.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save($file_id, Request $request) {
        Movies::findOrFail($file_id);
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
        
        $model = DownloadLink::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.subtitle'),
        ]);
    }
    
    public function remove($file_id, Request $request) {
        Movies::findOrFail($file_id);
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.subtitle')
        ]);
        
        DownloadLink::destroy($request->post('ids'));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
        ]);
    }
}
