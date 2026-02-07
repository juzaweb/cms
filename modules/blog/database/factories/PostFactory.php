<?php

namespace Juzaweb\Modules\Blog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Juzaweb\Modules\Blog\Models\Post;
use Juzaweb\Modules\Core\Enums\PostStatus;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => PostStatus::PUBLISHED->value,
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'description' => $this->faker->text(200),
        ];
    }
}
