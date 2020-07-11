<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Models\Configs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeoSettingController extends Controller
{
    public function index() {
        return view('backend.setting.seo.index');
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'author_name' => 'required|string|max:300',
            'movies_title' => 'required|string|max:300',
            'movies_keywords' => 'nullable|string|max:300',
            'movies_description' => 'nullable|string|max:300',
            'tv_series_title' => 'required|string|max:300',
            'tv_series_keywords' => 'nullable|string|max:300',
            'tv_series_description' => 'nullable|string|max:300',
            'blog_title' => 'required|string|max:300',
            'blog_keywords' => 'nullable|string|max:300',
            'blog_description' => 'nullable|string|max:300',
            'facebook' => 'nullable|string|max:300',
            'twitter' => 'nullable|string|max:300',
            'linkedin' => 'nullable|string|max:300',
            'youtube' => 'nullable|string|max:300',
            'title' => 'required|string|max:300',
            'description' => 'nullable|string|max:300',
            'keywords' => 'nullable|string|max:300',
        ], $request, [
            'author_name' => trans('app.author_name'),
            'movies_title' => trans('app.movies_title'),
            'movies_keywords' => trans('app.movies_keywords'),
            'movies_description' => trans('app.movies_description'),
            'tv_series_title' => trans('app.tv_series_title'),
            'tv_series_keywords' => trans('app.tv_series_keywords'),
            'tv_series_description' => trans('app.tv_series_description'),
            'blog_title' => trans('app.blog_title'),
            'blog_keywords' => trans('app.blog_keywords'),
            'blog_description' => trans('app.blog_description'),
            'facebook' => 'Facebook URL',
            'twitter' => 'Twitter URL',
            'linkedin' => 'Linkedin URL',
            'youtube' => 'Youtube URL',
            'title' => trans('app.home_title'),
            'description' => trans('app.home_description'),
            'keywords' => trans('app.keywords'),
        ]);
    
        $configs = $request->only([
            'title',
            'description',
            'keywords',
            'author_name',
            'movies_title',
            'movies_keywords',
            'movies_description',
            'tv_series_title',
            'tv_series_keywords',
            'tv_series_description',
            'blog_title',
            'blog_keywords',
            'blog_description',
            'facebook',
            'twitter',
            'linkedin',
            'youtube',
        ]);
    
        foreach ($configs as $key => $config) {
            Configs::setConfig($key, $config);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.setting.comment'),
        ]);
    }
}
