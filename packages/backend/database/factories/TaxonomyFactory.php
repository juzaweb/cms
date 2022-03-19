<?php

namespace Juzaweb\Backend\Database\Factories;

use Illuminate\Support\Str;
use Juzaweb\Backend\Models\Taxonomy;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxonomyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Taxonomy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name;
        $taxonomies = ['categories', 'tags'];
        $taxonomy = $taxonomies[array_rand($taxonomies, 1)];
        $parents = [
            null,
            Taxonomy::where('taxonomy', '=', $taxonomy)
                ->orderBy('id', 'DESC')
                ->first()->id ?? null
        ];
        $parentId = $parents[array_rand($parents)];

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'taxonomy' => $taxonomy,
            'parent_id' => $parentId,
            'post_type' => 'posts',
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
