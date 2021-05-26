<?php

namespace Mymo\Core\Http\Controllers\Backend\Setting;

use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\Controller;
use Mymo\Core\Models\Video\VideoAds;

class VideoAdsController extends Controller
{
    public function index() {
        return view('backend.setting.video_ads.index');
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = VideoAds::query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
                $subquery->orWhere('title', 'like', '%'. $search .'%');
                $subquery->orWhere('url', 'like', '%'. $search .'%');
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
            $row->created = $row->created_at->format('H:i Y-m-d');
            $row->edit_url = route('admin.setting.video_ads.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null) {
        $model = VideoAds::firstOrNew(['id' => $id]);
        return view('backend.setting.video_ads.form', [
            'model' => $model,
            'title' => $model->name ?: trans('app.add_new')
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250',
            'title' => 'required|string|max:250',
            'url' => 'required|string|max:250',
            'video_url' => 'required|string|max:250',
            'description' => 'nullable|string|max:300',
            'status' => 'required|in:0,1',
        ], $request, [
            'name' => trans('app.name'),
            'title' => trans('app.title'),
            'url' => trans('app.url'),
            'video_url' => trans('app.video_url'),
            'description' => trans('app.description'),
            'status' => trans('app.status'),
        ]);
        
        $model = VideoAds::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.setting.video_ads'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.video_ads')
        ]);
        
        VideoAds::destroy($request->post('ids'));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
        ]);
    }
}
