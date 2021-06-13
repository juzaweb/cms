<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 6/12/2021
 * Time: 6:20 PM
*/

namespace Mymo\Installer\Helpers;


class Intaller
{
    /**
     * If application is already installed.
     *
     * @return bool
     */
    public static function alreadyInstalled()
    {
        return file_exists(static::installedPath());
    }

    public static function installedPath()
    {
        return storage_path('app/installed');
    }
}