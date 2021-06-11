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
 * Date: 6/10/2021
 * Time: 3:22 PM
 */

//Route::get('/', 'HomeController@index')->name('home');

Route::get('/search', 'SearchController@index')->name('search');

Route::get('/login', 'HomeController@index')->name('login');

Route::get('/register', 'HomeController@index')->name('register');

//Route::get('/{slug}', 'PageController@index')
//    ->name('page')
//    ->where('slug', '[a-z0-9\-]+');
//
//Route::get('/{base}/{slug}', 'RouteController@index')
//    ->name('frontend')
//    ->where('base', '^((?!admin\-cp|api)[a-z0-9\-])*$')
//    ->where('slug', '[a-z0-9\-]+');
