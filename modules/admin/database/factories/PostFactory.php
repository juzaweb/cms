<?php

namespace Juzaweb\Modules\Admin\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Juzaweb\Modules\Blog\Models\Post;
use Juzaweb\Modules\Core\Enums\PostStatus;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => PostStatus::PUBLISHED,
            'en' => [
                'title' => $this->faker->sentence(),
                'content' => $this->faker->paragraphs(3, true),
                'slug' => $this->faker->unique()->slug(),
                'locale' => 'en',
            ],
        ];
    }

    /**
     * Indicate that the post is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PostStatus::DRAFT,
        ]);
    }

    /**
     * Indicate that the post is private.
     */
    public function private(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PostStatus::PRIVATE,
        ]);
    }
}
