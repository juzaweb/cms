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
use Juzaweb\Backend\Http\Controllers\Installer\AdminController;
use Juzaweb\Backend\Http\Controllers\Installer\DatabaseController;
use Juzaweb\Backend\Http\Controllers\Installer\EnvironmentController;
use Juzaweb\Backend\Http\Controllers\Installer\FinalController;
use Juzaweb\Backend\Http\Controllers\Installer\PermissionsController;
use Juzaweb\Backend\Http\Controllers\Installer\RequirementsController;
use Juzaweb\Backend\Http\Controllers\Installer\WelcomeController;

Route::group(
    [
        'prefix' => 'install',
        'middleware' => 'install',
    ],
    function () {
        Route::get('/', [WelcomeController::class, 'welcome'])->name('installer.welcome');
        Route::get('environment', [EnvironmentController::class, 'environment'])->name('installer.environment');

        Route::post('environment', [EnvironmentController::class, 'save'])->name('installer.environment.save');

        Route::get('requirements', [RequirementsController::class, 'requirements'])->name('installer.requirements');

        Route::get('permissions', [PermissionsController::class, 'permissions'])->name('installer.permissions');

        Route::get('database', [DatabaseController::class, 'database'])->name('installer.database');

        Route::get('admin', [AdminController::class, 'index'])->name('installer.admin');

        Route::post('admin', [AdminController::class, 'save'])->name('installer.admin.save');

        Route::get('final', [FinalController::class, 'finish'])->name('installer.finish');
    }
);

Route::group(
    [
        'middleware' => 'guest',
        'as' => 'admin.',
        'prefix' => config('juzaweb.admin_prefix'),
        'namespace' => 'Juzaweb\CMS\Http\Controllers',
    ],
    function () {
        Auth::routes();
    }
);
