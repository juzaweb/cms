<?php

namespace Mymo\Backend\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Mymo\Backend\Http\Controllers\BackendController;
use Mymo\PostType\Repositories\TaxonomyRepository;
use Mymo\PostType\Services\TaxonomyService;

class TaxonomyController extends BackendController
{
    protected $taxonomyRepository;
    protected $taxonomyService;

    public function __construct(
        TaxonomyRepository $taxonomyRepository,
        TaxonomyService $taxonomyService
    )
    {
        $this->taxonomyRepository = $taxonomyRepository;
        $this->taxonomyService = $taxonomyService;
    }

    public function index($taxonomy)
    {
        $setting = $this->getSetting($taxonomy);
        $model = $this->taxonomyRepository->makeModel();

        return view('mymo_post_type::taxonomy.index', [
            'title' => $setting->get('label'),
            'setting' => $setting,
            'model' => $model,
            'taxonomy' => $taxonomy,
        ]);
    }

    public function create($taxonomy)
    {
        $setting = $this->getSetting($taxonomy);
        $model = $this->taxonomyRepository->makeModel();
        $this->addBreadcrumb([
            'title' => $setting->get('label'),
            'url' => route('admin.' . $setting->get('type') . '.taxonomy.index', [$taxonomy])
        ]);

        return view('mymo_post_type::taxonomy.form', [
            'model' => $model,
            'title' => trans('mymo_core::app.add_new'),
            'taxonomy' => $taxonomy,
            'setting' => $setting
        ]);
    }

    public function edit($taxonomy, $id)
    {
        $setting = $this->getSetting($taxonomy);
        $model = $this->taxonomyRepository->find($id);
        $model->load('parent');

        $this->addBreadcrumb([
            'title' => $setting->get('label'),
            'url' => route('admin.'. $setting->get('type') .'.taxonomy.index', [$taxonomy])
        ]);

        return view('mymo_post_type::taxonomy.form', [
            'model' => $model,
            'title' => $model->name,
            'taxonomy' => $taxonomy,
            'setting' => $setting
        ]);
    }

    public function getDataTable(Request $request, $taxonomy)
    {
        $setting = $this->getSetting($taxonomy);
        $search = $request->get('search');
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $query = $this->taxonomyRepository->makeQuery();
        $query->where('taxonomy', '=', $setting->get('taxonomy'));
        $query->where('post_type', '=', $setting->get('post_type'));

        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('name', 'like', '%'. $search .'%');
                $subquery->where('description', 'like', '%'. $search .'%');
            });
        }

        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();

        foreach ($rows as $row) {
            $row->edit_url = route("admin.{$setting->get('type')}.taxonomy.edit", [$taxonomy, $row->id]);
            $row->thumbnail = upload_url($row->thumbnail);
            $row->description = Str::words($row->description, 20);
        }

        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }

    public function store(Request $request, $taxonomy)
    {
        $model = $this->taxonomyService->create(array_merge($request->all(), [
            'post_type' => $this->getPostType(),
            'taxonomy' => $taxonomy
        ]));

        return $this->success([
            'message' => trans('mymo_core::app.successfully'),
            'html' => view('mymo_core::components.tag-item', [
                'item' => $model,
                'name' => $taxonomy,
            ])->render()
        ]);
    }

    public function update(Request $request, $taxonomy, $id)
    {
        $this->taxonomyService->update(array_merge($request->all(), [
            'post_type' => $this->getPostType(),
            'taxonomy' => $taxonomy
        ]), $id);

        return $this->success([
            'message' => trans('mymo_core::app.successfully')
        ]);
    }

    public function bulkActions(Request $request, $taxonomy)
    {
        $request->validate([
            'ids' => 'required|array',
            'action' => 'required',
        ]);

        do_action('bulk_action.taxonomy.' . $taxonomy, $request->post());

        $action = $request->post('action');
        $ids = $request->post('ids');

        switch ($action) {
            case 'delete':
                $this->taxonomyService->delete($ids);
                break;
        }

        return $this->success([
            'message' => trans('mymo_core::app.successfully')
        ]);
    }

    public function getTagComponent(Request $request, $taxonomy)
    {
        $item = $this->taxonomyRepository->findOrFail($request->input('id'));
        return $this->response([
            'html' => view('mymo_core::components.tag-item', [
                'item' => $item,
                'name' => $taxonomy
            ])
                ->render()
        ], true);
    }

    protected function getPostType()
    {
        $split = explode('.', Route::currentRouteName());
        return Str::plural($split[count($split) - 3]);
    }

    /**
     * Get taxonomy setting
     *
     * @param string $taxonomy
     * @return \Illuminate\Support\Collection
     **/
    protected function getSetting($taxonomy)
    {
        $taxonomies = apply_filters('mymo.taxonomies', []);
        return $taxonomies[$this->getPostType()][$taxonomy] ?? [];
    }
}
