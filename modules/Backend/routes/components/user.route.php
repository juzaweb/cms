<?php
/**
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/juzacms
 * @license    GNU V2
 *
 * Created by JUZAWEB.
 * Date: 5/25/2021
 * Time: 9:02 PM
 */

use Juzaweb\Backend\Http\Controllers\Backend\RoleController;
use Juzaweb\Backend\Http\Controllers\Backend\UserController;

Route::jwResource('users', UserController::class);

Route::jwResource('roles', RoleController::class);
