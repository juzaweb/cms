<?php

namespace Mymo\Core\Http\Controllers\Backend\Design;

use Mymo\Core\Models\Menu;
use Mymo\Core\Models\Pages;
use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;

class MenuController extends BackendController
{
    public function index($id = null)
    {
        if (empty($id)) {
            $menu = Menu::first();
            if ($menu) {
                return redirect()->route('admin.design.menu.id', $menu->id);
            }
        }
        
        $menu = Menu::where('id', '=', $id)->first();
        /*$genres = Genres::where('status', '=', 1)
            ->get(['id', 'name']);
        $countries = Countries::where('status', '=', 1)
            ->get(['id', 'name']);
        $types = Types::where('status', '=', 1)
            ->get(['id', 'name']);*/
        $pages = Pages::where('status', '=', 1)
            ->get(['id', 'name']);
        
        return view('mymo_core::backend.design.menu.index', [
            'menu' => $menu,
            'pages' => $pages,
            'title' => trans('mymo_core::app.menu')
        ]);
    }
    
    public function addMenu(Request $request)
    {
        $this->validateRequest([
            'name' => 'required|string|max:250',
        ], $request, [
            'name' => trans('mymo_core::app.name')
        ]);
    
        $model = Menu::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->save();
    
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.saved_successfully'),
            'redirect' => route('admin.design.menu.id', [$model->id]),
        ]);
    }
    
    public function save(Request $request)
    {
        $this->validateRequest([
            'name' => 'required|string|max:250',
            'content' => 'required',
        ], $request, [
            'name' => trans('mymo_core::app.name'),
            'content' => trans('mymo_core::app.menu'),
        ]);
        
        $model = Menu::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->save();
    
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.saved_successfully'),
            'redirect' => route('admin.design.menu.id', [$model->id]),
        ]);
    }
    
    public function getItems(Request $request)
    {
        $this->validateRequest([
            'type' => 'required',
        ], $request, [
            'type' => trans('mymo_core::app.type')
        ]);
        
        $type = $request->post('type');
        $items = $request->post('items');
        
        switch ($type) {
            /*case 'genre':
                $items = Genres::where('status', '=', 1)
                    ->whereIn('id', $items)
                    ->get(['id', 'name', 'slug']);
                $result = [];
                
                foreach ($items as $item) {
                    $url = parse_url(route('genre', [$item->slug]))['path'];
                    $result[] = [
                        'name' => $item->name,
                        'url' => route('genre', [$item->slug]),
                        'object_id' => $item->id,
                    ];
                }
                
                return response()->json($result);
            case 'country';
                $items = Countries::where('status', '=', 1)
                    ->whereIn('id', $items)
                    ->get(['id', 'name', 'slug']);
                $result = [];
    
                foreach ($items as $item) {
                    $url = parse_url(route('country', [$item->slug]))['path'];
                    $result[] = [
                        'name' => $item->name,
                        'url' => $url,
                        'object_id' => $item->id,
                    ];
                }
    
                return response()->json($result);
            case 'type':
                $items = Types::where('status', '=', 1)
                    ->whereIn('id', $items)
                    ->get(['id', 'name', 'slug']);
                $result = [];
    
                foreach ($items as $item) {
                    $url = parse_url(route('type', [$item->slug]))['path'];
                    $result[] = [
                        'name' => $item->name,
                        'url' => $url,
                        'object_id' => $item->id,
                    ];
                }
    
                return response()->json($result);*/
            case 'page':
                $items = Pages::whereIn('id', $items)
                    ->get(['id', 'name', 'slug']);
                $result = [];
                
                foreach ($items as $item) {
                    $url = parse_url(route('page', [$item->slug]))['path'];
                    $result[] = [
                        'name' => $item->name,
                        'url' => $url,
                        'object_id' => $item->id,
                    ];
                }
        
                return response()->json($result);
        }
        
        return response()->json([
            'status' => 'error',
            'message' => ''
        ]);
    }
}
