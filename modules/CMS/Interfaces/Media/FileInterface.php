<?php

namespace Juzaweb\CMS\Interfaces\Media;

use League\Flysystem\FilesystemAdapter;
use League\Flysystem\StorageAttributes;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface FileInterface
{
    public function path(): string;

    public function fullPath(): string;

    public function delete(): bool;

    public function id(): string;

    public function mimeType(): string;

    public function isImage(): bool;

    public function remoteStream(): StreamedResponse;

    public function stream(): StreamedResponse;

    public function canVisible(): bool;

    public function get(): string;

    public function getMetadata(): array|StorageAttributes;

    public function getAdapter(): FilesystemAdapter;
}
