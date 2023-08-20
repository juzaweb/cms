<?php

namespace Juzaweb\CMS\Interfaces\Media;

use League\Flysystem\FilesystemAdapter;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface FileInterface
{
    public function path(): string;

    public function fullPath(): string;

    public function delete(): bool;

    public function mimeType(): string;

    public function isImage(): bool;

    public function remoteStream(): StreamedResponse;

    public function stream(): StreamedResponse;

    public function canVisible(): bool;

    public function get(): string;

    public function getMetadata(): array;

    public function getAdapter(): FilesystemAdapter;
}
