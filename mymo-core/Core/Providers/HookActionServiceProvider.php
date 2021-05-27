<?php
/**
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/25/2021
 * Time: 10:05 PM
 */

namespace Mymo\Core\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Mymo\Core\Facades\HookAction;

class HookActionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        HookAction::loadActionForm(__DIR__ . '/../actions');

        $this->app->booted(function () {
            $paths = apply_filters('mymo.actions', []);

            foreach ($paths as $path) {
                if (!is_dir($path)) {
                    continue;
                }

                $files = File::allFiles($path);
                foreach ($files as $file) {
                    require_once($file->getRealPath());
                }
            }
        });
    }
}
