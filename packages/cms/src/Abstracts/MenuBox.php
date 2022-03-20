<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Abstracts;

use Illuminate\Support\Collection;
use Illuminate\View\View;
use Juzaweb\Backend\Models\MenuItem;

abstract class MenuBox
{
    /**
     * Get data from request
     *
     * @param array $data
     * @return array
     *
     * Return multi data to map menu_items table
     */
    abstract public function mapData($data);

    /**
     * Get data for item menu
     *
     * @param array $item //
     *
     *
     * @return array
     * Return data to map menu_items table
     */
    abstract public function getData($item);

    /**
     * Get view for add item
     *
     * @return View
     */
    abstract public function addView();

    /**
     * Get view for edit item
     *
     * @param MenuItem $item
     * @return View
     */
    abstract public function editView($item);

    /**
     * Get link for item
     *
     * @param Collection $menuItems
     * @return array // array url
     */
    abstract public function getLinks($menuItems);
}
