<?php

namespace Mymo\Core\Http\Controllers\Backend\Setting;

use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;
use Plugins\Movie\Models\Ads;

class AdsSettingController extends BackendController
{
    public function index() {
        return view('mymo_core::movie::setting.ads.index');
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
        return view('mymo_core::movie::setting.ads.form', [
            'model' => $model,
            'title' => $model->name ?: trans('mymo_core::app.add_new')
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'body' => 'nullable',
            'status' => 'required|in:0,1',
        ], $request, [
            'body' => trans('mymo_core::app.content'),
            'status' => trans('mymo_core::app.status'),
        ]);
        
        $model = Ads::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.saved_successfully'),
            'redirect' => route('admin.setting.ads'),
        ]);
    }
}
