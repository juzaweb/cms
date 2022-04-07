<?php

namespace Juzaweb\Movie\Helpers;

use Illuminate\Support\Arr;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Support\FileManager;
use Illuminate\Support\Facades\DB;

class ImportMovie
{
    public $data;
    public $errors = [];
    
    public function __construct(array $data)
    {
        $fillData = [
            'title',
            'origin_title',
            'description',
            'content',
            'type_id',
            'poster',
            'rating',
            'release',
            'runtime',
            'video_quality',
            'trailer_link',
            'current_episode',
            'max_episode',
            'year',
            'thumbnail',
            'poster',
            'tv_series',
        ];
        
        $arrayData = [
            'genres',
            'countries',
            'actors',
            'writers',
            'directors',
            'tags'
        ];
        
        foreach ($fillData as $item) {
            if (!isset($data[$item])) {
                $data[$item] = null;
            } else {
                $data[$item] = trim($data[$item]);
            }
        }
    
        foreach ($arrayData as $item) {
            if (!isset($data[$item])) {
                $data[$item] = [];
            }
        }
        
        $this->data = $data;
    }

    /**
     * Save import movie.
     *
     * @return Post|false
     * @throws \Throwable
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        DB::beginTransaction();

        try {
            $model = Post::create(array_merge($this->data, [
                'thumbnail' => FileManager::addFile($this->data['thumbnail'])->path,
                'status' => Post::STATUS_PUBLISH,
                'type' => 'movies'
            ]));

            $year = explode('-', $this->data['release'] ?? '')[0];

            $model->syncMetas([
                'tv_series' => $this->data['tv_series'] ? 1 : 0,
                'video_quality' => $this->data['video_quality'] ?? 'HD',
                'release' => $this->data['release'] ?? null,
                'year' => $year,
                'trailer_link' => Arr::get($this->data, 'trailer_link'),
                'poster' => FileManager::addFile($this->data['poster'])->path,
            ]);

            $model->syncTaxonomies([
                'genres' => $this->getTaxonomyIds(
                    $this->data['genres'],
                    'genres'
                ),
                'countries' => $this->getTaxonomyIds(
                    $this->data['countries'],
                    'countries'
                ),
                'actors' => $this->getTaxonomyIds(
                    $this->data['actors'],
                    'actors'
                ),
                'writers' => $this->getTaxonomyIds(
                    $this->data['writers'],
                    'writers'
                ),
                'directors' => $this->getTaxonomyIds(
                    $this->data['directors'],
                    'directors'
                ),
                'tags' => $this->getTaxonomyIds(
                    $this->data['tags'],
                    'tags'
                ),
                'years' => $this->getTaxonomyIds(
                    [
                        [
                            'name' => $year
                        ]
                    ],
                    'years'
                )
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return $model;
    }

    public function validate()
    {
        if (empty($this->data['title'])) {
            $this->errors[] = 'Title is required.';
        }
    
        if (empty($this->data['content'])) {
            $this->errors[] = 'Content is required.';
        }
    
        if (empty($this->data['thumbnail'])) {
            $this->errors[] = 'Thumbnail is required.';
        }
        
        if (empty($this->data['genres'])) {
            $this->errors[] = 'Genres is required.';
        }
        
        if (is_null($this->data['tv_series'])) {
            $this->errors[] = 'TV Series is required.';
        }

        if (count($this->errors) > 0) {
            return false;
        }
        
        return true;
    }
    
    protected function getTaxonomyIds($genres, $type)
    {
        if (is_string($genres)) {
            return $genres;
        }

        $genres = collect($genres)->take(5)->toArray();
        $result = [];
        foreach ($genres as $genre) {
            if ($genre['name']) {
                $result[] = $this->addOrGetTaxonomy($genre['name'], $type);
            }
        }

        return $result;
    }

    protected function addOrGetTaxonomy($name, $type)
    {
        $name = trim($name);

        $model = Taxonomy::firstOrCreate([
            'taxonomy' => $type,
            'name' => $name,
            'post_type' => 'movies'
        ]);

        return $model->id;
    }
}
