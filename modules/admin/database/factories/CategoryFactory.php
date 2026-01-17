<?php

namespace Juzaweb\Modules\Admin\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Juzaweb\Modules\Blog\Models\Category;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'parent_id' => null,
            'en' => [
                'name' => $this->faker->words(3, true),
                'description' => $this->faker->sentence(),
                'slug' => $this->faker->unique()->slug(),
                'locale' => 'en',
            ],
        ];
    }

    /**
     * Indicate that the category has a parent.
     */
    public function withParent(string $parentId): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => $parentId,
        ]);
    }
}
