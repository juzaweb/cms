<?php

namespace Juzaweb\Modules\Admin\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Juzaweb\Modules\Core\Enums\PageStatus;
use Juzaweb\Modules\Core\Models\Pages\Page;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => PageStatus::PUBLISHED,
            'template' => null,
            'en' => [
                'title' => $this->faker->sentence(),
                'content' => $this->faker->paragraphs(3, true),
                'slug' => $this->faker->unique()->slug(),
                'locale' => 'en',
            ],
        ];
    }

    /**
     * Indicate that the page is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PageStatus::DRAFT,
        ]);
    }

    /**
     * Indicate that the page has a specific template.
     */
    public function withTemplate(string $template): static
    {
        return $this->state(fn (array $attributes) => [
            'template' => $template,
        ]);
    }
}
