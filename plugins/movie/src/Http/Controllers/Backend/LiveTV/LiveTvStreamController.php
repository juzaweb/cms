<?php

namespace Juzaweb\Movie\Http\Controllers\Backend\LiveTV;

use Illuminate\Http\Request;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Movie\Models\LiveTV\LiveTv;
use Juzaweb\Movie\Models\LiveTV\LiveTvStream;

class LiveTvStreamController extends BackendController
{
    public function index($live_tv_id) {
        $live_tv = LiveTv::findOrFail($live_tv_id);
        return view('mymo::live-tv-stream.index', [
            'live_tv' => $live_tv
        ]);
    }
    
    public function form($live_tv_id, $id = null) {
        $live_tv = LiveTv::findOrFail($live_tv_id);
        $model = LiveTvStream::firstOrNew(['id' => $id]);
        return view('mymo::live-tv-stream.form', [
            'title' => $model->label ?? trans('mymo::app.add_new'),
            'model' => $model,
            'live_tv' => $live_tv
        ]);
    }
    
    public function getData($live_tv_id, Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = LiveTvStream::query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
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
            $row->edit_url = route('admin.live-tv.stream.edit', [$live_tv_id, $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save($live_tv_id, Request $request) {
        $this->validateRequest([
            'label' => 'required|string|max:250|unique:live_tv_streams,label,' . $request->post('id'),
            'status' => 'required|in:0,1',
        ], $request, [
            'label' => trans('mymo::app.label'),
            'status' => trans('mymo::app.status'),
        ]);
        
        $model = LiveTvStream::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->live_tv_id = $live_tv_id;
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo::app.saved_successfully'),
            'redirect' => route('admin.live-tv.stream', [$live_tv_id]),
        ]);
    }
    
    public function remove($live_tv_id, Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('mymo::app.genres')
        ]);
    
        LiveTv::findOrFail($live_tv_id);
        
        LiveTvStream::destroy($request->post('ids'));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo::app.deleted_successfully'),
        ]);
    }
}
