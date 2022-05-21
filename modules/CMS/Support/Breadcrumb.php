<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/juzacms
 * @license    GNU V2
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
