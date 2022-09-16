<?php

namespace Juzaweb\Backend\Http\Controllers\Backend\Setting;

use Illuminate\Http\Request;
use Juzaweb\CMS\Http\Controllers\Controller;
use Juzaweb\CMS\Models\Config;

class SeoSettingController extends Controller
{
    public function index()
    {
        return view('cms::backend.setting.seo.index');
    }

    public function save(Request $request)
    {
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
            'pinterest' => 'nullable|string|max:300',
            'youtube' => 'nullable|string|max:300',
            'title' => 'required|string|max:300',
            'description' => 'nullable|string|max:300',
            'keywords' => 'nullable|string|max:300',
        ], $request, [
            'author_name' => trans('cms::app.author_name'),
            'movies_title' => trans('cms::app.movies_title'),
            'movies_keywords' => trans('cms::app.movies_keywords'),
            'movies_description' => trans('cms::app.movies_description'),
            'tv_series_title' => trans('cms::app.tv_series_title'),
            'tv_series_keywords' => trans('cms::app.tv_series_keywords'),
            'tv_series_description' => trans('cms::app.tv_series_description'),
            'blog_title' => trans('cms::app.blog_title'),
            'blog_keywords' => trans('cms::app.blog_keywords'),
            'blog_description' => trans('cms::app.blog_description'),
            'facebook' => 'Facebook URL',
            'twitter' => 'Twitter URL',
            'pinterest' => 'Linkedin URL',
            'youtube' => 'Youtube URL',
            'title' => trans('cms::app.home_title'),
            'description' => trans('cms::app.home_description'),
            'keywords' => trans('cms::app.keywords'),
        ]);

        $configs = $request->only([
            'title',
            'description',
            'keywords',
            'banner',
            'author_name',
            'movies_title',
            'movies_keywords',
            'movies_description',
            'movies_banner',
            'tv_series_title',
            'tv_series_keywords',
            'tv_series_description',
            'tv_series_banner',
            'blog_title',
            'blog_keywords',
            'blog_description',
            'blog_banner',
            'latest_movies_title',
            'latest_movies_keywords',
            'latest_movies_description',
            'latest_movies_banner',
            'facebook',
            'twitter',
            'pinterest',
            'youtube',
        ]);

        foreach ($configs as $key => $config) {
            Config::setConfig($key, $config);
        }

        return response()->json([
            'status' => 'success',
            'message' => trans('cms::app.saved_successfully'),
            'redirect' => route('admin.setting.seo'),
        ]);
    }
}
