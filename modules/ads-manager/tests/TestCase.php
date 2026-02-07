<?php

namespace Juzaweb\Modules\AdsManagement\Tests;

use Juzaweb\Modules\Core\Tests\TestCase as BaseTestCase;
use Juzaweb\Modules\AdsManagement\Providers\AdManagementServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return array_merge(
            parent::getPackageProviders($app),
            [
                AdManagementServiceProvider::class,
            ]
        );
    }
}
