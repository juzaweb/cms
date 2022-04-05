<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 5/25/2021
 * Time: 10:05 PM
 */

namespace Juzaweb\CMS\Support;

class Breadcrumb
{
    public static function render($name, $items = [])
    {
        return view(static::getNameView($name), [
            'items' => $items,
        ]);
    }

    public static function getNameView($name)
    {
        return apply_filters('breadcrumb.render', [
            'admin' => 'cms::items.breadcrumb',
        ])[$name];
    }
}
