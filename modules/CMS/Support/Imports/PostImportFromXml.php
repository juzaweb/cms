<?php

namespace Juzaweb\CMS\Support\Imports;

use Illuminate\Support\Facades\Storage;
use Juzaweb\CMS\Support\Collections\BloggerCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Support\FileManager;

class PostImportFromXml
{
    protected string $file;

    protected string $type;

    protected int $chunkSize = 50;

    protected int $userId;

    protected array $errors;

    public function __construct()
    {
        //
    }

    public function import(string $file, string $type): static
    {
        $this->file = $file;

        $this->type = $type;

        $data = $this->getCacheInfo();

        $items = $this->collection()->forPage($data['next_page'], $this->chunkSize);

        foreach ($items as $item) {
            $item = (array) $item;
            DB::beginTransaction();
            try {
                if ($item['thumbnail'] && is_url($item['thumbnail'])) {
                    $thumb = FileManager::addFile(
                        $item['thumbnail'],
                        'image',
                        null,
                        $this->userId
                    );
                    $item['thumbnail'] = $thumb->path;
                } else {
                    $item['thumbnail'] = null;
                }

                $item['type'] = 'posts';
                $item['status'] = 'publish';
                $item['created_by'] = $this->userId;
                $item['updated_by'] = $this->userId;

                $model = new Post();
                $model->fill($item);
                $model->slug = $model->generateSlug($item['slug']);
                $model->save();
                $model->syncTaxonomies(
                    [
                        'categories' => $this->getCreateTaxonomies($item['categories'])
                    ]
                );
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                report($e);
                $this->errors[] = $e->getMessage();
            }
        }

        if ($data['next_page'] + 1 <= $data['max_page']) {
            $this->setCacheInfo(['next_page' => $data['next_page'] + 1]);
        } else {
            Cache::store('file')->pull($this->getCacheKey());
        }

        return $this;
    }

    public function setUserID($userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function getCreateTaxonomies(array $categories)
    {
        $taxonomies = [];

        foreach ($categories as $category) {
            $taxonomy = Taxonomy::firstOrCreate(
                [
                    'name' => $category,
                    'taxonomy' => 'categories',
                    'post_type' => 'posts'
                ]
            );

            $taxonomies[] = $taxonomy->id;
        }

        return $taxonomies;
    }

    protected function setCacheInfo(array $data)
    {
        $info = Cache::store('file')->get($this->getCacheKey(), []);

        $info = array_merge($info, $data);

        Cache::store('file')->forever($this->getCacheKey(), $info);

        return $info;
    }

    public function getCacheInfo(): array
    {
        if ($info = Cache::store('file')->get($this->getCacheKey())) {
            return $info;
        }

        $collection = $this->collection();

        $cacheData = [
            'total' => $collection->count(),
            'next_page' => 1,
            'max_page' => $collection->chunk($this->chunkSize)->count()
        ];

        Cache::store('file')->forever($this->getCacheKey(), $cacheData);

        return $cacheData;
    }

    protected function collection()
    {
        switch ($this->type) {
            case 'blogger':
                return app(BloggerCollection::class)->getCollection($this->getFilePath());
        }

        return false;
    }

    protected function getCacheKey()
    {
        return cache_prefix('import_' . md5($this->file));
    }

    protected function getFilePath()
    {
        return Storage::disk('public')->path($this->file);
    }
}
