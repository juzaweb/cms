<?php

namespace App\Http\Controllers\Backend;

use App\Models\Countries;
use App\Models\Genres;
use App\Models\PostCategories;
use App\Models\Stars;
use App\Models\Tags;
use App\Models\Types;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
