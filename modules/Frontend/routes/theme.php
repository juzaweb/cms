<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

use Juzaweb\CMS\Support\Route\Auth;

Auth::routes();

if (config('juzaweb.frontend.enable')) {
    require __DIR__ . '/components/profile.route.php';

    require __DIR__ . '/components/sitemap.route.php';

    require __DIR__ . '/components/feed.route.php';

    require __DIR__ . '/components/page.route.php';
} else {
    Route::get('/', fn() => redirect(config('juzaweb.admin_prefix')));
}
