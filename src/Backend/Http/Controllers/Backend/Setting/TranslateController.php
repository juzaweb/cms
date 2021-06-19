<?php

namespace Mymo\Backend\Http\Controllers\Backend\Setting;

use Mymo\Core\Models\Languages;
use Mymo\Core\Models\Translation;
use Illuminate\Http\Request;
use Mymo\Backend\Http\Controllers\BackendController;

class TranslateController extends BackendController
{
    public function index($lang) {
        Languages::where('key', '=', $lang)->firstOrFail();
        
        return view('mymo_core::backend.setting.translate.index', [
            'title' => trans('mymo_core::app.translations'),
            'lang' => $lang
        ]);
    }
    
    public function getData($lang, Request $request) {
        $search = $request->get('search');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Translation::query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search, $lang) {
                $subquery->orWhere('key', 'like', '%'. $search .'%');
                $subquery->orWhere('en', 'like', '%'. $search .'%');
                $subquery->orWhere($lang, 'like', '%'. $search .'%');
            });
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save($lang, Request $request) {
        $this->validateRequest([
            'key' => 'required|string|exists:translation,key',
            'value' => 'required|max:250',
        ], $request, [
            'key' => trans('mymo_core::app.key'),
            'value' => trans('mymo_core::app.translate'),
        ]);
        
        $model = Translation::firstOrNew(['key' => $request->post('key')]);
        $model->setAttribute($lang, $request->post('value'));
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.saved_successfully'),
        ]);
    }
}
