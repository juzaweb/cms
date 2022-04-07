<?php

namespace Juzaweb\Crawler\Http\Controllers;

use Juzaweb\Crawler\Models\CrawContent;
use Juzaweb\Crawler\Models\CrawTemplate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Juzaweb\CMS\Http\Controllers\BackendController;

class ContentController extends BackendController
{
    public function index($template_id)
    {
        $template = CrawTemplate::findOrFail($template_id);
        return view('backend.leech.content.index', [
            'template' => $template,
            'title' => 'Leech Content',
        ]);
    }
    
    public function form($id = null)
    {
        $model = CrawContent::firstOrNew(['id' => $id]);
        return view('backend.leech.content.form', [
            'model' => $model,
        ]);
    }
    
    public function save(Request $request)
    {
        $this->validate($request, [
            'ids' => 'required',
        ]);

        return $this->success([
            'message' => 'Saved successful.',
        ], true);
    }
    
    public function getData($template_id, Request $request)
    {
        $sort = $request->input('sort', 'name');
        $order = $request->input('order', 'desc');
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 20);
        
        $search = $request->input('search');
        $status = $request->input('status');
        
        $query = CrawContent::query();
        $query->with('template');
        $query->where('template_id', '=', $template_id);
        
        if ($search) {
            $query->where(function (Builder $builder) use ($search) {
                $builder->orWhere('url', 'like', '%'. $search .'%');
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
            //$row->edit_url = route('backend.leech.content.edit', [$row->id]);
            $row->component_data = json_decode($row->components);
            $row->translate_url = route('backend.leech.translate', [$row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function publish(Request $request)
    {
        $this->validate($request, [
            'ids' => 'required',
        ]);
        
        $ids = $request->input('ids');
        $status = $request->input('status');
        
        CrawContent::whereIn('id', $ids)
            ->update([
                'status' => $status,
            ]);
        
        return $this->success([
            'message' => 'Saved successful.',
        ], true);
    }
    
    public function remove(Request $request)
    {
        $this->validate($request, [
            'ids' => 'required',
        ]);
        
        $ids = $request->input('ids', []);
        
        CrawContent::whereIn('id', $ids)
            ->delete();
        
        return $this->success([
            'message' => 'Deleted successful.',
        ], true);
    }
    
    public function releech(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
    
        $content = CrawContent::find($request->post('id'));
        
        $content->update([
            'status' => 2,
        ]);
        
        $content->link()->update([
            'status' => 2,
        ]);
        
        return $this->success('Successfull.', true);
    }
}
