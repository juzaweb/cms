<?php

namespace Mymo\Backend\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mymo\Backend\Http\Controllers\BackendController;
use Mymo\Core\Traits\ResourceController;
use Mymo\PostType\Models\Comment;

class CommentController extends BackendController
{
    use ResourceController;

    protected $viewPrefix = 'mymo::backend.comment';

    protected function validator(array $attributes)
    {
        $validator = Validator::make($attributes, [
            'email' => 'required|email',
            'name' => 'nullable',
            'website' => 'nullable',
            'content' => 'required',
            'status' => 'required|in:approved,deny,pending,trash',
        ]);

        return $validator;
    }

    protected function getModel()
    {
        return Comment::class;
    }

    protected function getTitle()
    {
        return trans('mymo::app.comments');
    }
    
    public function getDataTable(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Comment::query()->with(['user', 'postType']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->orWhere('name', 'like', '%'. $search .'%');
                $q->orWhere('content', 'like', '%'. $search .'%');
            });
        }
        
        if ($status) {
            $query->where('status', '=', $status);
        }

        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->post = $row->postType->getDisplayName();
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
}
