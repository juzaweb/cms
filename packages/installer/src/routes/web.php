<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 */

use Juzaweb\Installer\Http\Controllers\AdminController;
use Juzaweb\Installer\Http\Controllers\DatabaseController;
use Juzaweb\Installer\Http\Controllers\EnvironmentController;
use Juzaweb\Installer\Http\Controllers\PermissionsController;
use Juzaweb\Installer\Http\Controllers\RequirementsController;
use Juzaweb\Installer\Http\Controllers\WelcomeController;

Route::group([
    'prefix' => 'install',
    'middleware' => 'install',
], function () {
    Route::get('/', [WelcomeController::class, 'welcome'])->name('installer.welcome');
    Route::get('environment', [EnvironmentController::class, 'environment'])->name('installer.environment');

    Route::post('environment', [EnvironmentController::class, 'save'])->name('installer.environment.save');

    Route::get('requirements', [RequirementsController::class, 'requirements'])->name('installer.requirements');

    Route::get('permissions', [PermissionsController::class, 'permissions'])->name('installer.permissions');

    Route::get('database', [DatabaseController::class, 'database'])->name('installer.database');

    Route::get('admin', [AdminController::class, 'index'])->name('installer.admin');

    Route::post('admin', [AdminController::class, 'save'])->name('installer.admin.save');

    Route::get('final', [FinalController::class, 'finish'])->name('installer.finish');
});
