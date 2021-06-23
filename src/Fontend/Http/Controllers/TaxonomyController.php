<?php

namespace Mymo\Theme\Http\Controllers;

use Mymo\PostType\Models\Taxonomy;

class TaxonomyController
{
    public function index()
    {
        return view('pages.taxonomy');
    }

    public function content($slug)
    {
        $tax = Taxonomy::with(['translations'])
            ->where('slug', $slug)
            ->first();
        dd($tax);
    }
}
