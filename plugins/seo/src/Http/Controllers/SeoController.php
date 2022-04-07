<?php

namespace Juzaweb\Seo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Juzaweb\CMS\Http\Controllers\BackendController;

class SeoController extends BackendController
{
    public function getStringRaw(Request $request)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $slug = $request->input('slug');

        if (empty($slug)) {
            $slug = $title;
        }

        return response()->json([
            'title' => seo_string($title, 70),
            'description' => seo_string($description, 320),
            'slug' => Str::slug(seo_string($slug, 70)),
        ]);
    }
}
