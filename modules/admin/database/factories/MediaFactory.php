<?php

namespace Juzaweb\Modules\Admin\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Juzaweb\Modules\Core\Models\Media;
use Juzaweb\Modules\Core\Models\Model;

/**
 * @extends Factory<Model>
 */
class MediaFactory extends Factory
{
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $filename = $this->faker->uuid() . '.jpg';

        return [
            'name' => $filename,
            'path' => 'tests/' . $filename,
            'mime_type' => 'image/jpeg',
            'size' => 102400, // 100KB
            'type' => 'file',
            'extension' => 'jpg',
            'image_size' => '200x200',
            'disk' => 'public',
        ];
    }
}
