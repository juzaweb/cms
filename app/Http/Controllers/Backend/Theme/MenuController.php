<?php

namespace App\Http\Controllers\Backend\Theme;

use App\Models\Genres;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function index($id = null) {
        if (empty($id)) {
            $menu = Menu::first();
            if ($menu) {
                return redirect()->route('admin.theme.menu.id', $menu->id);
            }
        }
        
        $menu = Menu::where('id', '=', $id)->first();
        $genres = Genres::where('status', '=', 1)
            ->get(['id', 'name']);
        
        return view('backend.theme.menu.index', [
            'menu' => $menu,
            'genres' => $genres,
        ]);
    }
    
    public function addMenu(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250',
        ], $request, [
            'name' => trans('app.name')
        ]);
    
        $model = Menu::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->save();
    
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250',
        ], $request, [
            'name' => trans('app.name')
        ]);
        
        $model = Menu::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->save();
    
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.theme.menu'),
        ]);
    }
}
