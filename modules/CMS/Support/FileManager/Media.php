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
use Juzaweb\CMS\Models\Model;

class Media
{
    protected MediaFileRepository $fileRepository;
    protected MediaFolderRepository $folderRepository;
    protected Model $model;

    public function __construct(
        MediaFileRepository $fileRepository,
        MediaFolderRepository $folderRepository,
        Model $model
    ) {
        $this->fileRepository = $fileRepository;
        $this->folderRepository = $folderRepository;
        $this->model = $model;
    }
}
