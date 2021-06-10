<?php

namespace Mymo\Theme\Http\Controllers;

use Tadcms\System\Models\Taxonomy;

class TaxonomyController
{
    public function index()
    {
        return view('pages.taxonomy');
    }

    public function content($slug)
    {
        $tax = Taxonomy::with(['translations'])
            ->whereTranslation('slug', $slug)
            ->first();
        dd($tax);
    }
}
