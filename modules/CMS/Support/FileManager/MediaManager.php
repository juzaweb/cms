<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Support\FileManager;

use Juzaweb\Backend\Repositories\MediaFileRepository;
use Juzaweb\Backend\Repositories\MediaFolderRepository;
use Juzaweb\CMS\Contracts\MediaManagerContract;
use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Repositories\BaseRepository;

class MediaManager implements MediaManagerContract
{
    protected MediaFileRepository $fileRepository;
    protected MediaFolderRepository $folderRepository;

    public function __construct(
        MediaFileRepository $fileRepository,
        MediaFolderRepository $folderRepository
    ) {
        $this->fileRepository = $fileRepository;
        $this->folderRepository = $folderRepository;
    }

    public function find(string|int|Model $media, string $type = 'file'): null|Media
    {
        if ($media instanceof Model) {
            return $this->createMedia($media);
        }

        if (is_numeric($media)) {
            $model = $this->getRepositoryByType($type)
                ->findByField('id', $media)
                ->first();
        } else {
            $model = $this->getRepositoryByType($type)
                ->findByField('path', $media)
                ->first();
        }

        return $this->createMedia($model);
    }

    public function findFile(string|int|Model $file): null|Media
    {
        return $this->find($file, 'file');
    }

    public function findFolder(string|int|Model $folder): null|Media
    {
        return $this->find($folder, 'folder');
    }

    protected function getRepositoryByType(string $type = 'file'): BaseRepository
    {
        if ($type == 'file') {
            return $this->fileRepository;
        }

        return $this->folderRepository;
    }

    protected function createMedia(Model $model): Media
    {
        return new Media($model);
    }
}
