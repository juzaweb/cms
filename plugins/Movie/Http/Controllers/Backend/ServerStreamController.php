<?php

namespace Plugins\Movie\Http\Controllers\Backend;

use Mymo\Core\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use Plugins\Movie\Models\ServerStream;

class ServerStreamController extends BackendController
{
    public function index() {
        return view('movie::server-stream.index');
    }
    
    public function form($id = null) {
        $model = ServerStream::firstOrNew(['id' => $id]);
        return view('movie::server-stream.form', [
            'model' => $model,
            'title' => $model->name ?: trans('movie::app.add_new')
        ]);
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = ServerStream::query();
        
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
            $row->edit_url = route('admin.server-stream.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'key' => 'required|string|max:32|unique:server_streams,key,'. $request->post('id'),
            'name' => 'required|string|max:250',
            'base_url' => 'required|string|max:250',
            'priority' => 'required|integer',
            'status' => 'required|in:0,1',
        ], $request, [
            'key' => trans('movie::app.key'),
            'name' => trans('movie::app.name'),
            'base_url' => trans('movie::app.base_url'),
            'priority' => trans('movie::app.priority'),
            'status' => trans('movie::app.status'),
        ]);
        
        $id = $request->post('id');
        
        $model = ServerStream::firstOrNew(['id' => $id]);
        $model->fill($request->all());
        $model->save();
        
        return $this->success([
            'message' => trans('movie::app.saved_successfully'),
            'redirect' => route('admin.server-stream'),
        ]);
    }
    
    public function publish(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
            'status' => 'required|in:0,1',
        ], $request, [
            'ids' => trans('movie::app.server_stream'),
            'status' => trans('movie::app.status'),
        ]);
        
        $ids = $request->post('ids');
        $status = $request->post('status');
        
        ServerStream::whereIn('id', $ids)
            ->update([
                'status' => $status,
            ]);
        
        return $this->success([
            'message' => trans('movie::app.updated_successfully'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('movie::app.server_stream')
        ]);
        
        $ids = $request->post('ids');
        ServerStream::destroy($ids);
        
        return $this->success([
            'message' => trans('movie::app.deleted_successfully'),
        ]);
    }
}
