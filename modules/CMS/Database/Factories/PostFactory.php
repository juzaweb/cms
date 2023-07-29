<?php

namespace Juzaweb\CMS\Database\Factories;

use Illuminate\Support\Str;
use Juzaweb\Backend\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Juzaweb\CMS\Models\User;

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
    public function definition(): array
    {
        $title = $this->faker->sentence(10);
        $users = User::active()->inRandomOrder()->limit(10)->get()->pluck('id')->toArray();

        return [
            'title' => $title,
            'content' => $this->faker->paragraph(10),
            'status' => 'publish',
            'type' => 'posts',
            'slug' => Str::slug($title),
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => $users[array_rand($users)],
            'updated_by' => $users[array_rand($users)],
        ];
    }
}
