<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Events;

use Juzaweb\Backend\Models\MediaFile;

class UploadFileSuccess
{
    public function __construct(public MediaFile $file)
    {
    }
}
