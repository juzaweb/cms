<?php

namespace Mymo\PostType\Http\Controllers;

use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;
use Mymo\PostType\Models\Post;
use Mymo\PostType\Services\PostService;
use Mymo\PostType\PostType;
use Mymo\PostType\Repositories\PostRepository;

class PostController extends BackendController
{
    protected $setting;
    protected $postType = 'posts';
    protected $postRepository;
    protected $postService;

    public function __construct(
        PostRepository $postRepository,
        PostService $postService
    )
    {
        $this->setting = PostType::getSetting($this->postType);
        $this->postRepository = $postRepository;
        $this->postService = $postService;
        $this->init();
    }

    public function init()
    {
        if (empty($this->setting)) {
            throw new \Exception(
                'Post type ' . $this->postType . ' does not exists.'
            );
        }
    }

    public function index()
    {
        return view('mymo_core::backend.posts.index', [
            'title' => $this->setting->get('label')
        ]);
    }

    public function create()
    {
        $this->addBreadcrumb([
            'title' => $this->setting->get('label'),
            'url' => route("admin.posts.index"),
        ]);

        return view('mymo_core::backend.posts.form', [
            'title' => trans('mymo_core::app.add_new'),
        ]);
    }

    public function edit($id)
    {
        $this->addBreadcrumb([
            'title' => $this->setting->get('label'),
            'url' => route("admin.posts.index"),
        ]);

        $model = $this->postRepository->find($id);
        return view('mymo_core::backend.posts.form', [
            'title' => $model->title,
            'model' => $model,
        ]);
    }

    public function getDataTable(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Post::query();
        
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
            $row->created = $row->created_at->format('H:i Y-m-d');
            $row->edit_url = route('admin.posts.edit', [$row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function store(Request $request)
    {
        $this->postService->create($request->all());
        
        return $this->success([
            'message' => trans('mymo_core::app.saved_successfully')
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->postService->update($request->all(), $id);

        return $this->success([
            'message' => trans('mymo_core::app.saved_successfully')
        ]);
    }
    
    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'action' => 'required',
        ]);

        $action = $request->post('action');
        $ids = $request->post('ids');

        switch ($action) {
            case 'delete':
                $this->postService->delete($ids);
                break;
            case 'public':
            case 'private':
            case 'draft':
                foreach ($ids as $id) {
                    $this->postService->update([
                        'status' => $action
                    ], $id);
                }
                break;
        }

        return $this->success([
            'message' => trans('mymo_core::app.successfully')
        ]);
    }
}
