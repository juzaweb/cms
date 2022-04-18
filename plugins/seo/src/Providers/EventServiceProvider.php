<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Seo\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Juzaweb\Backend\Events\AfterPostSave;
use Juzaweb\Seo\Listeners\SaveSeoMetaPost;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        AfterPostSave::class => [
            SaveSeoMetaPost::class
        ]
    ];

    public function boot()
    {
        //
    }
}
