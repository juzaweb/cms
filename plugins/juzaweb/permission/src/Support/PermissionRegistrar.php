<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Permission\Support;

use Juzaweb\Facades\Site;
use Spatie\Permission\PermissionRegistrar as BaseRegistrar;

class PermissionRegistrar extends BaseRegistrar
{
    public function initializeCache()
    {
        self::$cacheExpirationTime = config('permission.cache.expiration_time');

        self::$teams = config('permission.teams', false);
        self::$teamsKey = config('permission.column_names.team_foreign_key');

        self::$cacheKey = config('permission.cache.key');

        self::$pivotRole = config('permission.column_names.role_pivot_key') ?: 'role_id';
        self::$pivotPermission = config('permission.column_names.permission_pivot_key') ?: 'permission_id';

        $this->cache = $this->getCacheStoreFromConfig();
    }
}
