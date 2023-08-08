<?php

namespace Juzaweb\CMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;

class PostTableSeeder extends Seeder
{
    public function run(): void
    {
        Post::factory(20)->create()->each(
            function ($item) {
                $categories = Taxonomy::where('taxonomy', '=', 'categories')
                    ->where('post_type', '=', 'posts')
                    ->inRandomOrder()
                    ->limit(3);

                $tags = Taxonomy::where('taxonomy', '=', 'tags')
                    ->where('post_type', '=', 'posts')
                    ->inRandomOrder()
                    ->limit(5);

                $item->syncTaxonomies(
                    [
                        'categories' => $categories->pluck('id')->toArray(),
                        'tags' => $tags->pluck('id')->toArray(),
                    ]
                );
            }
        );
    }
}
