<?php

namespace App\Http\Controllers\Backend\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VideoQualities;

class VideoQualityController extends Controller
{
    public function index() {
        return view('backend.setting.video_qualities.index');
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        
        $sort = $request->get('sort', 'aid');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = VideoQualities::query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
            });
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->created = $row->created_at->format('H:i d/m/Y');
            $row->edit_url = route('admin.video_qualities.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null) {
        $model = VideoQualities::firstOrNew(['id' => $id]);
        return view('backend.setting.video_qualities.form', [
            'model' => $model,
            'title' => $model->name ?: trans('app.add_new')
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250|unique:video_qualities,name',
            'default' => 'required|in:0,1',
        ], $request, [
            'name' => trans('app.name'),
            'default' => trans('app.default'),
        ]);
        
        $model = VideoQualities::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->save();
        
        if ($model->default == 1) {
            VideoQualities::where('id', '!=', $model->id)
                ->where('default', '=', 1)
                ->update([
                    'default' => 0
                ]);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.video_qualities'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.video_qualities')
        ]);
        
        VideoQualities::destroy($request->post('ids'));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
        ]);
    }
}
