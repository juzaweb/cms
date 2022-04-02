<?php

namespace Juzaweb\Crawler\Helpers;

use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Juzaweb\Backend\Models\MediaFile;
use Juzaweb\Multisite\Helpers\DatabaseConnection;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class PostImport
{
    public $importContentImages = true;

    protected $client;
    protected $storage;
    protected $tmp;
    protected $data;
    protected $siteId;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->tmp = Storage::disk('tmp');
        $this->storage = Storage::disk(
            config('juzaweb.filemanager.disk')
        );
    }

    public function import($data, $siteId)
    {
        $this->data = $data;
        $this->siteId = $siteId;
        
        $conn = DB::getDefaultConnection();

        if ($thumbnail = Arr::get($data, 'thumbnail')) {
            $data['thumbnail'] = $this->saveImage($thumbnail, $conn);
        }

        if ($this->importContentImages) {
            $data['content'] = $this->saveContentImages(
                $data['content'],
                $conn
            );
        }

        $categoryIds = $conn->table('taxonomies')
            ->whereIn('id', $data['category_ids'])
            ->pluck('id')
            ->toArray();

        DB::beginTransaction();
        try {
            $slug = sub_char($data['title'], 70, '');
            $slug = Str::slug($slug);

            $postId = $conn->table('posts')
                ->insertGetId(
                    [
                        'title' => $data['title'],
                        'content' => $data['content'],
                        'description' => seo_string($data['content'], 190),
                        'thumbnail' => $data['thumbnail'],
                        'status' => $data['status'],
                        'slug' => $slug,
                        'created_by' => $data['user_id'],
                        'updated_by' => $data['user_id'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]
                );

            $taxData = collect($categoryIds)
                ->take(5)
                ->map(
                    function ($item) use ($postId) {
                        return [
                            'term_id' => $postId,
                            'taxonomy_id' => $item,
                            'term_type' => 'posts',
                        ];
                    }
                )
                ->toArray();

            $conn->table('term_taxonomies')
                ->insert($taxData);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function saveContentImages($content, $conn)
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
            $image = $this->saveImage(trim($url), $conn);
            if (empty($image)) {
                continue;
            }

            $content = str_replace(
                $url,
                $this->storage->url($image),
                $content
            );
        }

        return $content;
    }

    protected function saveImage($url, $conn)
    {
        $uploadedFile = $this->downloadThumbnail($url);
        if ($this->fileImageIsValid($uploadedFile)) {
            $filename = $this->makeFilename($uploadedFile);
            $newPath = $this->storage->putFileAs(
                $this->makeFolderUpload(),
                $uploadedFile,
                $filename
            );

            if (config('juzaweb.filemanager.image-optimizer')) {
                if (in_array($uploadedFile->getMimeType(), $this->getImageMimetype())) {
                    $optimizerChain = OptimizerChainFactory::create();
                    $optimizerChain->optimize($this->storage->path($newPath));
                }
            }

            DB::beginTransaction();
            try {
                $data = [
                    'name' => $uploadedFile->getClientOriginalName(),
                    'type' => 'image',
                    'mime_type' => $uploadedFile->getMimeType(),
                    'path' => $newPath,
                    'size' => $uploadedFile->getSize(),
                    'extension' => $uploadedFile->getClientOriginalExtension(),
                    'user_id' => $this->data['user_id'],
                ];

                $conn->table(app(MediaFile::class)->getTable())
                    ->insert($data);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                if (config('app.debug')) {
                    throw $e;
                } else {
                    Log::error($e);
                }
                return null;
            }

            unlink($uploadedFile->getRealPath());

            return $newPath;
        }

        return null;
    }

    protected function fileImageIsValid($file)
    {
        if (empty($file)) {
            return false;
        }

        if (! $file instanceof UploadedFile) {
            return false;
        }

        if ($file->getError() != UPLOAD_ERR_OK) {
            return false;
        }

        $mimetype = $file->getMimeType();
        $config = config('juzaweb.filemanager.types.image');

        if (empty($config)) {
            return false;
        }

        // Bytes to MB
        $max_size = $config['max_size'];
        $file_size = $file->getSize();

        $validMimetypes = $config['valid_mime'] ?? [];
        if (in_array($mimetype, $validMimetypes) === false) {
            return false;
        }

        if ($max_size > 0 && $file_size > ($max_size * 1024 * 1024)) {
            return false;
        }

        return true;
    }

    protected function getImageMimetype()
    {
        return config('juzaweb.filemanager.types.image.valid_mime');
    }

    protected function downloadThumbnail($thumbnail)
    {
        try {
            $content = $this->client->get($thumbnail, [
                'timeout' => 10
            ])
                ->getBody()
                ->getContents();

            $tempName = jw_basename($thumbnail);
            $this->tmp->put($tempName, $content);

            $uploadedFile = new UploadedFile(
                $this->tmp->path($tempName),
                $tempName
            );

            return $uploadedFile;
        } catch (RequestException $e) {
            $content = false;
        }

        return $content;
    }

    protected function makeFolderUpload()
    {
        $folderPath = date('Y/m/d');

        // Make Directory if not exists
        if (! $this->storage->exists($folderPath)) {
            File::makeDirectory(
                $this->storage->path($folderPath),
                0775,
                true
            );
        }

        return $folderPath;
    }

    protected function makeFilename(UploadedFile $file)
    {
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        $filename = str_replace('.' . $extension, '', $filename);
        $filename = Str::slug(substr($filename, 0, 50));
        $filename = $filename . '-'. Str::random(15) .'.' . $extension;

        return $this->replaceInsecureSuffix($filename);
    }

    protected function replaceInsecureSuffix($name)
    {
        return preg_replace("/\.php$/i", '', $name);
    }
}
