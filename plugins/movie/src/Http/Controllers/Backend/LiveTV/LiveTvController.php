<?php

namespace Juzaweb\Movie\Http\Controllers\Backend\LiveTV;

use Illuminate\Http\Request;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Movie\Models\LiveTV\LiveTv;
use Juzaweb\Movie\Models\Category\Tags;

class LiveTvController extends BackendController
{
    public function index() {
        return view('mymo::live-tv.index');
    }
    
    public function form($id = null) {
        $model = LiveTv::firstOrNew(['id' => $id]);
        $tags = Tags::whereIn('id', explode(',', $model->tags))->get(['id', 'name']);
        
        return view('mymo::live-tv.form', [
            'model' => $model,
            'tags' => $tags,
            'title' => $model->name ?: trans('mymo::app.add_new'),
        ]);
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = LiveTv::query();
        
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
            $row->edit_url = route('admin.live-tv.edit', [$row->id]);
            //$row->preview_url = route('watch', [$row->slug]);
            $row->stream_url = route('admin.live-tv.stream', [$row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250',
            'description' => 'nullable',
            'status' => 'required|in:0,1',
            'thumbnail' => 'nullable|string|max:250',
            'category_id' => 'nullable|exists:live_tv_categories,id',
        ], $request, [
            'name' => trans('mymo::app.name'),
            'description' => trans('mymo::app.description'),
            'status' => trans('mymo::app.status'),
            'thumbnail' => trans('mymo::app.thumbnail'),
            'category_id' => trans('mymo::app.category'),
        ]);
    
        $tags = $request->post('tags', []);
        $tags = implode(',', $tags);
        
        $model = LiveTv::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->setAttribute('tags', $tags);
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo::app.saved_successfully'),
            'redirect' => route('admin.movies'),
        ]);
    }
    
    public function publish(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
            'status' => 'required',
        ], $request, [
            'ids' => trans('mymo::app.live_tv'),
            'status' => trans('mymo::app.status'),
        ]);
    
        $ids = $request->post('ids');
        $status = $request->post('status');
        
        LiveTv::whereIn('id', $ids)
            ->update([
                'status' => $status,
            ]);
    
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo::app.updated_successfully'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('mymo::app.live_tv')
        ]);
    
        $ids = $request->post('ids');
        LiveTv::destroy($ids);
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo::app.deleted_successfully'),
        ]);
    }
}
