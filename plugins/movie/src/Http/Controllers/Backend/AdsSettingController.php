<?php

namespace Juzaweb\Movie\Http\Controllers\Backend;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Movie\Models\Ads;

class AdsSettingController extends BackendController
{
    public function index()
    {
        return view('mymo::setting.ads.index', [
            'title' => trans('mymo::app.banner_ads')
        ]);
    }
    
    public function getData(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Ads::query();
        
        if ($search) {
            $query->where(function (Builder $q) use ($search) {
                $q->orWhere('key', 'like', '%'. $search .'%');
                $q->orWhere('name', 'like', '%'. $search .'%');
            });
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->edit_url = route('admin.setting.ads.edit', [
                'id' => $row->id
            ]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null)
    {
        $model = Ads::firstOrNew(['id' => $id]);
        return view('mymo::setting.ads.form', [
            'model' => $model,
            'title' => $model->name ?: trans('mymo_core::app.add_new')
        ]);
    }
    
    public function save(Request $request)
    {
        $this->validate($request, [
            'body' => 'nullable',
            'status' => 'required|in:0,1',
        ], [
            'body' => trans('mymo::app.content'),
            'status' => trans('mymo::app.status'),
        ]);
        
        $model = Ads::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->save();
        
        return $this->success([
            'message' => trans('cms::app.saved_successfully'),
            'redirect' => route('admin.setting.ads.index'),
        ]);
    }
}
