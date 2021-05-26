<?php

namespace Mymo\Core\Http\Controllers\Backend\Setting;

use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\Controller;
use Mymo\Core\Models\Email\EmailTemplates;

class EmailTemplateController extends Controller
{
    public function index() {
        return view('backend.setting.email_templates.index');
    }
    
    public function form($id = null) {
        $model = EmailTemplates::findOrFail($id);
        return view('backend.setting.email_templates.form', [
            'model' => $model,
            'title' => $model->subject ?: trans('app.add_new')
        ]);
    }
    
    public function editLayout() {
        $code = file_get_contents($this->getPathEmailLayout());
        $model = new \stdClass();
        $model->title = trans('app.edit_layout');
        $model->code = $code;
        return view('backend.setting.email_templates.edit_layout', [
            'model' => $model
        ]);
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = EmailTemplates::query();
        $query->select([
            'id',
            'code',
            'subject',
            'content',
        ]);
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('code', 'like', '%'. $search .'%');
                $subquery->orWhere('subject', 'like', '%'. $search .'%');
            });
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->edit_url = route('admin.setting.email_templates.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'subject' => 'required|string|max:300',
        ], $request, [
            'subject' => trans('app.name'),
        ]);
        
        $model = EmailTemplates::findOrFail($request->post('id'));
        $model->fill($request->all());
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.setting.email_templates'),
        ]);
    }
    
    public function saveLayout(Request $request) {
        $this->validateRequest([
            'content' => 'required',
        ], $request);
        
        file_put_contents($this->getPathEmailLayout(), $request->post('content'));
    
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.setting.email_templates.edit_layout'),
        ]);
    }
    
    private function getPathEmailLayout() {
        return resource_path() . '/views/emails/layout.blade.php';
    }
}
