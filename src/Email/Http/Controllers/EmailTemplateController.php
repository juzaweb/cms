<?php

namespace Mymo\Email\Http\Controllers;

use Illuminate\Http\Request;
use Mymo\Backend\Http\Controllers\BackendController;
use Mymo\Core\Traits\ResourceController;
use Mymo\Email\Models\EmailTemplate;
use Illuminate\Support\Facades\Validator;

class EmailTemplateController extends BackendController
{
    use ResourceController;

    protected $viewPrefix = 'emailtemplate::email_template';
    
    public function getDataTable(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
    
        $query = EmailTemplate::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->orWhere('code', 'like', '%'. $search .'%');
                $q->orWhere('subject', 'like', '%'. $search .'%');
            });
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();

        foreach ($rows as $row) {
            $row->edit_url = route('admin.email-template.edit', [$row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function bulkActions(Request $request) {
        $request->validate([
            'ids' => 'required',
        ], [], [
            'ids' => trans('mymo_core::app.email_templates')
        ]);
        
        $ids = $request->post('ids');
        $action = $request->post('action');
        
        switch ($action) {
            case 'delete':
                EmailTemplate::destroy($ids);
                break;
        }
        
        return $this->success([
            'message' => trans('mymo_core::app.successfully')
        ]);
    }

    protected function validator(array $attributes)
    {
        $validator = Validator::make([
            'code' => 'required|unique:id,' . $attributes['id'],
            'subject' => 'required',
        ]);

        return $validator;
    }

    protected function getModel()
    {
        return EmailTemplate::class;
    }

    protected function getTitle()
    {
        return trans('mymo_core::app.email_templates');
    }
}
