<?php

namespace Juzaweb\Movie\Http\Controllers\Backend\LiveTV;

use Illuminate\Http\Request;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Movie\Models\LiveTV\LiveTvCategory;

class LiveTvCategoryController extends BackendController
{
    public function index() {
        return view('mymo::live-tv-category.index');
    }
    
    public function form($id = null) {
        $model = LiveTvCategory::firstOrNew(['id' => $id]);
        return view('mymo::live-tv-category.form', [
            'model' => $model,
            'title' => $model->name ?: trans('mymo::app.add_new')
        ]);
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = LiveTvCategory::query();
        
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
            $row->edit_url = route('admin.live-tv.category.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250|unique:live_tv_categories,name,' . $request->post('id'),
            'description' => 'nullable|string|max:300',
            'status' => 'required|in:0,1',
            'thumbnail' => 'nullable|string|max:250',
        ], $request, [
            'name' => trans('mymo::app.name'),
            'description' => trans('mymo::app.description'),
            'status' => trans('mymo::app.status'),
            'thumbnail' => trans('mymo::app.thumbnail'),
        ]);
    
        $id = $request->post('id');
        $addtype = $request->post('addtype');
        
        $model = LiveTvCategory::firstOrNew(['id' => $id]);
        $model->fill($request->all());
        $model->save();
        
        if ($addtype == 2) {
            return response()->json($model->toArray());
        }
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo::app.saved_successfully'),
            'redirect' => route('admin.live-tv.category'),
        ]);
    }
    
    public function publish(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
            'status' => 'required',
        ], $request, [
            'ids' => trans('mymo::app.live_tv_categories'),
            'status' => trans('mymo::app.status'),
        ]);
        
        $ids = $request->post('ids');
        $status = $request->post('status');
    
        LiveTvCategory::whereIn('id', $ids)
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
            'ids' => trans('mymo::app.live_tv_categories')
        ]);
    
        $ids = $request->post('ids');
        LiveTvCategory::destroy($ids);
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo::app.deleted_successfully'),
        ]);
    }
}
