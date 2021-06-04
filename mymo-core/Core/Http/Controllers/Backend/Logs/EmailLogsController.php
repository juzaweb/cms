<?php

namespace Mymo\Core\Http\Controllers\Backend\Logs;

use Illuminate\Http\Request;
use Mymo\Core\Models\Email\EmailList;
use Mymo\Core\Http\Controllers\BackendController;

class EmailLogsController extends BackendController
{
    public function index()
    {
        return view('mymo_core::backend.logs.email', [
            'title' => trans('mymo_core::app.email_logs'),
        ]);
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
    
        $query = EmailList::query();
    
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('subject', 'like', '%'. $search .'%');
                $subquery->orWhere('content', 'like', '%'. $search .'%');
            });
        }
    
        if (!is_null($status)) {
            $query->where('status', '=', $status);
        }
    
        $count = $query->count();
        $query->orderBy('updated_at', 'DESC');
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
    
        foreach ($rows as $row) {
            $row->created = $row->created_at->format('H:i Y-m-d');
        }
    
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function status(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
            'status' => 'required|in:2,3',
        ], $request, [
            'ids' => trans('mymo_core::app.email_logs'),
            'status' => trans('mymo_core::app.status'),
        ]);
        
        EmailList::whereIn('id', $request->post('ids'))
            ->update([
                'status' => $request->post('status')
            ]);
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.deleted_successfully'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('mymo_core::app.email_logs')
        ]);
        
        EmailList::destroy($request->post('ids', []));
    
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.deleted_successfully'),
        ]);
    }
}
