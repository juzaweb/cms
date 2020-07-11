<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Models\Translation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Languages;

class LanguagesController extends Controller
{
    public function index() {
        return view('backend.setting.languages.index');
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'a.id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Languages::query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
                $subquery->orWhere('key', 'like', '%'. $search .'%');
            });
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
            $row->created = $row->created_at->format('H:i d/m/Y');
            $row->tran_url = route('admin.translate', ['lang' => $row->key]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'key' => 'required|string|max:3|min:2|unique:languages,key',
            'name' => 'required|string|max:250|unique:languages,name',
        ], $request, [
            'key' => trans('app.key'),
            'name' => trans('app.name'),
        ]);
        
        $columns = \Schema::getColumnListing('translation');
        $model = Languages::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        
        if ($model->save()) {
            $src_path = resource_path() . '/lang/en';
            $dst_path = resource_path() . '/lang/' . $model->key;
            $this->recurseCopy($src_path, $dst_path);
            
            if (!in_array($model->key, $columns)) {
                \Schema::table('translation', function($table) use ($model) {
                    $table->integer($model->key);
                });
            }
        }
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.genres')
        ]);
        
        $ids = $request->post('ids');
        foreach ($ids as $id) {
            $lang = Languages::find($id);
            if ($lang->key == 'en') {
                continue;
            }
            
            Languages::destroy([$id]);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
        ]);
    }
    
    public function syncLanguage() {
        Translation::syncLanguage();
    
        return response()->json([
            'status' => 'success',
            'message' => trans('app.sync_successfully'),
        ]);
    }
    
    protected function recurseCopy($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurseCopy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}
