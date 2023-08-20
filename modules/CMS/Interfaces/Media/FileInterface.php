<?php

namespace Juzaweb\CMS\Interfaces\Media;

use Symfony\Component\HttpFoundation\StreamedResponse;

interface FileInterface
{
    public function path(): string;

    public function fullPath(): string;

    public function delete(): bool;

    public function downloadUrl(int $livetime = 3600): string;

    public function mimeType(): string;

    public function isImage(): bool;

    public function remoteStream(): StreamedResponse;

    public function stream(): StreamedResponse;

    public function canVisible(): bool;
}
