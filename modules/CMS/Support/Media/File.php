<?php

namespace Juzaweb\CMS\Support\Media;

use Illuminate\Contracts\Filesystem\Filesystem;
use Intervention\Image\Facades\Image;
use Juzaweb\CMS\Contracts\Media\Disk as DiskContract;
use Juzaweb\CMS\Interfaces\Media\FileInterface;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\StorageAttributes;
use Symfony\Component\HttpFoundation\StreamedResponse;
use GuzzleHttp\Client;

class File implements FileInterface
{
    protected string $path;
    protected DiskContract $disk;

    public function __construct(string $path, DiskContract $disk)
    {
        $this->path = $path;
        $this->disk = $disk;
    }

    public function extension(): string
    {
        if (method_exists($this->disk->filesystem(), 'extension')) {
            return $this->disk->filesystem()->extension($this->path);
        }

        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

    public function mimeType(): string
    {
        return $this->filesystem()->mimeType($this->path);
    }

    public function fullPath(): string
    {
        return $this->filesystem()->path($this->path);
    }

    public function url(): string
    {
        return $this->filesystem()->url($this->path);
    }

    public function size(): int
    {
        return $this->filesystem()->size($this->path);
    }

    public function get(): string
    {
        return $this->filesystem()->get($this->path);
    }

    public function id(): string
    {
        $metas = $this->getMetadata();

        if (is_array($metas)) {
            return $metas['id'] ?? $this->path;
        }

        if ($metas instanceof StorageAttributes) {
            $data = $metas->jsonSerialize();
            return $data['extra_metadata']['id'] ?? $this->path;
        }

        return $this->path;
    }

    public function getMetadata(): array|StorageAttributes
    {
        if (method_exists($this->getAdapter(), 'getMetadata')) {
            return $this->getAdapter()->getMetadata($this->path);
        }

        return [];
    }

    public function delete(): bool
    {
        return $this->disk->filesystem()->delete($this->path);
    }

    public function download(?string $name = null, ?array $headers = []): StreamedResponse
    {
        return $this->filesystem()->download($this->path, $name, $headers);
    }

    public function isImage(): bool
    {
        return in_array($this->mimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    }

    public function stream(): StreamedResponse
    {
        $stream = function () {
            $stream = fopen($this->fullPath(), 'rb');

            while (!feof($stream)) {
                echo fread($stream, 1024 * 1024);
                flush();
            }

            fclose($stream);
        };

        $response = new StreamedResponse($stream);

        $response->headers->set('Content-Type', $this->mimeType());
        $response->headers->set('Content-Length', $this->size());

        return $response;
    }

    public function remoteStream(): StreamedResponse
    {
        $client = new Client();
        $response = $client->request(
            'GET',
            $this->url(),
            [
                'stream' => true,
            ]
        );

        $responseHeaders = $response->getHeaders();
        $contentType = $responseHeaders['Content-Type'][0];
        $contentLength = $responseHeaders['Content-Length'][0];

        $response = new StreamedResponse(
            function () use ($response) {
                $stream = $response->getBody();

                while (!$stream->eof()) {
                    echo $stream->read(1024 * 1024);
                    flush();
                }

                $stream->close();
            }
        );

        $response->headers->set('Content-Type', $contentType);
        $response->headers->set('Content-Length', $contentLength);

        return $response;
    }

    public function response()
    {
        if ($this->isImage()) {
            return Image::make($this->fullPath())->response();
        }

        throw new \RuntimeException('Not implemented');
    }

    public function path(): string
    {
        return $this->path;
    }

    public function disk(): DiskContract
    {
        return $this->disk;
    }

    public function canVisible(): bool
    {
        return $this->filesystem()->getVisibility($this->path) === 'public';
    }

    public function getAdapter(): FilesystemAdapter
    {
        return $this->filesystem()->getAdapter();
    }

    protected function filesystem(): Filesystem
    {
        return $this->disk()->filesystem();
    }
}
