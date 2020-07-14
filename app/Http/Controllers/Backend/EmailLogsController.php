<?php

namespace App\Http\Controllers\Backend;

use App\Models\EmailList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailLogsController extends Controller
{
    public function index() {
        return view('backend.email_logs.index');
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
            $row->created = $row->created_at->format('H:i d/m/Y');
        }
    
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.email_logs')
        ]);
        
        EmailList::destroy($request->post('ids', []));
    
        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
        ]);
    }
}
