<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Support\Imports;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Repositories\TaxonomyRepository;
use Juzaweb\CMS\Contracts\HookActionContract;
use Juzaweb\CMS\Contracts\PostCreatorContract;
use Juzaweb\CMS\Contracts\PostImporterContract;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Support\FileManager;

class PostImporter implements PostImporterContract
{
    protected PostCreatorContract $postCreator;

    protected HookActionContract $hookAction;

    protected TaxonomyRepository $taxonomyRepository;

    public function __construct(
        PostCreatorContract $postCreator,
        HookActionContract $hookAction,
        TaxonomyRepository $taxonomyRepository
    ) {
        $this->postCreator = $postCreator;

        $this->hookAction = $hookAction;

        $this->taxonomyRepository = $taxonomyRepository;
    }

    public function import(array $data, array $options = []): Post
    {
        if (empty($data['type'])) {
            throw new \Exception('Post type is required for import.');
        }

        if ($thumbnail = Arr::get($data, 'thumbnail')) {
            $data['thumbnail'] = $this->addMediaFromUrl($thumbnail, 'image', $options);
        }

        if (Arr::get($options, 'import_content_images', true)) {
            $data['content'] = $this->saveContentImages($data['content'], $options);
        }

        $taxonomies = $this->hookAction->getTaxonomies($data['type']);

        foreach ($taxonomies as $key => $taxonomy) {
            if ($tax = Arr::get($data, $key)) {
                $data[$key] = $this->getOrCreateTaxonomies($taxonomy, $tax);
            }
        }

        return $this->postCreator->create($data);
    }

    protected function getOrCreateTaxonomies($taxonomy, array $data): array
    {
        $ids = [];
        $names = [];
        $slugs = [];

        foreach ($data as $item) {
            if (is_numeric($item)) {
                $ids[] = $item;
                continue;
            }

            if (is_string($item)) {
                $names[] = [
                    'name' => trim($item)
                ];
                continue;
            }

            $item['name'] = trim($item['name']);
            $item['post_type'] = trim($item['post_type']);
            $item['taxonomy'] = trim($item['taxonomy']);
            $item['slug'] = isset($item['slug']) ? trim($item['slug']) : null;

            if (Arr::get($item, 'slug')) {
                $slugs[] = $item;
            } else {
                $names[] = $item;
            }
        }

        $ids = array_merge(
            $ids,
            $this->createTaxonomiesFromNames($names, $taxonomy)
        );

        return array_merge(
            $ids,
            $this->createTaxonomiesFromSlugs($slugs, $taxonomy)
        );
    }

    protected function createTaxonomiesFromSlugs($inserts, $taxonomy): array
    {
        $slugs = collect($inserts);

        $taxs = $this->taxonomyRepository->query()
            ->whereIn('post_type', $taxonomy->post_type)
            ->whereIn('taxonomy', $taxonomy->taxonomy)
            ->whereIn('slug', $slugs->pluck('slug')->toArray())
            ->get(['id', 'slug'])
            ->keyBy('slug');

        $slugs = $slugs
            ->filter(
                function ($item) use ($taxs) {
                    return !$taxs->get($item['slug']);
                }
            );

        $ids = [];
        foreach ($slugs as $slug) {
            $ids[] = $this->taxonomyRepository->create($slug)->id;
        }

        return array_merge($taxs->pluck('id')->toArray(), $ids);
    }

    protected function createTaxonomiesFromNames($inserts, $taxonomy): array
    {
        $names = collect($inserts);

        $taxs = $this->taxonomyRepository->query()
            ->whereIn('post_type', $taxonomy->post_type)
            ->whereIn('taxonomy', $taxonomy->taxonomy)
            ->whereIn('name', $names->pluck('name')->toArray())
            ->get(['id', 'name'])
            ->keyBy('name');

        $names = $names
            ->filter(
                function ($item) use ($taxs) {
                    return !$taxs->get($item['name']);
                }
            )->map(
                function ($item) {
                    $item['name'] = trim($item['name']);
                    $item['slug'] = Str::slug($item['name']);
                    return $item;
                }
            );

        $ids = [];
        foreach ($names as $name) {
            $ids[] = $this->taxonomyRepository->create($name)->id;
        }

        return array_merge($taxs->pluck('id')->toArray(), $ids);
    }

    protected function saveContentImages($content, array $options)
    {
        $html = str_get_html($content);

        $imgs = $html->find('img');

        if (empty($imgs)) {
            return $content;
        }

        $urls = [];
        foreach ($imgs as $e) {
            $url = $e->src;
            if (empty($url)) {
                $url = $e->{'data-src'};
            }

            if ($url) {
                $urls[] = $url;
            }
        }

        $urls = array_unique($urls);

        foreach ($urls as $url) {
            $image = $this->addMediaFromUrl(trim($url), 'image', $options);

            if (empty($image)) {
                continue;
            }

            $content = str_replace(
                $url,
                $image,
                $content
            );
        }

        return $content;
    }

    protected function addMediaFromUrl(
        string $url,
        string $type = 'image',
        array $options = []
    ): string {
        $createUserId = $options['created_by'] ?? User::where(['is_admin' => 1])->first()->id;

        $file = FileManager::addFile(
            $url,
            $type,
            $options['media_folder'] ?? null,
            $createUserId
        );

        return $file->path;
    }
}
