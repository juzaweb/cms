<?php

namespace Mymo\Backend\Http\Controllers\Backend\Design;

use Mymo\Backend\Http\Controllers\BackendController;
use Mymo\Core\Models\Menu;
use Mymo\PostType\Models\Page;
use Illuminate\Http\Request;
use Mymo\PostType\Models\Taxonomy;
use Mymo\PostType\PostType;

class MenuController extends BackendController
{
    public function index($id = null)
    {
        if (empty($id)) {
            if ($menu = Menu::first()) {
                return redirect()->route('admin.design.menu.id', $menu->id);
            }
        }
        
        $menu = Menu::where('id', '=', $id)->first();
        $postTypes = PostType::getPostTypes();
        
        return view('mymo_core::backend.design.menu.index', [
            'title' => trans('mymo_core::app.menu'),
            'menu' => $menu,
            'postTypes' => $postTypes,
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
        $request->validate([
            'type' => 'required',
        ], [], [
            'type' => trans('mymo_core::app.type')
        ]);
        
        $type = $request->post('type');
        $items = $request->post('items');
        
        switch ($type) {
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
