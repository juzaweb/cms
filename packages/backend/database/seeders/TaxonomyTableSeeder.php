<?php

namespace Juzaweb\Backend\Database\Seeders;

use Illuminate\Database\Seeder;
use Juzaweb\Backend\Models\Taxonomy;

class TaxonomyTableSeeder extends Seeder
{
    public function run()
    {
        Taxonomy::factory(500)->create();
    }
}
