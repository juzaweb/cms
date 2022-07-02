<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

use Juzaweb\Network\Http\Controllers\DashboardController;
use Juzaweb\Network\Http\Controllers\SiteController;

Route::get('/', [DashboardController::class, 'index']);

Route::jwResource('sites', SiteController::class);
