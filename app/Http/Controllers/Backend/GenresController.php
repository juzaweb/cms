<?php

namespace App\Http\Controllers\Backend;

use App\Models\Genres;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenresController extends Controller
{
    public function index() {
        return view('backend.genres.index');
    }
    
    public function form($id = null) {
        return view('backend.genres.form');
    }
    
    public function save(Request $request) {
        $model = Genres::firstOrNew(['id' => $request->id]);
        $model->fill($request->all());
        $model->createSlug();
    
        if ($request->thumbnail) {
            $model->thumbnail = explode('storage', $request->thumbnail)[1];
        }
    
        $model->save();
        session()->flash('message', trans('app.save_successfully'));
        return redirect()->route('admin.genres');
    }
    
    public function delete() {
    
    }
}
