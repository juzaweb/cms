<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenresController extends Controller
{
    public function index() {
        return view('backend.genres.index');
    }
    
    public function getData() {
    
    }
}
