<?php

namespace Mymo\Core\Http\Controllers\Backend\Design;

use Mymo\Core\Models\Menu;
use Mymo\PostType\Models\Page;
use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;
use Mymo\PostType\Models\Taxonomy;

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
        $genres = Taxonomy::where('taxonomy', '=', 'genres')
            ->get(['id', 'name']);
        $countries = Taxonomy::where('taxonomy', '=', 'countries')
            ->get(['id', 'name']);
        $pages = Page::where('status', '=', 1)
            ->get(['id', 'name']);
        
        return view('mymo_core::backend.design.menu.index', [
            'title' => trans('mymo_core::app.menu'),
            'menu' => $menu,
            'pages' => $pages,
            'genres' => $genres,
            'countries' => $countries,
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
        $request->validate([
            'name' => 'required|string|max:250',
            'content' => 'required',
        ], [], [
            'name' => trans('mymo_core::app.name'),
            'content' => trans('mymo_core::app.menu'),
        ]);
        
        $model = Menu::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->save();
    
        return $this->success([
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
            case 'genre':
                $items = Taxonomy::where('taxonomy', '=', 'genres')
                    ->whereIn('id', $items)
                    ->get(['id', 'name', 'slug']);
                $result = [];
                
                foreach ($items as $item) {
                    $result[] = [
                        'name' => $item->name,
                        'url' => route('genre', [$item->slug]),
                        'object_id' => $item->id,
                    ];
                }
                
                return response()->json($result);
            case 'country';
                $items = Taxonomy::where('taxonomy', '=', 'countries')
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
            case 'page':
                $items = Page::whereIn('id', $items)
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
        
        return $this->error([
            'message' => ''
        ]);
    }
}
