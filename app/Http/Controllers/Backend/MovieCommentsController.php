<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comments;

class MovieCommentsController extends Controller
{
    public function index() {
        return view('backend.movie_comments.index');
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        $approve = $request->get('approve');
        
        $sort = $request->get('sort', 'a.id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Comments::query();
        $query->select([
            'a.*',
            'b.name AS author',
            'c.name AS movie'
        ]);
        $query->from('comments AS a');
        $query->join('users AS b', 'b.id', '=', 'a.user_id');
        $query->join('movies AS c', 'c.id', '=', 'a.subject_id');
        $query->where('a.type', '=', 1);
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('b.name', 'like', '%'. $search .'%');
                $subquery->orWhere('a.content', 'like', '%'. $search .'%');
            });
        }
        
        if (!is_null($status)) {
            $query->where('a.status', '=', $status);
        }
    
        if (!is_null($approve)) {
            $query->where('a.approved', '=', $approve);
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
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
            'ids' => trans('app.movie_comments')
        ]);
        
        Comments::destroy($request->post('ids'));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
        ]);
    }
    
    public function publicis(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
            'status' => 'required|in:0,1,2,3',
        ], $request, [
            'ids' => trans('app.movie_comments'),
            'status' => trans('app.status'),
        ]);
    
        $status = $request->post('status');
        if (in_array($status, [0, 1])) {
            Comments::whereIn('id', $request->post('ids'))
                ->update([
                    'status' => $status,
                ]);
        }
        
        if (in_array($status, [2, 3])) {
            $status = $status == 2 ? 1 : 0;
            Comments::whereIn('id', $request->post('ids'))
                ->update([
                    'approved' => $status,
                ]);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.updated_status_successfully'),
        ]);
    }
}
