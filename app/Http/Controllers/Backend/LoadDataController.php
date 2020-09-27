<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sliders;
use Illuminate\Http\Request;
use App\Models\Category\Countries;
use App\Models\Category\Genres;
use App\Models\Menu;
use App\Models\PostCategories;
use App\Models\Category\Stars;
use App\Models\Category\Tags;
use App\Models\Category\Types;
use App\User;

class LoadDataController extends Controller
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
    
    protected function loadGenres(Request $request) {
        $search = $request->get('search');
        $explodes = $request->get('explodes');
        
        $query = Genres::query();
        $query->select([
            'id',
            'name AS text'
        ]);
        
        if ($search) {
            $query->where('name', 'like', '%'. $search .'%');
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
    
    protected function loadTypes(Request $request) {
        $search = $request->get('search');
        $explodes = $request->get('explodes');
        
        $query = Types::query();
        $query->select([
            'id',
            'name AS text'
        ]);
        
        if ($search) {
            $query->where('name', 'like', '%'. $search .'%');
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
    
    protected function loadCountries(Request $request) {
        $search = $request->get('search');
        $explodes = $request->get('explodes');
        
        $query = Countries::query();
        $query->select([
            'id',
            'name AS text'
        ]);
        
        if ($search) {
            $query->where('name', 'like', '%'. $search .'%');
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
    
    protected function loadActors(Request $request) {
        $search = $request->get('search');
        $explodes = $request->get('explodes');
        
        $query = Stars::query();
        $query->select([
            'id',
            'name AS text'
        ]);
        
        if ($search) {
            $query->where('name', 'like', '%'. $search .'%');
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
    
    protected function loadDirectors(Request $request) {
        $search = $request->get('search');
        $explodes = $request->get('explodes');
        
        $query = Stars::query();
        $query->select([
            'id',
            'name AS text'
        ]);
        
        $query->where('type', '=', 'director');
        
        if ($search) {
            $query->where('name', 'like', '%'. $search .'%');
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
    
    protected function loadWriters(Request $request) {
        $search = $request->get('search');
        $explodes = $request->get('explodes');
        
        $query = Stars::query();
        $query->select([
            'id',
            'name AS text'
        ]);
        
        $query->where('type', '=', 'writer');
        
        if ($search) {
            $query->where('name', 'like', '%'. $search .'%');
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
    
    protected function loadTags(Request $request) {
        $search = $request->get('search');
        $explodes = $request->get('explodes');
    
        $query = Tags::query();
        $query->select([
            'id',
            'name AS text'
        ]);
        
        if ($search) {
            $query->where('name', 'like', '%'. $search .'%');
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
    
    protected function loadPostCategories(Request $request) {
        $search = $request->get('search');
        $explodes = $request->get('explodes');
    
        $query = PostCategories::query();
        $query->select([
            'id',
            'name AS text'
        ]);
    
        if ($search) {
            $query->where('name', 'like', '%'. $search .'%');
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
    
    protected function loadSliders(Request $request) {
        $search = $request->get('search');
        $explodes = $request->get('explodes');
        
        $query = Sliders::query();
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
}
