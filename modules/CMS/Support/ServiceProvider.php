<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Support;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    protected function loadSeedsFrom($path)
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
}
