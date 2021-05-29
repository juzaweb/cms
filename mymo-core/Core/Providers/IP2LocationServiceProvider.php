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
 * Date: 5/25/2021
 * Time: 10:05 PM
 */

namespace Mymo\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Mymo\Core\Helpers\IP2Location;

class IP2LocationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind('ip2location', IP2Location::class);
    }
}
