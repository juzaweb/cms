<?php

namespace Mymo\Core\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Mymo\Core\Models\PostCategories;
use Mymo\Core\Http\Controllers\BackendController;
use Mymo\Core\Models\Posts;
use Mymo\Core\Repositories\PostRepository;

class PostController extends BackendController
{
    protected $setting;
    protected $postType = 'posts';
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->setting = $this->getPostTypeSetting($this->postType);
        $this->postRepository = $postRepository;
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
            'url' => route("admin.{$this->postType}.index"),
        ]);

        return view('mymo_core::backend.posts.form', [
            'title' => trans('mymo_core::app.add_new'),
        ]);
    }

    public function edit($id)
    {
        $this->addBreadcrumb([
            'title' => $this->setting->get('label'),
            'url' => route("admin.{$this->postType}.index"),
        ]);

        $model = $this->postRepository->find($id);
        return view('mymo_core::backend.posts.form', [
            'title' => trans('mymo_core::app.add_new'),
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
        
        $query = Posts::query();
        
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
            $row->edit_url = route('admin.post.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function store(Request $request)
    {
        $this->validateRequest([
            'title' => 'required|string|max:250',
            'status' => 'required|in:0,1',
            'thumbnail' => 'nullable|string|max:250',
            'category' => 'nullable|string|max:200',
        ], $request, [
            'title' => trans('mymo_core::app.title'),
            'status' => trans('mymo_core::app.status'),
            'thumbnail' => trans('mymo_core::app.thumbnail'),
            'category' => trans('mymo_core::app.categories'),
        ]);
        
        $category = $request->post('categories', []);
        $tags = $request->post('tags', []);
        
        $model = Posts::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->setAttribute('category', implode(',', $category));
        $model->setAttribute('tags', implode(',', $tags));
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.saved_successfully'),
            'redirect' => route('admin.post'),
        ]);
    }

    public function update(Request $request, $id)
    {

    }
    
    public function bulkActions(Request $request)
    {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('mymo_core::app.posts')
        ]);
        
        Posts::destroy($request->post('ids'));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.deleted_successfully'),
        ]);
    }
}
