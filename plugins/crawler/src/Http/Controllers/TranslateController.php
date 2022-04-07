<?php

namespace Juzaweb\Crawler\Http\Controllers;

use Juzaweb\Crawler\Models\CrawContent;
use Illuminate\Database\Schema\Builder;
use Juzaweb\Crawler\Models\CrawTranslate;
use Illuminate\Http\Request;
use Juzaweb\CMS\Http\Controllers\BackendController;

class TranslateController extends BackendController
{
    public function index($content_id) {
        $content = CrawContent::findOrFail($content_id);
        
        return view('backend.leech.translate.index', [
            'content' => $content,
            'title' => 'Leech Translate'
        ]);
    }
    
    public function form($content_id, $id = null) {
        $model = CrawTranslate::firstOrNew(['id' => $id]);
        
        return view('backend.leech.translate.form', [
            'model' => $model,
            'content_id' => $content_id,
        ]);
    }
    
    public function save(Request $request) {
        $this->validate($request, [
            'ids' => 'required',
        ]);
        
        
        
        return $this->success([
            'message' => 'Saved successful.',
        ], true);
    }
    
    public function getData($content_id, Request $request) {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 20);
        
        $search = $request->input('search');
        $status = $request->input('status');
        
        $query = CrawTranslate::query();
        $query->with(['post', 'content', 'language']);
        $query->where('content_id', '=', $content_id);
        
        if ($search) {
            $query->where(function (Builder $builder) use ($search) {
                $builder->where('url', 'ilike', '%'. $search .'%');
                $builder->orWhere('error', 'ilike', '%'. $search .'%');
            });
        }
        
        if (!is_null($status)) {
            $query->where('status', '=', $status);
        }
        
        $count = $query->count();
        $query->orderBy('status', 'ASC');
        
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            //$row->edit_url = route('backend.leech.translate.edit', [$row->id]);
            $row->post_title = $row->post->title;
            $row->lang_name = $row->language->name;
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function publish(Request $request) {
        $this->validate($request, [
            'ids' => 'required',
        ]);
        
        $ids = $request->input('ids');
        $status = $request->input('status');
        
        CrawTranslate::whereIn('id', $ids)
            ->update([
                'status' => $status,
            ]);
        
        return $this->success([
            'message' => 'Saved successful.',
        ], true);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request);
        
        $ids = $request->input('ids', []);
        
        CrawTranslate::whereIn('id', $ids)
            ->delete();
        
        return $this->success([
            'message' => 'Deleted successful.',
        ], true);
    }
    
    public function retranslate(Request $request) {
        $this->validate($request, [
            'id' => 'required',
        ]);
        
        $model = CrawTranslate::find($request->post('id'));
        $model->update([
            'status' => 3,
        ]);
    
        return $this->success('Successfull.', true);
    }
}
