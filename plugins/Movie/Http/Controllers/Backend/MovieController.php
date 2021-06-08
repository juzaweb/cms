<?php

namespace Plugins\Movie\Http\Controllers\Backend;

use Plugins\Movie\Http\Requests\MovieRequest;
use Plugins\Movie\Models\Movie\Movie;
use Mymo\Core\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MovieController extends BackendController
{
    public function index()
    {
        return view('movie::movies.index', [
            'title' => trans('movie::app.movies')
        ]);
    }
    
    public function getDataTable(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        $genre = $request->get('genre');
        $country = $request->get('country');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Movie::query();
        $query->where('tv_series', '=', 0);
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
                $subquery->orWhere('description', 'like', '%'. $search .'%');
            });
        }
    
        if ($genre) {
            $query->whereRaw('find_in_set(?, genres)', [$genre]);
        }
    
        if ($country) {
            $query->whereRaw('find_in_set(?, countries)', [$country]);
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
            $row->description = Str::words(strip_tags($row->description), 15);
            $row->edit_url = route('admin.movies.edit', [$row->id]);
            $row->preview_url = route('watch', [$row->slug]);
            $row->upload_url = route('admin.movies.servers', ['movies', $row->id]);
            $row->download_url = route('admin.movies.download', ['movies', $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }

    public function create()
    {
        $this->addBreadcrumb([
            'title' => trans('movie::app.movie'),
            'url' => route('admin.movies.index')
        ]);

        $model = new Movie();

        return view('movie::movies.form', [
            'model' => $model,
            'title' => trans('movie::app.add_new'),
        ]);
    }

    public function edit($id)
    {
        $model = Movie::findOrFail($id);

        return view('movie::movies.form', [
            'model' => $model,
            'title' => $model->name,
        ]);
    }
    
    public function save(MovieRequest $request)
    {
        $model = Movie::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->setAttribute('short_description', sub_words(strip_tags($model->description), 15));
        if ($model->release) {
            $model->year = explode('-', $model->release)[0];
        }
        
        $model->save();
        $model->syncTaxonomies($request->all());

        return $this->success([
            'message' => trans('mymo_core::app.saved_successfully'),
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
                Movie::destroy($ids);
                break;
            case 'public':
            case 'private':
            case 'draft':
                foreach ($ids as $id) {
                    Movie::update([
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
