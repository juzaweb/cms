<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Tool\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\Support\FileManager;
use Juzaweb\Traits\MultisiteCli;

class ImportBlogger implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels,
        MultisiteCli;

    public $timeout = 3600;

    protected $file;
    protected $siteId;
    protected $userId;

    public function __construct($file, $userId, $siteId)
    {
        $this->file = $file;
        $this->userId = $userId;
        $this->siteId = $siteId;
    }

    public function handle()
    {
        $this->setUpSite($this->siteId);

        $storage = Storage::disk('public')->path($this->file);
        $xmlString = file_get_contents($storage);
        $xmlObject = simplexml_load_string($xmlString);

        $json = json_encode($xmlObject);
        $data = json_decode($json, true);
        $data = collect(Arr::get($data, 'entry', []))->filter(function ($item) {
            return (strpos($item['id'], 'post-')
                && $item['author']['name'] != 'Unknown'
                && strpos($item['category']['@attributes']['term'] ?? '', 'kind#comment') === false);
        })->reverse()->all();

        foreach ($data as $item) {
            DB::beginTransaction();
            try {
                $collect = $this->collectData($item);
                $model = new Post();
                $model->fill($collect);
                $model->setAttribute('site_id', $this->siteId);
                $model->slug = $model->generateSlug($collect['slug']);
                $model->save();
                $model->syncTaxonomies(['categories' => $collect['categories']]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e);
            }
        }
    }

    protected function collectData($item)
    {
        $href = Arr::get($item, 'link')[count($item['link']) - 1]['@attributes']['href'];
        $slug = last(explode('/', $href));
        $slug = str_replace('.html', '', $slug);

        try {
            $thumb = (str_get_html($item['content']))->find('img', 0)->src;

            $thumb = FileManager::addFile(
                $thumb,
                'image',
                null,
                $this->userId
            );
            $thumb = $thumb->path;
        } catch (\Exception $e) {
            $thumb = null;
        }

        $data = [];
        $data['title'] = $item['title'];
        $data['content'] = $item['content'];
        $data['type'] = 'posts';
        $data['status'] = 'publish';
        $data['created_by'] = $this->userId;
        $data['updated_by'] = $this->userId;
        $data['thumbnail'] = $thumb;
        $data['slug'] = $slug;

        $categories = collect($item['category'])
            ->filter(function ($item) {
                return ($item['@attributes']['scheme'] ?? '') == 'http://www.blogger.com/atom/ns#';
            })
            ->map(function ($item) {
                return $item['@attributes']['term'];
            })
            ->values()
            ->toArray();

        $data['categories'] = $this->getCreateCategories($categories);

        return $data;
    }

    protected function getCreateCategories(array $categories)
    {
        $taxonomies = [];

        foreach ($categories as $category) {
            $taxonomy = Taxonomy::firstOrCreate([
                'name' => $category,
                'taxonomy' => 'categories',
                'post_type' => 'posts'
            ]);

            $taxonomies[] = $taxonomy->id;
        }

        return $taxonomies;
    }
}
