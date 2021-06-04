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
 * Date: 5/30/2021
 * Time: 12:08 PM
 */

Route::postTypeResource('posts', 'PostController');

//Route::mymoResource('post/{taxonomy}', 'TaxonomyController');

Route::mymoResource('post/comments', 'TaxonomyController');

