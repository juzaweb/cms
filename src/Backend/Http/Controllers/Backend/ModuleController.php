<?php

namespace Mymo\Backend\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mymo\Backend\Http\Controllers\BackendController;
use Mymo\Core\Traits\ArrayPagination;
use Mymo\Plugin\Facades\Plugin;

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
        $plugins = Plugin::all();
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
            try {
                DB::beginTransaction();
                switch ($action) {
                    case 'delete':
                        Plugin::delete($plugin);
                        break;
                    case 'activate':
                        Plugin::enable($plugin);
                        break;
                    case 'deactivate':
                        Plugin::disable($plugin);
                        break;
                }
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                return $this->error([
                    'message' => trans($e->getMessage())
                ]);
            }
        }
        
        return $this->success([
            'message' => trans('mymo_core::app.successfully'),
            'redirect' => route('admin.module')
        ]);
    }
}
