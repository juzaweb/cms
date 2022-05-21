<?php

namespace Juzaweb\CMS\Support;

use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Juzaweb\Backend\Events\MediaWasUploaded;
use Juzaweb\CMS\Exceptions\FileManagerException;
use Juzaweb\Backend\Models\MediaFile;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use GuzzleHttp\Exception\RequestException;

class FileManager
{
    /**
     * @var Storage
     */
    protected $storage;

    protected $resource;

    protected $resource_type;

    protected $folder_id;

    protected $user_id;

    protected $client;

    protected string $type = 'image';

    protected array $errors = [];

    /**
     * Add file
     *
     * @param $file
     * @param string $type
     * @param int|null $folderId
     * @param int|null $userId
     *
     * @return MediaFile
     * @throws FileManagerException
     * @throws \Exception
     */
    public static function addFile(
        $file,
        string $type = 'image',
        int|null $folderId = null,
        int|null $userId = null
    ): MediaFile {
        return (new self())
            ->withResource($file)
            ->setType($type)
            ->setFolder($folderId)
            ->setUserId($userId)
            ->save();
    }

    public function __construct()
    {
        $this->storage = Storage::disk(config('juzaweb.filemanager.disk'));
        $this->client = new Client();
    }

    /**
     * Add resource for upload
     *
     * @param $resource
     * @return $this
     *
     * @throws \Exception
     */
    public function withResource($resource): static
    {
        $this->resource = $resource;

        if (is_a($this->resource, UploadedFile::class)) {
            $this->resource_type = 'uploaded';
        }

        if (filter_var($this->resource, FILTER_VALIDATE_URL)) {
            $this->resource_type = 'url';
        }

        if (is_string($this->resource) && file_exists($this->resource)) {
            $this->resource_type = 'path';
        }

        if (empty($this->resource_type)) {
            throw new \Exception('Resource type unsupported.');
        }

        return $this;
    }

    /**
     * Set media Folder
     *
     * @param int|null $folderId
     * @return $this
     */
    public function setFolder(?int $folderId): static
    {
        if (empty($folderId) || $folderId <= 0) {
            $folderId = null;
        }

        $this->folder_id = $folderId;

        return $this;
    }

    /**
     * Set media Type
     *
     * @param string|null $type
     * @return $this
     */
    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function setUserId($userId): static
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * @return MediaFile
     *
     * @throws FileManagerException
     * @throws \Exception
     */
    public function save(): MediaFile
    {
        global $jw_user;

        $uploadedFile = $this->makeUploadedFile();

        if (! $this->fileIsValid($uploadedFile)) {
            $this->removeUploadedFile($uploadedFile);
            throw new FileManagerException($this->errors);
        }

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

        try {
            $media = MediaFile::create(
                [
                    'name' => $uploadedFile->getClientOriginalName(),
                    'type' => $this->type,
                    'mime_type' => $uploadedFile->getMimeType(),
                    'path' => $newPath,
                    'size' => $uploadedFile->getSize(),
                    'extension' => $uploadedFile->getClientOriginalExtension(),
                    'folder_id' => $this->folder_id,
                    'user_id' => $this->user_id ?: $jw_user->id,
                ]
            );
        } catch (\Exception $e) {
            $this->removeUploadedFile($uploadedFile);
            throw $e;
        }

        $this->removeUploadedFile($uploadedFile);

        event(new MediaWasUploaded($media));

        return $media;
    }

    protected function getImageMimetype()
    {
        return config('juzaweb.filemanager.types.image.valid_mime');
    }

    protected function makeFolderUpload(): string
    {
        $folderPath = date('Y/m/d');

        // Make Directory if not exists
        if (! $this->storage->exists($folderPath)) {
            File::makeDirectory($this->storage->path($folderPath), 0775, true);
        }

        return $folderPath;
    }

    /**
     * Make Uploaded File
     * @return UploadedFile
     */
    protected function makeUploadedFile(): UploadedFile
    {
        return match ($this->resource_type) {
            'path' => $this->makeUploadedFileByPath(),
            'url' => $this->makeUploadedFileByUrl(),
            default => $this->resource,
        };
    }

    /**
     * Make Uploaded File By Path
     * @return UploadedFile
     */
    protected function makeUploadedFileByPath(): UploadedFile
    {
        return (new UploadedFile($this->resource, basename($this->resource)));
    }

    /**
     * Make Uploaded File By Url
     * @return UploadedFile
     *
     * @throws \Exception
     */
    protected function makeUploadedFileByUrl(): UploadedFile
    {
        $content = $this->getContentFileUrl($this->resource);
        if (empty($content)) {
            throw new \Exception("Can't get file url: {$this->resource}");
        }

        $tempName = basename($this->resource);
        $this->storage->put($tempName, $content);

        return (new UploadedFile($this->storage->path($tempName), $tempName));
    }

    protected function makeFilename(UploadedFile $file): string|null
    {
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace('.' . $extension, '', $filename);
        $filename = Str::slug(substr($filename, 0, 50));
        $filename = $filename . '-'. strtolower(Str::random(15)) .'.' . $extension;
        return $this->replaceInsecureSuffix($filename);
    }

    protected function replaceInsecureSuffix($name): string|null
    {
        return preg_replace("/\.php$/i", '', $name);
    }

    protected function fileIsValid($file): bool
    {
        if (empty($file)) {
            $this->errors[] = $this->errorMessage('file-empty');

            return false;
        }

        if (! $file instanceof UploadedFile) {
            $this->errors[] = $this->errorMessage('instance');

            return false;
        }

        if ($file->getError() != UPLOAD_ERR_OK) {
            $msg = 'File failed to upload. Error code: ' . $file->getError();
            $this->errors[] = $msg;

            return false;
        }

        $mimetype = $file->getMimeType();
        $config = config('juzaweb.filemanager.types.' . $this->type);

        if (empty($config)) {
            $this->errors[] = $this->errorMessage('not-supported');

            return false;
        }

        // Bytes to MB
        $max_size = $config['max_size'];
        $file_size = $file->getSize();

        $validMimetypes = $config['valid_mime'] ?? [];
        if (in_array($mimetype, $validMimetypes) === false) {
            $this->errors[] = $this->errorMessage('mime').$mimetype;

            return false;
        }

        if ($max_size > 0) {
            if ($file_size > ($max_size * 1024 * 1024)) {
                $this->errors[] = $this->errorMessage('size');

                return false;
            }
        }

        return true;
    }

    protected function getContentFileUrl($url): bool|string
    {
        try {
            $content = $this->client->get(
                $url,
                [
                    'timeout' => 10
                ]
            )
                ->getBody()
                ->getContents();
        } catch (RequestException $e) {
            $content = false;
        }

        return $content;
    }

    protected function errorMessage($key): array|string
    {
        return trans('cms::filemanager.error-' . $key);
    }

    protected function removeUploadedFile(UploadedFile $file): void
    {
        if (in_array($this->resource_type, ['url', 'path'])) {
            unlink($file->getRealPath());
        }
    }
}
