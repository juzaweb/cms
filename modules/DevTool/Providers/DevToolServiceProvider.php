<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\DevTool\Providers;

use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\CMS\Support\Stub;

class DevToolServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setupStubPath();
        $this->app->register(ConsoleServiceProvider::class);
    }

    /**
     * Setup stub path.
     */
    public function setupStubPath(): void
    {
        Stub::setBasePath(__DIR__ . '/../stubs/plugin');
    }
}
