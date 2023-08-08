<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Juzaweb\CMS\Contracts\ActionRegisterContract;

class ServiceProvider extends BaseServiceProvider
{
    public array $bindings = [];

    protected function loadSeedsFrom($path): void
    {
        foreach (glob("{$path}/*.php") as $filename) {
            include $filename;
            $classes = get_declared_classes();
            $class = end($classes);

            $command = Request::server('argv', null);
            if (is_array($command)) {
                $command = implode(' ', $command);
                if ($command == "artisan db:seed") {
                    Artisan::call('db:seed', ['--class' => $class]);
                }
            }
        }
    }

    protected function registerHookActions(array|string $actions): void
    {
        if (is_string($actions)) {
            $actions = [$actions];
        }

        $this->app[ActionRegisterContract::class]->register($actions);
    }
}
