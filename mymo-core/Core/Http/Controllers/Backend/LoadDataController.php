<?php

namespace Mymo\Core\Http\Controllers\Backend;

use Illuminate\Database\Eloquent\Builder;
use Mymo\Core\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use Mymo\Core\Models\Menu;
use Mymo\Core\Models\User;
use Mymo\PostType\Models\Taxonomy;

class LoadDataController extends BackendController
{
    public function loadData($func, Request $request) {
        if (method_exists($this, $func)) {
            return $this->{$func}($request);
        }
        
        return response()->json([
            'status' => 'error',
            'message' => 'Function not found',
        ]);
    }

    protected function loadTaxonomies(Request $request)
    {
        $search = $request->get('search');
        $explodes = $request->get('explodes');
        $postType = $request->get('post_type');
        $taxonomy = $request->get('taxonomy');

        $query = Taxonomy::query();
        $query->select([
            'id',
            'name as text'
        ])
            ->where('post_type', '=', $postType)
            ->where('taxonomy', '=', $taxonomy);

        if ($search) {
            $query->whereTranslationLike('name', '%'. $search .'%');
        }

        if ($explodes) {
            $query->whereNotIn('id', $explodes);
        }

        $paginate = $query->paginate(10);
        $data['results'] = $query->get();

        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }

        return response()->json($data);
    }
    
    protected function loadUsers(Request $request) {
        $search = $request->get('search');
        $explodes = $request->get('explodes');
        
        $query = User::query();
        $query->select([
            'id',
            'name AS text'
        ]);
        
        if ($search) {
            $query->where(function ($sub) use ($search) {
                $sub->orWhere('name', 'like', '%'. $search .'%');
                $sub->orWhere('email', 'like', '%'. $search .'%');
            });
        }
        
        if ($explodes) {
            $query->whereNotIn('id', $explodes);
        }
        
        $paginate = $query->paginate(10);
        $data['results'] = $query->get();
        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }
        
        return response()->json($data);
    }
    
    protected function loadMenu(Request $request) {
        $search = $request->get('search');
        $explodes = $request->get('explodes');
        
        $query = Menu::query();
        $query->select([
            'id',
            'name AS text'
        ]);
        
        if ($search) {
            $query->where(function ($sub) use ($search) {
                $sub->orWhere('name', 'like', '%'. $search .'%');
            });
        }
        
        if ($explodes) {
            $query->whereNotIn('id', $explodes);
        }
        
        $paginate = $query->paginate(10);
        $data['results'] = $query->get();
        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }
        
        return response()->json($data);
    }

    protected function loadCountryName(Request $request) {
        $search = $request->get('search');
        $explodes = $request->get('explodes');
    
        $query = LiveTvCategory::query();
        $query->select([
            'code AS id',
            'name AS text'
        ]);
    
        if ($search) {
            $query->where(function (Builder $builder) use ($search) {
                $builder->where('code', 'like', '%'. $search .'%');
                $builder->where('name', 'like', '%'. $search .'%');
            });
        }
    
        if ($explodes) {
            $query->whereNotIn('code', $explodes);
        }
    
        $paginate = $query->paginate(10);
        $data['results'] = $query->get();
        
        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }
    
        return response()->json($data);
    }
}
