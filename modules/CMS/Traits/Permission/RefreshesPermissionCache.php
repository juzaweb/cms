<?php

namespace Juzaweb\CMS\Traits\Permission;

use Juzaweb\CMS\Support\Permission\PermissionRegistrar;

trait RefreshesPermissionCache
{
    public static function bootRefreshesPermissionCache()
    {
        static::saved(
            function () {
                app(PermissionRegistrar::class)->forgetCachedPermissions();
            }
        );

        static::deleted(
            function () {
                app(PermissionRegistrar::class)->forgetCachedPermissions();
            }
        );
    }
}
