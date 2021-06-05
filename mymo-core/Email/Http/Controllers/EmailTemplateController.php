<?php

namespace Mymo\Email\Http\Controllers;

use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;
use Mymo\Email\Models\EmailTemplate;

class EmailTemplateController extends BackendController
{
    public function index()
    {
        return view('emailtemplate::email_template.index', [
            'title' => trans('mymo_core::app.email-template')
        ]);
    }
    
    public function getDataTable(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
    
        $query = EmailTemplate::query();
        
        
        if ($search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->orWhere('name', 'like', '%'. $search .'%');
                $subQuery->orWhere('subject', 'like', '%'. $search .'%');
            });
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function bulkActions(Request $request) {
        $request->validate([
            'ids' => 'required',
        ], [], [
            'ids' => trans('mymo_core::validation.attributes.email_templates')
        ]);
        
        $ids = $request->post('ids');
        $action = $request->post('action');
        
        switch ($action) {
            case 'delete':
                EmailTemplate::whereIn('id', $ids)
                    ->delete();
                break;
        }
        
        return $this->success(
            trans('mymo_core::app.successfully')
        );
    }
}
