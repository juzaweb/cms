<?php
/**
 * @package    tadcms\tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/tadcms/tadcms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/14/2021
 * Time: 9:06 PM
 */

namespace Tadcms\System\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class HookActionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            $paths = apply_filters('tadcms.actions', []);
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
