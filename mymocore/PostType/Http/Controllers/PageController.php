<?php

namespace Mymo\PostType\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mymo\Core\Http\Controllers\BackendController;
use Mymo\PostType\Models\Page;

class PageController extends BackendController
{
    public function index()
    {
        return view('mymo_core::backend.pages.index', [
            'title' => trans('mymo_core::app.pages')
        ]);
    }
    
    public function getData(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Page::query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
                $subquery->orWhere('description', 'like', '%'. $search .'%');
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
            $row->thumb_url = $row->getThumbnail();
            $row->edit_url = route('admin.page.edit', [$row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null)
    {
        $this->addBreadcrumb([
            'title' => trans('mymo_core::app.pages'),
            'url' => route('admin.page.index')
        ]);

        $model = Page::firstOrNew(['id' => $id]);
        return view('mymo_core::backend.pages.form', [
            'model' => $model,
            'title' => $model->name ?: trans('mymo_core::app.add_new')
        ]);
    }
    
    public function save(Request $request)
    {
        $this->validateRequest([
            'name' => 'required|string|max:250|unique:pages,name',
            'status' => 'required|in:0,1',
            'thumbnail' => 'nullable|string|max:250',
        ], $request, [
            'name' => trans('mymo_core::app.name'),
            'status' => trans('mymo_core::app.status'),
            'thumbnail' => trans('mymo_core::app.thumbnail'),
        ]);
        
        $model = Page::firstOrNew(['id' => $request->id]);
        $model->fill($request->all());
        $model->save();

        return $this->success([
            'message' => trans('mymo_core::app.successfully')
        ]);
    }
    
    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required',
            'action' => 'required',
        ], [], [
            'ids' => trans('mymo_core::app.pages')
        ]);

        $ids = $request->post('ids');
        $action = $request->post('action');

        try {
            DB::beginTransaction();
            switch ($action) {
                case 'delete':
                    Page::destroy($ids);
                    break;
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->error([
                'message' => $exception->getMessage()
            ]);
        }

        return $this->success([
            'message' => trans('mymo_core::app.successfully')
        ]);
    }
}
