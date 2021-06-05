<?php

namespace Plugins\Movie\Http\Controllers;

use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;
use Plugins\Movie\Models\Category\Stars;
use Plugins\Movie\Models\Category\Tags;
use Plugins\Movie\Models\Category\Types;
use Plugins\Movie\Models\LiveTV\LiveTvCategory;
use Plugins\Movie\Models\Sliders;
use Plugins\Movie\Models\Category\Countries;
use Plugins\Movie\Models\Category\Genres;

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

    protected function loadLiveTvCategory(Request $request) {
        $search = $request->get('search');
        $explodes = $request->get('explodes');

        $query = LiveTvCategory::query();
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
}
