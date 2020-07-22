<?php

namespace App\Http\Controllers\Backend\Design;

use App\Models\Sliders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlidersController extends Controller
{
    public function index() {
        return view('backend.design.sliders.index');
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Sliders::query();
        
        if ($search) {
            $query->where('name', 'like', '%'. $search .'%');
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
            $row->edit_url = route('admin.design.sliders.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null) {
        $model = Sliders::firstOrNew(['id' => $id]);
        return view('backend.design.sliders.form', [
            'model' => $model,
            'title' => $model->name ?: trans('app.add_new')
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250',
        ], $request, [
            'name' => trans('app.name'),
        ]);
    
        $model = Sliders::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
    
        $titles = $request->post('title');
        $links = $request->post('link');
        $images = $request->post('image');
        $descriptions = $request->post('description');
    
        if (empty($titles)) {
            return response()->json([
                'status' => 'error',
                'message' => trans('validation.required', [
                    'attribute' => trans('app.banners')
                ])
            ]);
        }
    
        $content = [];
        foreach ($titles as $key => $title) {
            $content[] = [
                'title' => $title,
                'link' => $links[$key],
                'image' => $images[$key],
                'description' => $descriptions[$key],
            ];
        }
    
        $model->content = json_encode($content);
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.design.sliders'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.design.sliders')
        ]);
        
        Sliders::destroy($request->post('ids'));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
        ]);
    }
}
