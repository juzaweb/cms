<?php

namespace Mymo\Core\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;
use Mymo\Core\Traits\ArrayPagination;
use Mymo\Module\Facades\Module;

class ModuleController extends BackendController
{
    use ArrayPagination;
    
    public function index()
    {
        return view('mymo_core::backend.module.index', [
            'title' => trans('mymo_core::app.modules'),
        ]);
    }
    
    public function getDataTable(Request $request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $results = [];
        $plugins = Module::all();
        foreach ($plugins as $plugin) {
            $item = [
                'id' => $plugin->get('name'),
                'name' => $plugin->getDisplayName(),
                'description' => $plugin->get('description'),
                'status' => $plugin->isEnabled() ?
                    'active' : 'inactive',
            ];
            $results[] = $item;
        }
        
        $total = count($results);
        $page = $offset <= 0 ? 1 : (round($offset / $limit));
        $data = $this->arrayPaginate($results, $limit, $page);
        
        return response()->json([
            'total' => $total,
            'rows' => $data->items(),
        ]);
    }
    
    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required',
        ], [], [
            'ids' => trans('tadcms::app.plugins')
        ]);
        
        $action = $request->post('action');
        $ids = $request->post('ids');
        foreach ($ids as $plugin) {
            switch ($action) {
                case 'delete':
                    Module::delete($plugin);
                    break;
                case 'activate':
                    Module::enable($plugin);
                    break;
                case 'deactivate':
                    Module::disable($plugin);
                    break;
            }
        }
        
        return $this->success(trans('mymo_core::app.successfully'));
    }
}
