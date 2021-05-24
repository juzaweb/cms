<?php

namespace App\Core\Http\Controllers\Backend\Setting;

use Illuminate\Http\Request;
use App\Core\Http\Controllers\Controller;
use App\Core\Models\Ads;

class AdsSettingController extends Controller
{
    public function index() {
        return view('backend.setting.ads.index');
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Ads::query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('key', 'like', '%'. $search .'%');
                $subquery->orWhere('name', 'like', '%'. $search .'%');
            });
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->edit_url = route('admin.setting.ads.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null) {
        $model = Ads::firstOrNew(['id' => $id]);
        return view('backend.setting.ads.form', [
            'model' => $model,
            'title' => $model->name ?: trans('app.add_new')
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'body' => 'nullable',
            'status' => 'required|in:0,1',
        ], $request, [
            'body' => trans('app.content'),
            'status' => trans('app.status'),
        ]);
        
        $model = Ads::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.setting.ads'),
        ]);
    }
}
