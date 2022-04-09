<?php

namespace Juzaweb\CMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Juzaweb\Backend\Models\Taxonomy;

class TaxonomyTableSeeder extends Seeder
{
    public function run()
    {
        Taxonomy::factory(20)->create();
    }
}
